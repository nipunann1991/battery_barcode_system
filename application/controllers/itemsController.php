<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class ItemsController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}

    public function getItems(){ 
        return $this->getAllData__('item'); 
    }
    

    public function getItemsJoined(){ 
 

    	$tbl_name = 'item'; 
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
			'columns' => 'i.*, c.cat_name' ,   
			'table' => 'item i, categories c',
			'data' => 'i.cat_id = c.id '.$search_from_value.' order by '.$get_column_name.' '.$get_order.' LIMIT '.$start.', '.$length.'',

		);

		$get_all_data = array(
			'columns' => 'i.*, c.cat_name' ,   
			'table' => 'item i, categories c',
			'data' => 'i.cat_id = c.id '.$search_from_value.' ',
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


    public function getCategoryList(){

    	$search_index = array(
			'columns' => '`id`, `cat_name`' ,   
			'table' => 'categories',
			'data' => '1',
		);

       return $this->selectCustomData__($search_index);
    } 

    public function getSupplierList(){

    	$search_index = array(
			'columns' => '`sup_id`, `sup_name`' ,   
			'table' => 'supplier',
			'data' => '1',
		);

        return $this->selectCustomData__($search_index);
    } 


	public function getLastIndex(){ 
		
		$search_index = array(
			'table' => 'item' ,   
			'search_index' => 'item_id',
		);

		return $this->selectLastIndex__($search_index);
       
    }

     public function getSingleItem(){

    	$search_index = array(
			'columns' => '*' ,   
			'table' => 'item',
			'data' => 'item_id= "'.$this->input->post('item_id').'"',
		);

		return $this->selectCustomData__($search_index);
 
    }


    public function getSingleItemJoined(){ 

     	$search_index = array(
			'columns' => 'i.*, c.cat_name, c.id AS cat_id, s.sup_name, (SELECT SUM(ib.status) FROM item_bulk_stock ibs, item_barcode ib WHERE ibs.stock_id=ib.stock_id AND ib.status<>-1   AND ibs.item_id = '.$this->input->post('item_id').' ) as rm_stock ' ,   
			'table' => 'item i, categories c, supplier s, item_bulk_stock ibs',
			'data' => 'i.cat_id = c.id AND s.sup_id=ibs.sup_id AND i.item_id = "'.$this->input->post('item_id').'" GROUP BY i.item_id',
		);

        return $this->selectCustomData__($search_index); 
    }


    public function getPackageItemData(){ 

     	$search_index = array(
			'columns' => 'ibs.*, c.cat_name, i.*' ,   
			'table' => 'item_bulk_stock ibs, categories c, item i',
			'data' => 'ibs.item_id = i.item_id AND c.id = i.cat_id AND ibs.barcode = "'.$this->input->post('barcode').'"',
		);

        return $this->selectCustomData__($search_index); 
    }


    public function getPackageBatteryData(){ 

        $search_index = array(
            'columns' => 'ibs.*, c.cat_name, i.*' ,   
            'table' => 'item_bulk_stock ibs, categories c, item i',
            'data' => 'ibs.item_id = i.item_id AND c.id = i.cat_id AND ibs.barcode = "'.$this->input->post('barcode').'"',
        );

        return $this->selectCustomData__($search_index); 
    }

    public function getBatteryData(){ 

        $search_index = array(
            'columns' => 'ibs.*, i.*' ,   
            'table' => 'item_bulk_stock ibs, item_barcode i',
            'data' => 'ibs.stock_id = i.stock_id AND ibs.barcode = "'.$this->input->post('barcode').'"',
        );

        return $this->selectCustomData__($search_index); 
    }


    public function searchBattery(){ 

        $search_index = array(
            'columns' => 'ibs.*, ibs.barcode AS package_barcode, ib.*, c.cat_name, i.*, s.sup_name'  ,   
            'table' => 'item_bulk_stock ibs, item_barcode ib, categories c, item i, supplier s',
            'data' => 'ibs.stock_id = ib.stock_id AND ibs.item_id = i.item_id AND c.id = i.cat_id AND s.sup_id = ibs.sup_id  AND ib.barcode = "'.$this->input->post('barcode').'"',
        );

        return $this->selectCustomData__($search_index); 
    }




    public function getSingleItemStock(){ 

    	$tbl_name = 'item'; 
    	$start = $this->input->post('start');
    	$length = $this->input->post('length');
    	$get_column = $this->input->post('order[0][column]');
    	$get_column_name = $this->input->post('columns['.$get_column.'][data]');
    	$get_order = $this->input->post('order[0][dir]');
    	$search_from_value = '';

    	switch ($get_column_name) {
    		case 'sup_name':
    			$get_column_name = 's.'.$get_column_name;
    			break;
    		
    		default:
    			$get_column_name = 'i.'.$get_column_name;
    			break;
    	}

    	if (intval($this->input->post('draw')) == 1) {
    		$get_order = 'desc';
    	}

    	if ($this->input->post('search[value]') != '') {
    		$search_from_value = "AND i.barcode LIKE '%".$this->input->post('search[value]')."%' OR i.manufacture_id LIKE '%".$this->input->post('search[value]')."%' OR i.invoice_no LIKE '%".$this->input->post('search[value]')."%' OR s.sup_name LIKE '%".$this->input->post('search[value]')."%' ";
    	}
  


		$search_index = array(
			'columns' => 'i.*, ib.*, s.sup_name, SUM(ib.status) AS rm_stock, i.barcode, i.status' ,   
			'table' => 'item_bulk_stock i, supplier s , item_barcode ib ',
			'data' => 'i.sup_id=s.sup_id AND ib.stock_id=i.stock_id AND ib.status<>-1 AND i.item_id= '.$this->input->post('item_id').' '.$search_from_value.'  GROUP by '.$get_column_name.' '.$get_order.' LIMIT '.$start.', '.$length.'',
		);


 

		$get_all_data = array(
			'columns' => 'i.*, s.sup_name' ,   
			'table' => 'item_bulk_stock i, supplier s ',
			'data' => 'i.sup_id=s.sup_id AND i.item_id= '.$this->input->post('item_id').' ',
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


    public function getPackageItemList(){ 

    	$tbl_name = 'item'; 
    	$start = $this->input->post('start');
    	$length = $this->input->post('length');
    	$get_column = $this->input->post('order[0][column]');
    	$get_column_name = $this->input->post('columns['.$get_column.'][data]');
    	$get_order = $this->input->post('order[0][dir]');
    	$search_from_value = '';

    	switch ($get_column_name) {
    		case 'sup_name':
    			$get_column_name = 's.'.$get_column_name;
    			break;
    		
    		default:
    			$get_column_name = 'i.'.$get_column_name;
    			break;
    	}

    	if (intval($this->input->post('draw')) == 1) {
    		$get_order = 'desc';
    	}

    	// if ($this->input->post('search[value]') != '') {
    	// 	$search_from_value = "AND i.barcode LIKE '%".$this->input->post('search[value]')."%' OR i.manufacture_id LIKE '%".$this->input->post('search[value]')."%' OR i.invoice_no LIKE '%".$this->input->post('search[value]')."%' OR s.sup_name LIKE '%".$this->input->post('search[value]')."%' ";
    	// }
  		 

		$search_index = array(
			'columns' => 'ibs.*, i.*' ,   
			'table' => 'item_bulk_stock ibs, item_barcode i',
			'data' => 'ibs.stock_id = i.stock_id AND ibs.barcode = "'.$this->input->post('barcode').'" '.$search_from_value.' order by '.$get_column_name.' '.$get_order.' LIMIT '.$start.', '.$length.'',
		);


 

		$get_all_data = array(
			'columns' => 'ibs.*, i.*' ,   
			'table' => 'item_bulk_stock ibs, item_barcode i',
			'data' => 'ibs.stock_id = i.stock_id AND ibs.barcode = "'.$this->input->post('barcode').'"',
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



    public function getSingleItemFromStock(){ 

        $search_index = array(
			'columns' => '*' ,   
			'table' => 'item_stock',
			'data' => 'stock_id= "'.$this->input->post('stock_id').'"',
		);

		return $this->selectCustomData__($search_index);
    }


    public function getSingleItemFromBarcode(){ 

        $search_index = array(
			'columns' => '*' ,   
			'table' => 'item_stock',
			'data' => 'barcode= "'.$this->input->post('barcode').'"',
		);

		return $this->selectCustomData__($search_index);
    }


    public function addItem(){

		$dataset = $this->input->post();
		return $this->insertData__('item', $dataset); 
	}


	public function addBulkItemStock(){
		$dataset = $this->input->post();
		return $this->insertDataBulkStockSP__('item_bulk_stock', $dataset); 
	}

 

	public function addItemStock(){
		$dataset = $this->input->post();
		return $this->insertData__('item_barcode', $dataset); 
	}


	public function updateItems(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item', $dataset, " item_id =".$dataset['item_id']);
 
	}


	public function updateItemsStock(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item_stock', $dataset, " stock_id =".$dataset['stock_id']);
 
	}
 

	public function deleteItems(){

		$dataset = $this->input->post(); 
		return $this->deleteData__('item', " item_id =".$dataset['item_id']);
 
	}

	public function deleteItemsStock(){

		$dataset = $this->input->post(); 
		return $this->deleteData__('item_stock', " stock_id =".$dataset['stock_id']);
 
	}


	public function fileUpload(){
		
		$target_dir = "assets/upload/";
     	$name = $_POST['name'];
     	$item_id = $_POST['item_id'];

	    $target_file = $target_dir . basename($_FILES["file"]["name"]); 
	    $image_url = array('image_url' => $target_file );

	    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

	    $this->updateData__('item',  $image_url  , " item_id =".$item_id);
	}


	 

}



