<div ng-controller="PackageCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('package/add-package')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Create New Package</md-button> 
	</div>
 
	<div class="body"> 

	    <table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" class="row-border hover table table-responsive table-bordered table-striped">

		</table>
		 
	</div>
</div>
