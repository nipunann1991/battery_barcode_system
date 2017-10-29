

<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class PackageController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}

 
 	public function getSingleItem(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ist.*' ,   
			'table' => 'item i, item_stock ist, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id = ist.item_id AND ist.barcode="'.$this->input->post('barcode').'" AND ist.package_id=0  ',
		);

		return $this->selectCustomData__($search_index);   
    }
    

    public function updateSingleItem(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item', $dataset, " item_id =".$dataset['item_id']);
 
	}
	 

}

