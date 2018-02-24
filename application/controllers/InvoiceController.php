 <?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceController extends CommonController {


 	public function getInvoiceList(){ 

 		$tbl_name = 'invoice';

 		$result = $this->getAllDataDT__('invoice');

 		$get_all_data = array(
			'columns' => '*' ,   
			'table' => 'invoice',
			'data' => '1',
		);


 		$output['result'] = array(
            "draw" => intval($this->input->get('draw')),
            "recordsTotal" => $this->commonQueryModel->count_filtered($get_all_data),
            "recordsFiltered" => $this->commonQueryModel->count_filtered($get_all_data),
            "data" => $result,
    	); 

			
        return $this->output->set_output(json_encode($output['result']));
    }

    public function getCompanyDetails(){ 
        return $this->getAllData__('company'); 
    }


    public function getSingleItem(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ibs.*, ibs.barcode AS pkg_barcode, ib.*' ,   
			'table' => 'item i, item_barcode ib, item_bulk_stock ibs, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id = ibs.item_id AND ibs.stock_id=ib.stock_id AND ib.barcode="'.$this->input->post('barcode').'" ',
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
			'columns' => 'i.item_name, c.cat_name, ibs.*, ib.*' ,   
			'table' => 'item_bulk_stock ibs, item_barcode ib, item i, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id=ibs.item_id AND ibs.stock_id = ib.stock_id AND ib.invoice_id="'.$this->input->post('invoice_id').'" AND ib.invoice_id<>ibs.invoice_id',
		);

		return $this->selectCustomData__($search_index);   
    }


    public function getPackageInvoiced(){   

        $search_index = array(
			'columns' => 'ibs.* ' ,   
			'table' => 'item_bulk_stock ibs',
			'data' => 'ibs.invoice_id="'.$this->input->post('invoice_id').'" ',
		);

		return $this->selectCustomData__($search_index);   
    }
    
    
    public function getItemsInPackage(){   

        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ibs.*, ib.* ' ,   
			'table' => 'item_bulk_stock ibs, item_barcode ib, item i, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id=ibs.item_id AND ibs.stock_id = ib.stock_id AND ib.stock_id="'.$this->input->post('stock_id').'"',
		);

		return $this->selectCustomData__($search_index); 

    }

   public function getItemsInPackageBK(){   
        
        $search_index = array(
			'columns' => 'i.item_name, c.cat_name, ibs.*, ibs.barcode AS pkg_barcode, ib.*' ,   
			'table' => 'item i, item_barcode ib, item_bulk_stock ibs, categories c',
			'data' => 'i.cat_id = c.id AND i.item_id = ibs.item_id AND ibs.stock_id=ib.stock_id AND ib.status=1 AND ibs.barcode="'.$this->input->post('barcode').'"',
		);

		return $this->selectCustomData__($search_index);   
    }
 
    public function saveInvoice(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item_barcode', $dataset, " barcode ='".$dataset['barcode']."'");
 
	}


	public function savePackageInfo(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('item_bulk_stock', $dataset, " stock_id ='".$dataset['stock_id']."'");
 
	}

	public function addInvoice(){

		$dataset = $this->input->post();
		return $this->insertData__('invoice', $dataset); 
	}
 
	public function getAutoIncrementID(){   
		return $this->getAutoIncrementID__('invoice');   
    }

}