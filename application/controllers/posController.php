 <?php

include 'commonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class PosController extends CommonController {


 	public function getItems(){ 
        return $this->getAllData__('item'); 
    }


}