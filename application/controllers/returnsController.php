<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnsController extends CommonController {


	public function addReturns(){

		$dataset = $this->input->post(); 
		return $this->insertData__('return_stock', $dataset); 
		
	}

	public function getReturnsList(){ 
 

    	$tbl_name = 'return_stock'; 
    	$start = $this->input->get('start');
    	$length = $this->input->get('length');
    	$get_column = $this->input->get('order[0][column]');
    	$get_column_name = $this->input->get('columns['.$get_column.'][data]');
    	$get_order = $this->input->get('order[0][dir]');
    	$search_from_value = '';

    	switch ($get_column_name) {
    		case 'cat_name':
    			$get_column_name = 'c.'.$get_column_name;
    			break;
    		
    		default:
    			$get_column_name = 'i.'.$get_column_name;
    			break;
    	}

    	if (intval($this->input->get('draw')) == 1) {
    		$get_order = 'desc';
    	}

    	if ($this->input->get('search[value]') != '') {
    		$search_from_value = "AND i.item_name LIKE '%".$this->input->get('search[value]')."%' OR i.item_id LIKE '%".$this->input->get('search[value]')."%'";
    	}

     	$search_index = array(
			'columns' => '*' ,   
			'table' => 'return_stock',
			'data' => '1',

		);

		$get_all_data = array(
			'columns' => '*' ,   
			'table' => 'return_stock',
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