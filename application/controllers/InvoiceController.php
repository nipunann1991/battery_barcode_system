 <?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceController extends CommonController {


 	public function getItems(){ 
        return $this->getAllData__('item'); 
    }

    public function getCompanyDetails(){ 
        return $this->getAllData__('company'); 
    }


}