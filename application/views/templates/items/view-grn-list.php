<div ng-controller="ItemsGrnCtrl" class="page_inner {{animated_class}}">
	<!-- <div class="loader_ {{loader_class}}"></div> -->
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
		
		<md-button ng-click="navigateTo('items')"><i class="icon-list-with-dots" aria-hidden="true"></i> View Items</md-button>
	</div>
 
	<div class="body">  

		<table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" class="row-border hover table table-responsive table-bordered table-striped">
		
		</table> 
	    
	</div>
</div>
