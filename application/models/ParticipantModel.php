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
  

  public function get_participants($offset, $limit){
   // $query = $this->db->get('participants', $limit, $offset);

      //  echo $this->db->limit($offset,$limit)->get_compiled_select('', FALSE);

        $this->db->select('*');
        $this->db->from('participants');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();


        return $query->result();
  }


   public function insert_data($table, $data = array()){
       return $this->db->insert($table, $data);
   }


   public function delete_data($table, $id){
     // delete method
     $this->db->where("id", $id);
     return $this->db->delete($table);
   }


   public function update_data($table, $id, $data){
      $this->db->where("id", $id);
      return $this->db->update($table, $data);
      


   }


  public function checkDataById($id){
        
        $this->db->select('*');
        $this->db->from('participants');


        $this->db->where('id', $id);
        $query = $this->db->get();
        $data = $query->result();
        
        if(empty($data)) return FALSE;
        else return true;
  }



}