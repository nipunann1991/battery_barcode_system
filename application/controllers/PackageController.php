

<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class PackageController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}


	public function getItems(){ 

		$tbl_name = 'package'; 
    	$start = $this->input->post('start');
    	$length = $this->input->post('length');
    	$get_column = $this->input->post('order[0][column]');
    	$get_column_name = $this->input->post('columns['.$get_column.'][data]');
    	$get_order = $this->input->post('order[0][dir]');
    	$search_from_value = '';

    	// switch ($get_column_name) {
    	// 	case 'sup_name':
    	// 		$get_column_name = 's.'.$get_column_name;
    	// 		break;
    		
    	// 	default:
    	// 		$get_column_name = 'i.'.$get_column_name;
    	// 		break;
    	// }

    	// if (intval($this->input->post('draw')) == 1) {
    	// 	$get_order = 'desc';
    	// }

    	// if ($this->input->post('search[value]') != '') {
    	// 	$search_from_value = "AND i.barcode LIKE '%".$this->input->post('search[value]')."%' OR i.manufacture_id LIKE '%".$this->input->post('search[value]')."%' OR i.invoice_no LIKE '%".$this->input->post('search[value]')."%' OR s.sup_name LIKE '%".$this->input->post('search[value]')."%' ";
    	// }
  


		$search_index = array(
			'columns' => '*' ,   
			'table' => 'package',
			'data' => '1',
		);

		$get_all_data = array(
			'columns' => '*' ,   
			'table' => 'package',
			'data' => '1',
		);



     	$result = $this->selectCustomDataDT__($search_index); 
     	
 		$output['result'] = array(
            "draw" => intval($this->input->get('draw')),
            "recordsTotal" => $this->commonQueryModel->count_filtered($get_all_data),
            "recordsFiltered" => $this->commonQueryModel->count_filtered($get_all_data),
            "data" => $result,
    	); 

        return $this->output->set_output(json_encode($output['result']));

        //return $this->getAllData__('package'); 
    }

 
 	// public function getSingleItem(){   

  //       $search_index = array(
		// 	'columns' => 'i.item_name, c.cat_name, ib.*, ibs.*' ,   
		// 	'table' => 'item i, item_barcode ib, item_bulk_stock ibs, categories c',
		// 	'data' => 'i.cat_id = c.id AND i.item_id = ibs.item_id AND ibs.stock_id=i.stock_id AND ib.barcode="'.$this->input->post('barcode').'" ',
		// );

  //       print_r($search_index);
		// return $this->selectCustomData__($search_index);   
  //   }


    public function getItemsInPackage(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ist.*' ,   
			'table' => 'item i, item_stock ist, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id = ist.item_id AND ist.package_id="'.$this->input->post('package_id').'" ',
		);

		return $this->selectCustomData__($search_index);   
    }

    public function getSinglePackage(){   

        $search_index = array(
			'columns' => '*' ,   
			'table' => 'package',
			'data' => 'pkg_id="'.$this->input->post('package_id').'"',
		);

		return $this->selectCustomData__($search_index);   
    }


    public function getAutoIncrementID(){   
 
		return $this->getAutoIncrementID__('package');   
    }
    

    public function updateSingleItem(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item_stock', $dataset, " stock_id =".$dataset['stock_id']);
 
	}

	public function addItem(){

		$dataset = $this->input->post();
		return $this->insertData__('package', $dataset); 
	}


	public function updateItem(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('package', $dataset, " pkg_id =".$dataset['pkg_id']);
 
	}

	public function deletePackage(){

		$dataset = $this->input->post(); 
		return $this->deleteData__('package', " pkg_id =".$dataset['pkg_id']);
 
	}
	 

}

