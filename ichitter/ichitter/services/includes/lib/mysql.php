<?php
class MYsql{
	public function query_Exe($sql){
		return mysql_query($sql);
	}
	
	public function fetch_row($data){		
		return mysql_fetch_assoc($data);
	}
	
}
?>