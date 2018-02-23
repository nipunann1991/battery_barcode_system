<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	/*
	* Main Page
	*/

	public function index(){	
		$this->load->view('index');
	}

	public function header(){
		$this->load->view('header');
	}

	public function footer(){
		$this->load->view('footer');
	}

	public function login(){
		$this->load->view('login');
	}

	public function topNav(){
		$this->load->view('top-nav');
	}

	public function leftNav(){
		$this->load->view('left-nav');
	}


	public function dashboard(){	
		$this->load->view('dashboard');
	}


	/*
	* Items
	*/

	public function items(){ 
		$this->load->view('templates/items/items');
	}

	public function searchBattery(){ 
		$this->load->view('templates/items/search-battery');
	}

	public function printAllBarcode(){ 
		$this->load->view('templates/items/print-all-barcode');
	}


	public function addItems(){ 
		$this->load->view('templates/items/add-items');
	}

	public function editItems(){  
		$this->load->view('templates/items/edit-items');
	}


	public function viewItemStock(){  
		$this->load->view('templates/items/view-item-stock');
	}

	public function viewBarcode(){  
		$this->load->view('templates/items/view-barcode');
	}


	public function viewPackageItems(){  
		$this->load->view('templates/items/view-package-items');
	}



	


	/*
	* Categories
	*/


	public function categories(){
		$this->load->view('templates/categories/categories');
	}


	public function addCategories(){
		$this->load->view('templates/categories/add-categories');
	}

	public function editCategories(){
		$this->load->view('templates/categories/edit-categories');
	}


	/*
	* Package
	*/


	public function package(){
		$this->load->view('templates/package/package');
	}


	public function addPackage(){
		$this->load->view('templates/package/add-package');
	}

	public function editPackage(){
		$this->load->view('templates/package/edit-package');
	}

	public function viewPackage(){  
		$this->load->view('templates/package/view-package');
	}

	

	/*
	* Suppliers
	*/

	public function supplier(){  
		$this->load->view('templates/suppliers/suppliers');
	}

	public function addSupplier(){  
		$this->load->view('templates/suppliers/add-suppliers');
	}

	public function editSupplier(){  
		$this->load->view('templates/suppliers/edit-suppliers');
	}



	/*
	* Settings
	*/

	 public function settings(){ 
		$this->load->view('templates/settings/index');
	}
	

	/*
	* Invoice
	*/

	public function invoice(){ 
		$this->load->view('templates/invoice/invoices');
	}

	public function newInvoice(){ 
		$this->load->view('templates/invoice/new-invoice');
	}


	public function viewInvoice(){ 
		$this->load->view('templates/invoice/view-invoice');
	}


	

	/*
	* Returns
	*/
	public function returns(){ 
		$this->load->view('templates/returns/returns');
	}
	public function addReturns(){ 
		$this->load->view('templates/returns/add-return');
	}
	public function editReturns(){ 
		$this->load->view('templates/returns/edit-return');
	}





	 
}
