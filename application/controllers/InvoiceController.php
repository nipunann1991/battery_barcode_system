 <?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceController extends CommonController {


 	public function getInvoiceList(){ 
        return $this->getAllData__('invoice'); 
    }

    public function getCompanyDetails(){ 
        return $this->getAllData__('company'); 
    }


    public function getSingleItem(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ist.*' ,   
			'table' => 'item i, item_stock ist, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id = ist.item_id AND ist.barcode="'.$this->input->post('barcode').'" AND ist.package_id=0  AND ist.status = 1',
		);

		return $this->selectCustomData__($search_index);   
    }


    public function getSingleInvoice(){   

        $search_index = array(
			'columns' => '*' ,   
			'table' => 'invoice',
			'data' => 'invoice_id="'.$this->input->post('invoice_id').'" ',
		);

		return $this->selectCustomData__($search_index);   
    }



    public function getSingleItemsInvoiced(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ist.*, p.* ' ,   
			'table' => 'item_stock ist, package p, item i, categories c',
			'data' => 'i.cat_id = c.id AND ist.package_id = p.pkg_id AND i.item_id = ist.item_id AND ist.invoice_id="'.$this->input->post('invoice_id').'" AND ist.package_id = 0',
		);

		return $this->selectCustomData__($search_index);   
    }


    public function getPackageInvoiced(){   

        $search_index = array(
			'columns' => 'p.* ' ,   
			'table' => 'package p',
			'data' => 'p.invoice_id="'.$this->input->post('invoice_id').'" ',
		);

		return $this->selectCustomData__($search_index);   
    }
    
    
    public function getItemsInPackage(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ist.*, p.* ' ,   
			'table' => 'item_stock ist, package p, item i, categories c',
			'data' => 'i.cat_id = c.id AND ist.package_id = p.pkg_id AND i.item_id = ist.item_id AND ist.package_id="'.$this->input->post('package_id').'" AND ist.package_id <> 0',
		);

		return $this->selectCustomData__($search_index);   
    }
 
    public function saveInvoice(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item_stock', $dataset, " barcode ='".$dataset['barcode']."'");
 
	}

	public function addInvoice(){

		$dataset = $this->input->post();
		return $this->insertData__('invoice', $dataset); 
	}


	public function getAutoIncrementID(){   
		return $this->getAutoIncrementID__('invoice');   
    }

}