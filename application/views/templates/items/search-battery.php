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
		<div class="battery_details"> 
			<h3>Battery Details Summery</h3>
			<svg id="code128" class=barcode></svg>
			<ul>
				<li><strong>Item Barcode :</strong> {{barcode}}</li> 
				<li><strong>Package Barcode :</strong> {{package_barcode}}</li>
				<li><strong>Category Name :</strong> {{cat_name}}</li>
				<li><strong>Item Name :</strong> {{item_name}}</li>
				<li><strong>Invoice No :</strong> {{invoice_no}}</li>
				<li><strong>GRN :</strong> {{grn}}</li> 
				<!-- <li></li> -->
			</ul>
		</div>
	 
	    
	</div>
</div>
