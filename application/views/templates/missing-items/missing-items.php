<div ng-controller="MissingCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('returns/add-missing-items')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add Missing Item</md-button> 
	</div>
 
	<div class="body"> 
	 
	    <table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" class="row-border hover table table-responsive table-bordered table-striped">

		</table>
		 
	</div>
</div>

