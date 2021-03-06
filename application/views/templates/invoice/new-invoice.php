
<div ng-controller="newinvoiceCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('invoice')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> View Invoice List</md-button>  
	</div>
 
	<div class="body invoice"> 





 		<div class="col-md-12 ">
 			<div class="header row">
 				<div class="col-md-6 block left">
 					<h3 class="company_name">

 						<div class="select-box">
  
						    <strong>Please select a customer : </strong>
						    <ui-select ng-model="customer" theme="select2" on-select="onSelected(customer)"" title="Choose a person" append-to-body="true">
						      <ui-select-match class="form-control" placeholder="Please select a customer">{{$select.selected.customer_name}}</ui-select-match>
						      <ui-select-choices repeat="customer in getAllCustomers | filter: {customer_name: $select.search }">
						        <div ng-bind-html="customer.customer_name | highlight: $select.search"></div>
						        <small>
						          <!-- email: {{customer.email}}
						          age: <span ng-bind-html="''+customer.age | highlight: $select.search"></span> -->
						        </small>
						      </ui-select-choices>
						    </ui-select>
						   
						  </div> 
						   <a ng-click="add_customer()" ><i class="icon-plus-sign-in-a-black-circle"></i> Add new customer</a>
 						<div class="clearfix"></div>
 					</h3>
 					
	 				<p><strong>Customer Name: </strong>{{customer_name}}</p>  
	 				<p><strong>Address: </strong>{{company_address}}</p> 
	 				<p><strong>Tel: </strong>{{tel}}</p>
 				</div>
 				<div class="col-md-6 block right">
 					<h3>Invoice No: <span><input type="text" class="pull-right form-control col-md-4" style="width: 200px; margin-top: -7px; margin-left: 10px;" ng-model="invoice_no" placeholder="Search for item"></span><div class="clearfix">	</div></h3>
 					<p>Date: {{date}} {{time}}</p>
 					<p>Invoiced By: {{role}}</p>
 				</div>
 			</div>
 			<div class="invoice_body row">
 				<div class="col-md-12">
 					<h2>Items Summery</h2>
 					<div class="row">	
						<div class="col-lg-6">
						    <div class="input-group">
						      	<input type="text" class="form-control" ng-model="item_barcode" placeholder="Search for item">
						      	<span class="input-group-btn">
						        	<md-button ng-click="searchItem()" class="btn btn_purple btn-default" type="button"> <i class="glyphicon glyphicon-search"></i> Search</md-button>
						      	</span>
						    </div>
						    <div class="clearfix"></div>
						</div>
						<div class="col-lg-12 item_list">

							<div ng-show="package_item != ''" ng-repeat="pkg in package_item" class="multiple_items"> 

								<ul class="item_list_inner">
									<li class="head">
										Package: #{{$index + 1}} - {{pkg.barcode_id}}  
									</li>
									<li ng-repeat="gip in pkg.package">    
										<div class="col-md-6">
											<p>{{gip.barcode}} - STK{{gip.id}}</p>
											<i>{{gip.item_name}} / {{gip.cat_name}} / manufacture: {{gip.manufacture_id}} ~  PKGid{{gip.package_id}} / GRN : {{gip.grn}}</i>
										</div>
										<div class="col-md-6">   
											<svg class="barcode code128sm pull-right" jsbarcode-value="{{gip.barcode}}"  jsbarcode-height="20" jsbarcode-width="1.5"  jsbarcode-fontSize="12"></svg>  

										</div> 
									</li>
								</ul>

							</div>


							
							<div ng-show="itemList != ''" class="single_item"> 
								<ul class="item_list_inner">
									<li class="head">
										Single Items
									</li>
									<li ng-repeat="il in itemList">   <!--  -->
										<div class="col-md-6">
											<p>{{il.barcode}} - STK{{il.id}}</p>
											<i>{{il.item_name}} / {{il.cat_name}} / manufacture: {{il.manufacture_id}} / GRN : {{il.grn}}</i>
										</div>
										<div class="col-md-6">  

											<script>JsBarcode("html .barcode" ).init();</script>
											<svg class="barcode code128sm pull-right" jsbarcode-value="{{il.barcode}}"  jsbarcode-height="20" jsbarcode-width="1.5"  jsbarcode-fontSize="12"></svg>  

										</div> 
									</li>
								</ul>
							</div> 
						</div> 
 					</div> 
 				</div>
 				 
				<div class="col-md-12 invoice_btn" ng-show="item_barcodes.length > 0 " > 
					<div class="pull-right">
						<md-button class="btn_purple " type="button" ng-click="saveInvoice()">Save Invoice</md-button>
						<md-button class="btn-default" ng-click="print()">Print</md-button> 
					</div> 
					<div class="clearfix"></div>
				</div> 
				 
 			</div>
 		</div>	
		<div class="clearfix"></div>
	</div>	

	<div id="myModalAddCustomer"  class="modal fade" role="dialog">
			<div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			     	<div class="modal-header"> 
				        <h4 class="modal-title">Add Customer</h4>
				      </div>
			      	<div class="modal-body">

						<form class="form-horizontal" name="addCustomer" id="addCustomer">
							<div class="row">
								 
							  	<div class="col-md-6">
								  	<div class="form-group" ng-class="{ 'has-error' : !addCustomer.customer_name.$pristine && addCustomer.customer_name.$touched && addCustomer.customer_name.$invalid }">
									    <label class="control-label col-sm-12" for="customer_name">Customer Name: <small class="help-block hide">Can't be empty</small></label>
									    <div class="col-sm-12">  
									      	<input type="text" class="form-control" id="customer_name" name="customer_name" ng-pattern="/^[a-zA-Z0-9 ]*$/" ng-model="customer_name" required> 
									      	<label class="error" >This field is required.</label>
									    </div>
								  	</div>
								</div>

								<div class="col-md-6">
								  	<div class="form-group" ng-class="{ 'has-error' : !addCustomer.customer_tel.$pristine && addCustomer.customer_tel.$touched && addCustomer.customer_tel.$invalid }">
									    <label class="control-label col-sm-12" for="customer_tel">Telephone: <small class="help-block hide">Can't be empty</small></label>
									    <div class="col-sm-12">  
									      	<input type="text" class="form-control" id="customer_tel" name="customer_tel" ng-pattern="/^[a-zA-Z0-9 ]*$/" ng-model="customer_tel" required> 
									      	<label class="error" >This field is required.</label>
									    </div>
								  	</div>
								</div>
							</div> 
						  	<div class="form-group">
							    <label class="control-label col-sm-12" for="customer_address">Address: <small class="help-block hide">Can't be empty</small> </label>
							    <div class="col-sm-12"> 
							    	<textarea name="" cols="30" rows="4" id="customer_address" ng-model="customer_address" class="form-control"></textarea> 
							    </div>
						  	</div>  
						  	<div class="form-group">
								<div class="col-md-12" ng-hide="addCustomer.$invalid">
									<md-button class="btn btn_add submit" type="submit" ng-click="addCustomer1()">Add Customer</md-button>
									<md-button class="btn btn-default" type="button" id="cancel" ng-click="close()">Close</md-button>
								</div> 
							</div> 
						</form>
			            <div class="clearfix"></div>
			      </div>
			     
			    </div>

			  </div>
		</div>

</div>





