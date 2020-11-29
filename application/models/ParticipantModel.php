<?php

/***
@author prakhar

@description
Participant model for db operations 

***/


class ParticipantModel extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  

  public function get_participants($limit=0, $offset=10){
    $query = $this->db->get_where('participants', array(), $limit, $offset);
    return $query->result();
  }


   public function insert_data($data = array()){
       return $this->db->insert("tbl_students", $data);
   }


   public function delete_data($table, $id){
     // delete method
     $this->db->where("id", $student_id);
     return $this->db->delete("tbl_students");
   }


   public function update_data($table, $id, $data){
      $this->db->where("id", $id);
      return $this->db->update("tbl_students", $informations);
   }
}