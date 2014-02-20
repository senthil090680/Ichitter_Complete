<?php
class DiscussionTree {

	var $ARRAY;
	
	public function __construct($array = array()) {
		$this->ARRAY = $array;
	}

	public function createTree() {
		$treeData = array();
		$output = "";
		// Create the output
		$this->fetchTree($treeData);

		$output = <<<HTML
HTML;

		// Add the DIV hierachy.
		$this->buildHtml($treeData, $output, "inbox2", 0);
		return $output;
	}

	private function fetchTree(&$parentArray, $parentID = null) {
		if ($parentID == null) {
			$parentID = 0;
		}

		foreach ($this->ARRAY as $key => $row) {
			// Create a child array for the current ID
			if ($row['parentid'] == $parentID) {
				$currentID = $row['id'];
				$parentArray[$currentID] = array('rec' => $row['rec']);
				// Print all children of the current ID
				$this->fetchTree($parentArray[$currentID], $currentID);
			}
		}
	}

	private function buildHtml($data, &$output, $cls, $parent, $width=704, $width1=690) {
		$class = "inbox1";
		if ($cls == "inbox1") {
			$class = "inbox2";
		}
		
		foreach ($data as $_id => $discussion) {
			if ($_id == "rec") {
				$post_date = $discussion['posted_date'];
				$Pcls = $class;
				if ($discussion['for_discussion_id'] == "0") {
					$Pcls .= " bright btm ";
					$width = 684;
					$width1=670;
				} else if ($discussion['for_discussion_id'] != $parent) {
					$Pcls .= " btm";
					$width = ((int)$width - 20);
					$width1= ((int)$width1 - 20);
				}
				$discid = $discussion['discussion_id'];
				$parent = $discussion['for_discussion_id'];
				$img = $discussion['image'];
				$img_arr = explode('$', $img);
				$img_arrCnt = count($img_arr);
				$imgSrc = "";
				if($img_arr[0] == 'm') {
					$imgSrc = "resource/images/male-small.jpg";
				} else {
					$imgSrc = "resource/images/female-small.jpg";
				}
				
				if(isset($img_arr[2]) || isset($img_arr[3])) {
					$imgSrc = IMAGE_UPLOAD_SERVER;
					if(isset($img_arr[1])) {
						$imgSrc .= $discussion['user_id'] . '/';
					}
					if(isset($img_arr[2])) {
						$imgSrc .= $img_arr[2];
						if($img_arrCnt>3) {
							$imgSrc .= '/';
						}
					}
					if(isset($img_arr[3])) {
						$imgSrc .= $img_arr[3];
					}
				}
				$output .= '<div class="curveone">';
				$output .= '<div class="curveouterone">';
				$output .= '<div class="inner roundinnerone">';
				$output .= '<div class="' . $Pcls . '" style="width:' . $width .'px;">';
				$output .= '<div class="trigger" id="' . $discid . '"><div style="float:left; width:'. $width1 . 'px; clear:right; height:auto;"><div class="disphotos"><img src="' .$imgSrc . '" /></div>';
				$output .= '<div class="distitle"><a href="javascript:;">' . $discussion['fullname'] . '</a>, <span>' . $post_date . '</span></div>';
	//<a href="#" class="dname">' . $discussion['fullname'] . ', </a><span> ' . $post_date . '</span>';
				$output .= '<div class="open disrighttxt"><p class="discuss"><a href="javascript: void(0);"  id="' . $discid . '">VIEW AND REPLY</a></p></div></div></div>';
				$output .= '<div class="toggle_container">
						<div class="block"><p>' . $discussion['discussion_content'] . '</p><div class="reply"><p class="discuss"><a href="javascript: void(0);"  id="' . $discid . '">REPLY</a></p></div><div class="brk"></div></div>';
				continue;
			} else {
				$this->buildHtml($discussion, $output, $class, $parent, $width, $width1);
			}

			if ($_id != "rec") {
				$output .= '<span class="span_' . $_id . '"><div class="brk"></div><textarea style="width: 95%; height:100px; margin: 15px 0 0 8px; resize: none;" name="' . PARAM_CONTENT . '_' . $_id . '" id="' . PARAM_CONTENT . '_' . $_id . '"></textarea>
					<div class="brk"></div><div class="replycomment"><a href="javascript: void(0);" id="replycomment"></a></div></span>';
			}
			$output .= '</div></div><div class="brk"></div>';
			$output .= '</div></div></div>';
		}
	}
}
?>