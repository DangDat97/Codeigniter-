<?php
class M_general extends CI_Model{
public function __construct(){
parent:: __construct();
$this->load->database();
// $this->db->escape_like_str() 
//    '%'.$this->db->escape_like_str($search_term).'%'
}

function save($a){
write_file('cron/query/query.sql',$a.";\r\n","a+");
}


public function query_multiple($sqls){
$array_return=array();
$count=count($sqls);

for ($i=0; $i <= $count-1 ; $i++) { 
$re=$this->db->query($sqls[$i]);
$array_return[$i]=$re->result_array();
}
return $array_return; 
}

public function query_sql_nor($sql){
    $this->db->query($sql);
  
    }


public function query_sql($sql){
$re=$this->db->query($sql);
return $re->result_array();
}

public function m_insert($table,$data){
$re=$this->db->insert($table,$data);
$a = $this->db->last_query();
$this->save($a);
return $this->db->insert_id();
}

public function m_insert_batch($table,$data){
$this->db->insert_batch($table,$data);
$a = $this->db->last_query();
$this->save($a);
return '1';
}

public function m_insert_not_duplicate($field,$data_field,$table,$data){ 
$this->db->where($field, $data_field);
$q = $this->db->get($table);
$this->db->reset_query();
if ( $q->num_rows() == 0 ) 
{
$re=$this->db->insert($table,$data);
return '1';
}else return '0';
}

public function m_get_data($fields,$table,$conditions){
$sql="SELECT $fields from $table $conditions";
$que=$this->db->query($sql);
return $que->row_array();
}


//m_get_data_v2('x,y,z','table','where id = ? and status = ? ',array('1','2'))
public function m_get_data_v2($fields,$table,$conditions,$data_con){
//$sql = "SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?";
//$this->db->query($sql, array(3, 'live', 'Rick'));
$sql="SELECT $fields from $table $conditions";
$que=$this->db->query($sql,$data_con);
return $que->row_array();
}


public function m_get_datas($field,$table,$conditions,$order){
$sql="SELECT $field from $table $conditions order by $order";
$re=$this->db->query($sql);
return $re->result_array();
}


public function m_update($table,$field,$conditions){
$sql="UPDATE $table set $field $conditions";
$this->db->query($sql);
$this->save($sql);
}


public function m_update_multiple($table,$field_update,$data_update,$field_condition,$data_condition){
$this->db->set($field_update,$data_update);
$this->db->where_in($field_condition,$data_condition);
$this->db->update($table);
$a = $this->db->last_query();
$this->save($a);
}

public function m_updates($id,$table,$data){
$this->db->where("id",$id);
$re=$this->db->update($table,$data);	
$a = $this->db->last_query();
$this->save($a);
}

public function m_delete($id,$table) {
$this->db->where("id",$id);
$this->db->delete($table);
$a = $this->db->last_query();
$this->save($a);
}

public function m_delete_multiple($table,$field_condition,$data_condition) {
$this->db->where_in($field_condition,$data_condition);
$this->db->delete($table);
$a = $this->db->last_query();
$this->save($a);
}

public function m_delete_condition($conditions,$table) {
$sql="DELETE from $table where $conditions";
$this->db->query($sql);
$a = $this->db->last_query();
$this->save($a);
}

public function m_count_all($table,$conditions){ 
$sql="SELECT count(id) as count from $table $conditions";
$que=$this->db->query($sql);
$re=$que->row_array();
return $re['count'];
}



}