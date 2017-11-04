
<div ng-controller="newinvoiceCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('invoice')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> View Invoice List</md-button> 
	</div>
 
	<div class="body"> 
 		<div class="col-md-12 invoice">
 			<div class="header row">
 				<div class="col-md-6 block left">
 					<h3>{{company_name}}</h3>
	 				<p><strong>Address: </strong>{{company_address}}</p>
	 				<p><strong>Email: </strong>{{email}}</p>
	 				<p><strong>Tel: </strong>{{tel}}</p>
 				</div>
 				<div class="col-md-6 block right">
 					<h3>Invoice No: <span>{{invoice_no}}</span></h3>
 					<p>Date: {{date}} {{time}}</p>
 					<p>Invoiced By: Admin</p>
 				</div>
 			</div>
 			<div class="invoice_body row">
 				<div class="col-md-12">
 					<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere, dicta, aliquam. Repellendus dolorem harum architecto dolore ratione, qui unde ex laborum aspernatur in accusamus quaerat quae facilis, ad perferendis beatae.</div>
 					<div>Necessitatibus totam accusantium culpa rerum placeat architecto commodi dolor, et error maiores. Totam blanditiis ullam nam consequatur repellendus cum maxime veniam, non praesentium, labore iste obcaecati voluptatum aut sit tempore.</div>
 				</div>
 			</div>
 		</div>	
		<div class="clearfix"></div>
	</div>	

</div>





