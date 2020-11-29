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

public function index_get($offset = 0, $limit = 10){

    $participantsData = $this->ParticipantModel->get_participants( $offset, $limit );
    
    if( !empty($participantsData) )
    {

          //If Data is not empty form DB
          $this->response(
            array(
                "status" => true,
                "message" => "Data Found :: Total Object(s) " . count($participantsData),
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


    // filtering form XSS
    $name = $this->security->xss_clean($this->input->post("name"));
    $age = $this->security->xss_clean($this->input->post("age"));
    $dob = $this->security->xss_clean($this->input->post("dob"));
    $profession = $this->security->xss_clean($this->input->post("profession"));
    $locality = $this->security->xss_clean($this->input->post("locality"));
    $no_of_guests = $this->security->xss_clean($this->input->post("no_of_guests"));
    $address = $this->security->xss_clean($this->input->post("address"));


    // form validation for inputs
    $this->form_validation->set_rules("name", "name", "required");
    $this->form_validation->set_rules("age", "Age", "required|integer");
    $this->form_validation->set_rules('dob','Date of birth',array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]'));
    $this->form_validation->set_rules("profession", "Profession", "callback_checkPofession");
    $this->form_validation->set_rules("locality", "Locality", "required");
    $this->form_validation->set_rules("no_of_guests", "Number of Guests", "required|less_than[2]");
    $this->form_validation->set_rules("address", "Address", "required");
    

    
   
    //checking form submittion have any error or not
    if($this->form_validation->run() === FALSE){



      // we have some errors
      $this->response(array(
        "status" => false,
        "message" => "Form validation failed, please enter data in correct format " .$message
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
        //Not inserted, some error found while inserting

          $this->response(array(
            "status" => false,
            "message" => "Some error in inseting the data! Please Try Again"
          ) , REST_Controller::HTTP_OK);
      

      }


    }
  

}


/***
Method :: PUT
Update record
**/


public function index_put($id){


   $client_data = json_decode(json_encode(json_decode((file_get_contents("php://input")))));
   $data = (array) $client_data;
  
   // filtering form XSS
    $name = $this->security->xss_clean($client_data->name);
    $age = $this->security->xss_clean($client_data->age);
    $dob = $this->security->xss_clean($client_data->dob);
    $profession = $this->security->xss_clean($client_data->profession);
    $locality = $this->security->xss_clean($client_data->locality);
    $no_of_guests = $this->security->xss_clean($client_data->no_of_guests);
    $address = $this->security->xss_clean($client_data->address);
   
    $config = array(
        array(
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required'
        ),
        array(
                'field' => 'age',
                'label' => 'Age',
                'rules' => 'required|integer',
               
        ),


        array(
                'field' => 'dob',
                'label' => 'Date of birth',
                'rules' => array('regex_match[/^((0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d)$/]')
        ),
        array(
                'field' => 'profession',
                'label' => 'Profession',
                'rules' => 'required|callback_checkPofession',
               
        ),
        array(
                'field' => 'locality',
                 'label' => 'name',
                'rules' => 'required'
        ),
        array(
                'field' => 'no_of_guests',
                'label' => 'Number of Guests',
                'rules' => 'required|less_than[2]',
               
        ),
        array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required',
               
        )

    );

$this->form_validation->set_data($data);
$this->form_validation->set_rules($config);


//checking form submittion have any error or not
if($this->form_validation->run()==FALSE){

           $this->response(array(
              "status" => true,
              "message" => "Form validations failed!"
            ) , REST_Controller::HTTP_NOT_FOUND);

}else{
     

          if(isset($id) && $id > 0){

            //Check if data is present in DB or not
            if( $this->ParticipantModel->checkDataById($id) == FALSE ){

                    //No Data in Databse
                    $this->response(array(
                          "status" => false,
                          "message" => "Trying to update the record for invalid ID!"
                        ) , REST_Controller::HTTP_NOT_FOUND);
                    //exit();
            }


            else {

              $updateData = array(
                'name' => $name,
                'age' =>  $age,
                'dob' =>  convertToDate($dob),
                'profession' => $profession,
                'locality' =>   $locality,
                'no_of_guests' => $no_of_guests,
                'address' => $address
              );

              if( $this->ParticipantModel->update_data('participants' , $id , $updateData) ){
                  //Sucessfully Updated

                    $this->response(array(
                      "status" => true,
                      "message" => "Record has been updated!"
                    ) , REST_Controller::HTTP_OK);

              }else{
                //Not updated, some error found while inserting
                  $this->response(array(
                    "status" => false,
                    "message" => "Some error in updating the data! Please Try Again"
                  ) , REST_Controller::HTTP_OK);
              

              }

          }

         

    }else{
                $this->response(array(
                  "status" => false,
                  "message" => "something Went Wrong"
                ) , REST_Controller::HTTP_NOT_FOUND);

    }

  }//Form validations

}




/**
Custom Validation method 
**/
function checkPofession($formValue){
  return (($formValue == 'Employed') or ($formValue == 'Student'))? true : false;
}



}
 ?>
