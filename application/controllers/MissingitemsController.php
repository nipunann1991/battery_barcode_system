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
			'data' => 'status=1 AND barcode= "'.$this->input->post('barcode').'" ',
		);

		return $this->selectCustomData__($search_index);
 
    }


    public function searchMissigItemData(){

        $search_index = array(
            'columns' => '*' ,   
            'table' => 'missing',
            'data' => 'id= "'.$this->input->post('id').'"',
        );

        return $this->selectCustomData__($search_index);
 
    }


    public function updateMissingItem(){ 

        $dataset = $this->input->post(); 
        return $this->updateData__('missing', $dataset, " id =".$dataset['id']);
 
    }


    public function getMissingList(){ 

    	$tbl_name = 'item_barcode'; 
    	$start = $this->input->get('start');
    	$length = $this->input->get('length');
    	$get_column = $this->input->get('order[0][column]');
    	$get_column_name = $this->input->get('columns['.$get_column.'][data]');
    	$get_order = $this->input->get('order[0][dir]');
    	$search_from_value = '1';

 
     

    	if (intval($this->input->post('draw')) == 1) {
    		$get_order = 'desc';
    	}

    	if ($this->input->post('search[value]') != '') {
    		$search_from_value = "AND i.barcode LIKE '%".$this->input->post('search[value]')."%' OR i.manufacture_id LIKE '%".$this->input->post('search[value]')."%' OR i.invoice_no LIKE '%".$this->input->post('search[value]')."%' OR s.sup_name LIKE '%".$this->input->post('search[value]')."%' ";
    	}
  


		$search_index = array(
			'columns' => 'ib.*, i.*' ,   
			'table' => 'item_barcode ib, invoice i',
			'data' => 'ib.status=-1 AND ib.invoice_id=i.invoice_id AND '.$search_from_value.' order by '.$get_column_name.' '.$get_order.' LIMIT '.$start.', '.$length.'',
		);


  
		$get_all_data = array(
			'columns' => 'ib.*, i.*' ,   
			'table' => 'item_barcode ib, invoice i ',
			'data' => 'ib.status=-1 AND ib.invoice_id = i.invoice_id',
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