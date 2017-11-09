
<div ng-controller="invoiceCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('invoice/new-invoice')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Create New Invoice</md-button> 
	</div>
 
	<div class="body"> 

	 	<table datatable="ng" class="row-border hover table table-responsive table-bordered table-striped">
		    <thead>
			    <tr >
			        <th>Invoice Id</th>
			        <th>Invoice Date</th>
			        <th>No of Items</th>   
			        <th> </th>
			    </tr>
		    </thead>
		    <tbody>
			    <tr ng-repeat="gi in getInvoiceList">
			        <td> <a href="" ng-click="viewPackageStock(gi.pkg_id)">{{gi.invoice_id}}</a> </td> 
			        <td>{{gi.invoice_no}}</td> 
			        <th> </th>
			        <td  width="100">  
						<a href="" id="view_stock{{gi.pkg_id}}" class="view_stock" ng-click="viewPackageStock(gi.pkg_id)"> 
						 	<i class="glyph
						 	icon glyphicon-eye-open" title="View Stock" aria-hidden="true"></i>
						</a>
			        	<a href="" id="edit{{gi.pkg_id}}" ng-if="role_access" class="edit" title="Edit Items" ng-click="editPackage(gi.pkg_id)">
			        		<i class="icon-pencil-edit-button" aria-hidden="true"></i>
			        	</a>
			        	<a href="" id="delete{{gi.pkg_id}}" ng-if="role_access" ng-click="deletePackage(gi.pkg_id)" class="delete" title="Delete Items" >
			        		<i class="icon-rubbish-bin" aria-hidden="true"></i>
			        	</a>
			        </td>
			    </tr>

		    </tbody>
		</table>

	</div>	

</div>





