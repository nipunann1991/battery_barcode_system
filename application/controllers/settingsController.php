<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}


	public function getRoles(){    
		return $this->getAllData__('roles');   
    }


    public function getCompanyDetails(){    
		return $this->getAllData__('company');   
    }

    public function getUsers(){    

		$search_index = array(
			'columns' => 'l.*, r.role_name' ,   
			'table' => 'login l, roles r',
			'data' => 'l.role_id = r.role_id ',
		);

        return $this->selectCustomData__($search_index); 
		 
    }


    public function addUsers(){

		$dataset = $this->input->post();
		$dataset['password'] = md5($this->input->post('password'));
		 
		return $this->insertData__('login', $dataset); 
	}


	public function deleteUsers(){

		$dataset = $this->input->post();  
		return $this->deleteData__('login', " login_id =".$dataset['login_id']);

	}


	public function updateCompanyDetails(){ 

		$dataset = $this->input->post(); 
		//print_r($dataset);
		return $this->updateData__('company', $dataset, " id =".$dataset['id']);
 
	}
	 




 
 

}