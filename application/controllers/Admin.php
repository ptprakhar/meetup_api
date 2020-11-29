<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 @author :: Prakhar
 @description
 Admin Controller for Showing the list of participants 
 *
 */

class Admin extends CI_Controller {


	public function __construct() {
        parent::__construct();
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
        $this->load->model('ParticipantModel');
        $this->load->helper('custom');
        $this->load->helper('url');

    }

	public function index($offset = 0, $limit = 1000000){
		


		$data['participantsData'] = $this->ParticipantModel->get_participants($offset, $limit);
		$this->load->view('admin/dashboard' , $data);
	}



}