
<div ng-controller="viewInvoiceCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('invoice')" ><i class="icon-list-with-dots" aria-hidden="true"></i>  View Invoice List </md-button> 
	</div>
 
	<div class="body invoice" > 

	 	<div class="col-md-12 " id="invoice">
 			<div class="header row">
 				<div class="col-md-6 block left" ng-if="isCustomerInvoice">
 					<h3 class="company_name">Customer Details</h3>
 					<p><strong>Customer Name: </strong>{{customer_name}}</p> 
	 				<p><strong>Address: </strong>{{address}}</p> 
	 				<p><strong>Tel: </strong>{{tel}}</p>
 				</div>
 				<div class="col-md-6 block " ng-class="{'right': isCustomerInvoice}">
 					<h3>Invoice No: <span>{{invoice_no}}</span></h3>
 					<p>Date: {{invoice_date}}</p>
 					<p>Invoiced By: {{invoiced_by}}</p>
 				</div>
 			</div>
 			<div class="invoice_body row">
 				<div class="col-md-12">
 					<h2>Items Summery</h2>
 					<div class="row">	
						
						<div class="col-lg-12 item_list">

							<div ng-show="package_item != ''" ng-repeat="pkg in package_item" class="multiple_items"> 

								<ul class="item_list_inner ">
									<div class="head">
										Package: #{{$index + 1}} - {{pkg.barcode_id}}  
									</div>
									<li ng-repeat="gip in pkg.package">    
										<div class="col-md-6 details">
											<p>{{gip.barcode}}</p>
											<i>{{gip.item_name}} / {{gip.cat_name}} / manufacture: {{gip.manufacture_id}} ~  PKGid{{gip.package_id}}</i>
										</div>
										<div class="col-md-6 gen_bk">   
											<svg class="barcode code128sm pull-right" jsbarcode-value="{{gip.barcode}}"  jsbarcode-height="20" jsbarcode-width="1.5"  jsbarcode-fontSize="12"></svg>  

										</div> 
									</li>
								</ul>

							</div>


							
							<div ng-show="getSingleItemsInvoiced != ''" class="single_item"> 
								<script>JsBarcode("html .barcode" ).init();</script>
								<ul class="item_list_inner margin0">
									<li class="head">
										Single Items
									</li>
									<li ng-repeat="il in getSingleItemsInvoiced">   <!--  -->
										<div class="col-md-6 details">
											<p>{{il.barcode}}</p>
											<i>{{il.item_name}} / {{il.cat_name}} / manufacture: {{il.manufacture_id}} </i>
										</div>
										<div class="col-md-6 gen_bk">   
											<svg class="barcode code128sm pull-right" jsbarcode-value="{{il.barcode}}"  jsbarcode-height="20" jsbarcode-width="1.5"  jsbarcode-fontSize="12"></svg>  

										</div>
										 
									</li>
								</ul>
							</div> 
							 
						</div> 
 					</div> 
 				</div> 
 			</div>
 		</div>
 		<div class="col-md-12 invoice_btn"" > 
			<div class="pull-right">
			<!-- 	<md-button class="btn_purple " type="button" ng-click="saveInvoice()">Save Invoice</md-button> -->
				<md-button class="btn_purple" ng-click="printDiv()"><i class="icon-printer print" aria-hidden="true"></i>&nbsp; Print</md-button> 
			</div> 
			<div class="clearfix"></div>
		</div> 
		<div class="clearfix"></div>
	</div>	

</div>





