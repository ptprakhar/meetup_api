<?php

/***************************************************
****************************************************
  @auther : Prakhar
  @method : GET, POST, PUT
  @description
  This API ReturnS the list of participants registered

*****************************************************/  


require APPPATH.'libraries/REST_Controller.php';

class Participants extends REST_Controller{

  public function __construct(){

    parent::__construct();
    $this->load->library(array("form_validation"));
    $this->load->helper("security");

    $this->load->model('ParticipantModel');

  }





public function index_get($limit = 0, $offset = 10){


    $participantsData = $this->ParticipantModel->get_participants( intval($limit), intval($offset) );
    
    if( !empty($participantsData) )
    {

          //If Data is not empty form DB
          $this->response(
            array(
                "status" => true,
                "message" => "Data Fount",
                "data" => [$participantsData]
          ), REST_Controller::HTTP_OK);


    }
    else
    {
          //If there is no data in database
          $this->response(
            array(
                "status" => false,
                "message" => "No data found",
                "data" => []
          ), REST_Controller::HTTP_OK);

    }

      

}


public function index_post($limit = 0, $offset = 10){


    $participantsData = $this->ParticipantModel->get_participants( intval($limit), intval($offset) );
    
    if( !empty($participantsData) )
    {

          //If Data is not empty form DB
          $this->response(
            array(
                "status" => true,
                "message" => "Data Fount",
                "data" => [$participantsData]
          ), REST_Controller::HTTP_OK);


    }
    else
    {
          //If there is no data in database
          $this->response(
            array(
                "status" => false,
                "message" => "No data found",
                "data" => []
          ), REST_Controller::HTTP_OK);

    }

      

}







}
 ?>
