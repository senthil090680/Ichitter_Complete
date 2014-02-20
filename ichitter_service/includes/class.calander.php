<?php

class CalEvents extends commonGeneric {

    private $ObjJSON;

    function __construct() {
        $this->ObjJSON = new Services_JSON();
    }

    public function create_event($data) {
        
        $sql = "INSERT INTO tbl_events SET event_user_id = '" . $data['event_user_id'] . "', event_title = '" . $data['event_title'] . "', event_date = '" . $data['event_date'] . "', event_description = '" . $data['event_description'] . "', event_group_id = '" . $data['group_id'] . "', event_created_on = NOW(),event_flag = 1";
        //return $sql;
        $result = $this->query_Exe($sql);
        $l_id = mysql_insert_id();
        if ($result == 1) {
            $result = $this->ObjJSON->encode(array('success' => $l_id));
        } else {
            $result = $this->ObjJSON->encode(array('error' => 1));
        }
        return $result;
    }

    public function delete_event($data) {
        
        $e = 0;
        $t = 0;
        $this->transaction_start();
        
        foreach ($data as $k => $v) {
            if (strpos($k, 'cal_list_') !== false) {
                $t += 1;
                $sql = "DELETE FROM tbl_events WHERE event_id = " . $v;
                $result = $this->query_Exe($sql);
                if ($result == 1) {
                    $e += 1;
                }
            }
        }
        $return = '';
        if($t == $e){
            $this->transaction_commit();
            $return = $this->ObjJSON->encode(array('success' => 1));
            
        }else{
            $this->transaction_rollback();
            $return = $this->ObjJSON->encode(array('error' => 1));
        }
        
        return $return;
        
    }
    
    public function event_edit($data){
        
        $sql = "UPDATE tbl_events SET event_title = '" . $data['event_title'] . "', event_description = '" . $data['event_description'] . "', event_flag = 1 WHERE event_id = ".$data['id'];
       $result = $this->query_Exe($sql);
       
       if($result == 1){
            
            $return = $this->ObjJSON->encode(array('success' => 1));
            
        }else{
            
            $return = $this->ObjJSON->encode(array('error' => 1));
        }
        
        
        //$return = $this->ObjJSON->encode(array('sql' => $sql));
        
        return $return;
    }

}

?>