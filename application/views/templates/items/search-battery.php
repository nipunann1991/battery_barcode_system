<div ng-controller="SearchItemsCtrl" class="page_inner {{animated_class}}">
	<!-- <div class="loader_ {{loader_class}}"></div> -->
	<div class="head">
		<div class="top"> 
			<h2>Search Battery</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
		
		<md-button ng-click="navigateTo('items')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> List Items</md-button> 
		 
	</div>
 
	<div class="body">  

		<div class="search_box">
 			<div class="col-lg-6 padding0">
			    <div class="input-group">
			      	<input type="text" class="form-control" ng-model="item_barcode" placeholder="Search for Battery">
			      	<span class="input-group-btn">
			        	<button class="btn btn_purple btn-default md-button md-ink-ripple" type="button" ng-click="searchBAttery()"> <i class="glyphicon glyphicon-search ng-scope"></i> Search</button>
			      	</span>
			    </div>
			    <div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="battery_details" > 
			<h3>Battery Details Summery</h3>
			<svg id="code128" class=barcode></svg>
			<div class="detail_row" ng-show="foundItem">
				<ul>
					<li><strong>Item Barcode :</strong> {{barcode}} <span class="label" ng-class="{ 'label-success' : status == '1', 'label-danger': status == '0', 'label-warning': status == '-1' }">{{status_text}}</span></li> 
					<li><strong>Package Barcode :</strong> {{package_barcode}}</li>
					<li><strong>Category Name :</strong> {{cat_name}}</li>
					<li><strong>Manufacture ID :</strong> {{manufacture_id}} </li> 
					<li><strong>Item Name :</strong> {{item_name}}</li>
					<li><strong>Invoice No :</strong> {{invoice_no}}</li>
					<li><strong>GRN :</strong> {{grn}}</li> 
					<li><strong>Supplier Name :</strong> {{sup_name}}</li>  
				</ul>
			</div>

			<div class="detail_row last" ng-show="soldItem">
				<h4>{{invoice_title}}</h4>
				<ul>
					<li><strong>Invoice no :</strong> {{invoice_number}}</li> 
					<li><strong>Invoice Date :</strong> {{invoice_date}}</li>
					<li><strong>Invoiced By :</strong> {{invoiced_by}}</li> 
					<li><strong>No of Items :</strong> {{no_of_items}}</li> 
					<li class="customer_details" ng-show="isCustomer">
						<span><strong>Customer Name :</strong> {{customer_name}}</span>
						<span><strong>Address :</strong> {{address}}</span>
						<span><strong>Telephone :</strong> {{tel}}</span> 
					</li>   
				</ul>

				<md-button ng-click="returnItem()" class="btn_purple btn" >Return Item</md-button> 
			</div>
			 
		</div>
	 
	    
	</div>
</div>
