<?php

include 'commonController.php';

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

     	$search_index = array(
			'columns' => 'i.*, c.cat_name, s.sup_name' ,   
			'table' => 'item i, categories c, supplier s',
			'data' => 'i.cat_id = c.id ',
		);

        return $this->selectCustomData__($search_index); 
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
			'columns' => 'i.*, c.cat_name, s.sup_name' ,   
			'table' => 'item i, categories c, supplier s',
			'data' => 'i.cat_id = c.id AND i.item_id = "'.$this->input->post('item_id').'"',
		);

        return $this->selectCustomData__($search_index); 
    }


    public function getSingleItemStock(){ 

        $search_index = array(
			'columns' => 'i.*, s.sup_name' ,   
			'table' => 'item_stock i, supplier s ',
			'data' => 'i.item_id= '.$this->input->post('item_id').' ORDER BY i.stock_id DESC',
		);

		return $this->selectCustomData__($search_index);
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


	public function addItemStock(){
		$dataset = $this->input->post();
		return $this->insertData__('item_stock', $dataset); 
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



