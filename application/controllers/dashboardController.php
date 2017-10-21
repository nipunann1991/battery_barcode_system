

<?php

include 'commonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}


	public function getCountProducts(){  
       return $this->getTotalRows__('item');    
    }

    public function getCountSupplires(){  
       return $this->getTotalRows__('supplier');    
    }

 	
 	public function getRecentProducts(){   

        $search_index = array(
			'columns' => 'i.*, c.cat_name' ,   
			'table' => 'item i, categories c',
			'data' => 'i.cat_id = c.id order by item_id DESC',
		);

		return $this->selectCustomData__($search_index);   
    }
    
	 

}

