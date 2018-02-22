<div ng-controller="ReturnsCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('returns/add-return')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add New Return</md-button> 
	</div>
 
	<div class="body"> 
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore eum magnam consequatur rerum tenetur pariatur fuga temporibus, eaque adipisci, eos possimus totam deserunt fugiat quam repellat fugit consequuntur recusandae dolorum.
	    <table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" class="row-border hover table table-responsive table-bordered table-striped">

		</table>
		 
	</div>
</div>

