
<div ng-controller="viewInvoiceCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('invoice')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i>  View Invoice List </md-button> 
	</div>
 
	<div class="body invoice"> 

	 	<div class="col-md-12 ">
 			<div class="header row">
 				<div class="col-md-6 block left">
 					<h3 class="company_name">{{company_name}}</h3>
	 				<p><strong>Address: </strong>{{company_address}}</p>
	 				<p><strong>Email: </strong>{{email}}</p>
	 				<p><strong>Tel: </strong>{{tel}}</p>
 				</div>
 				<div class="col-md-6 block right">
 					<h3>Invoice No: <span>{{invoice_no}}</span></h3>
 					<p>Date: {{invoice_date}}</p>
 					<p>Invoiced By: Admin</p>
 				</div>
 			</div>
 			<div class="invoice_body row">
 				<div class="col-md-12">
 					<h2>Items Summery</h2>
 					<div class="row">	
						
						<div class="col-lg-12 item_list">

							<div ng-show="package_item != ''" ng-repeat="pkg in package_item" class="multiple_items"> 

								<ul class="item_list_inner">
									<div class="head">
										Package: #{{$index + 1}} - {{pkg.barcode_id}}  
									</div>
									<li ng-repeat="gip in pkg.package">    
										<div class="col-md-6">
											<p>{{gip.barcode}}</p>
											<i>{{gip.item_name}} / {{gip.cat_name}} / manufacture: {{gip.manufacture_id}} ~  PKGid{{gip.package_id}}</i>
										</div>
										<div class="col-md-5">   
											<svg class="barcode code128sm pull-right" jsbarcode-value="{{gip.barcode}}"  jsbarcode-height="20" jsbarcode-width="1.5"  jsbarcode-fontSize="12"></svg>  

										</div>
										<div class="col-md-1 text-center">
											<a href="" ng-click="deleteItem(gip.barcode)" class="delete" title="Delete Items" >
								        		<i class="icon-rubbish-bin" aria-hidden="true"></i>
								        	</a>
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
											<p>{{il.barcode}}</p>
											<i>{{il.item_name}} / {{il.cat_name}} / manufacture: {{il.manufacture_id}} </i>
										</div>
										<div class="col-md-5">  

											<script>JsBarcode("html .barcode" ).init();</script>
											<svg class="barcode code128sm pull-right" jsbarcode-value="{{il.barcode}}"  jsbarcode-height="20" jsbarcode-width="1.5"  jsbarcode-fontSize="12"></svg>  

										</div>
										<div class="col-md-1 text-center">
											<a href="" ng-click="deleteItem(il.barcode)" class="delete" title="Delete Items" >
								        		<i class="icon-rubbish-bin" aria-hidden="true"></i>
								        	</a>
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

</div>




