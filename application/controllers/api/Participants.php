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
    $this->load->helper('custom');

  }



/***
Mehtod :: GET
***/

public function index_get($limit = 0, $offset = 10){


    $participantsData = $this->ParticipantModel->get_participants( intval($limit), intval($offset) );
    
    if( !empty($participantsData) )
    {

          //If Data is not empty form DB
          $this->response(
            array(
                "status" => true,
                "message" => "Data Found",
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


/***
method :: POST
***/


public function index_post($limit = 0, $offset = 10){
  //Storing the data 
  //POST Mehtod


    // collecting form data inputs
    $name = $this->security->xss_clean($this->input->post("name"));
    $age = $this->security->xss_clean($this->input->post("age"));
    $dob = $this->security->xss_clean($this->input->post("dob"));
    $profession = $this->security->xss_clean($this->input->post("profession"));
    $locality = $this->security->xss_clean($this->input->post("Locality"));
    $no_of_guests = $this->security->xss_clean($this->input->post("no_of_guests"));
    $address = $this->security->xss_clean($this->input->post("address"));


    // form validation for inputs
    $this->form_validation->set_rules("name", "name", "required");
    $this->form_validation->set_rules("age", "Age", "required");
    $this->form_validation->set_rules("dob", "D.O.B", "required|(/0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}/]");
    $this->form_validation->set_rules("profession", "Profession", "required");
    $this->form_validation->set_rules("locality", "Locality", "required");
    $this->form_validation->set_rules("no_of_guests", "Number of Guests", "required|less_than[2]");
    $this->form_validation->set_rules("address", "Address", "required");


  // checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){

      // we have some errors
      $this->response(array(
        "status" => false,
        "message" => "Form validation failed, please enter data in correct format"
      ) , REST_Controller::HTTP_OK);
    }else{
      
      //Validations passed Insert the data
      $insertData = array(
          'name' => $name,
          'age' =>  $age,
          'dob' =>  convertToDate($dob),
          'profession' => $profession,
          'locality' =>   $locality,
          'no_of_guests' => $no_of_guests,
          'address' => $address


      );

      if($this->ParticipantModel->insert_data('participants' , $insertData)){
          //Sucessfully Inserterd
            $this->response(array(
              "status" => true,
              "message" => "Record has been created!"
            ) , REST_Controller::HTTP_OK);


      }else{
        //Not inserted some error found while inserting

          $this->response(array(
            "status" => false,
            "message" => "Some error in inseting the data! Please Try Again"
          ) , REST_Controller::HTTP_OK);
      

      }


    }
//   print_r($this->input->post());die;

      

}







}
 ?>
