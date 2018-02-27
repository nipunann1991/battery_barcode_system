<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class MissingItemsController extends CommonController {

	public function addMissingItems(){

		$dataset = $this->input->post(); 
		return $this->insertData__('missing', $dataset); 
		
	}


	public function updateItem(){ 

        $dataset = $this->input->post(); 
        return $this->updateData__('item_barcode', $dataset, " barcode =".$dataset['barcode']);
 
    }


	public function searchItem(){

    	$search_index = array(
			'columns' => '*' ,   
			'table' => 'item_barcode',
			'data' => 'barcode= "'.$this->input->post('barcode').'"',
		);

		return $this->selectCustomData__($search_index);
 
    }


    public function getMissingList(){ 

    	$tbl_name = 'missing'; 
    	$start = $this->input->post('start');
    	$length = $this->input->post('length');
    	$get_column = $this->input->post('order[0][column]');
    	$get_column_name = $this->input->post('columns['.$get_column.'][data]');
    	$get_order = $this->input->post('order[0][dir]');
    	$search_from_value = '';

     

    	if (intval($this->input->post('draw')) == 1) {
    		$get_order = 'desc';
    	}

    	if ($this->input->post('search[value]') != '') {
    		$search_from_value = "AND i.barcode LIKE '%".$this->input->post('search[value]')."%' OR i.manufacture_id LIKE '%".$this->input->post('search[value]')."%' OR i.invoice_no LIKE '%".$this->input->post('search[value]')."%' OR s.sup_name LIKE '%".$this->input->post('search[value]')."%' ";
    	}
  


		$search_index = array(
			'columns' => 'm.*' ,   
			'table' => 'missing m',
			'data' => '1',
		);


  
		$get_all_data = array(
			'columns' => 'm.*' ,   
			'table' => 'missing m ',
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


    }


    

}