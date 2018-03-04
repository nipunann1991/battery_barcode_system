

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
			'packages' => $this->getTodaysPackages(),
		);
   	
   		return $this->output->set_output(json_encode($data['dashboard'], JSON_PRETTY_PRINT));
 

	}

	public function getCountProducts(){  

		$search_index = array(  
			'table' => 'item_barcode',
			'data' => 'status = 1',
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


    public function getTodaysPackages(){  

    	$search_index = array(  
			'table' => 'item_bulk_stock',
			'data' => 'status = 1',
		);

       	return $this->getTotalRowData__($search_index);    
    }




    public function getLastInvoices(){
 
    	return $this->getLastInvoicesData();   

    }
 	
 	public function getRecentProducts(){   

        $search_index = array(
			'columns' => ' DISTINCT i.item_id, i.item_name, c.cat_name ' ,   
			'table' => 'item i, categories c, item_bulk_stock ibs',
			'data' => 'i.cat_id = c.id AND ibs.item_id = i.item_id order by i.item_id DESC LIMIT 5',
		);

		return $this->selectCustomData__($search_index);   
    }
    
	 

}

