

<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}


	public function getDashboardDetails(){


		$data['dashboard'] = array(
			'items' => $this->getCountProducts() ,   
			'suppliers' => $this->getCountSupplires(), 
			'invoices' => $this->getTodaysInvoices(),
		);
   	
   		return $this->output->set_output(json_encode($data['dashboard'], JSON_PRETTY_PRINT));
 

	}

	public function getCountProducts(){  

		$search_index = array(  
			'table' => 'item',
			'data' => '1',
		);

       return $this->getTotalRowData__($search_index);    
    }

    public function getCountSupplires(){  

    	$search_index = array(  
			'table' => 'supplier',
			'data' => '1',
		);

       	return $this->getTotalRowData__($search_index);    
    }


    public function getTodaysInvoices(){  

    	$search_index = array(  
			'table' => 'invoice',
			'data' => 'invoice_date="'.date("Y-m-d").'"',
		);

       	return $this->getTotalRowData__($search_index);    
    }



    public function getLastInvoices(){
 
    	return $this->getLastInvoicesData();   

    }
 	
 	public function getRecentProducts(){   

        $search_index = array(
			'columns' => 'i.*, c.cat_name' ,   
			'table' => 'item i, categories c',
			'data' => 'i.cat_id = c.id order by item_id DESC LIMIT 5',
		);

		return $this->selectCustomData__($search_index);   
    }
    
	 

}

