<div ng-controller="ItemsCtrl" class="page_inner {{animated_class}}">
	<!-- <div class="loader_ {{loader_class}}"></div> -->
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
		
		<md-button ng-click="navigateTo('items/add-item')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add Items</md-button> 
		<md-button class="dark_purple" ng-click="navigateTo('items/search-battery')" ><i class="icon-musica-searcher" aria-hidden="true"></i> Search Battery</md-button> 
	</div>
 
	<div class="body">  

		<table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" class="row-border hover table table-responsive table-bordered table-striped">
		
		</table> 
	    
	</div>
</div>
