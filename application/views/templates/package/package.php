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

	    <table datatable="ng" class="row-border hover table table-responsive table-bordered table-striped">
		    <thead>
			    <tr >
			        <th>Package Id</th>
			        <th>Package Barcode</th> 
			        <th>Items</th>  
			        <th> </th>
			    </tr>
		    </thead>
		    <tbody>
			    <tr ng-repeat="gi in getItem">
			        <td> <a href="" ng-click="viewItemStock(gi.item_id)">{{gi.pkg_id}}</a> </td>
			        <td> <a href="" ng-click="viewItemStock(gi.item_id)">{{gi.pkg_barcode}}</a> </td>
			        <td>{{gi.pkg_items}}</td> 
			        <td  width="100">  
						<a href="" id="view_stock{{gi.pkg_id}}" class="view_stock" ng-click="viewItemStock(gi.pkg_id)"> 
						 	<i class="glyphicon glyphicon-eye-open" title="View Stock" aria-hidden="true"></i>
						</a>
			        	<a href="" id="edit{{gi.pkg_id}}" ng-if="role_access" class="edit" title="Edit Items" ng-click="editItem(gi.pkg_id)">
			        		<i class="icon-pencil-edit-button" aria-hidden="true"></i>
			        	</a>
			        	<a href="" id="delete{{gi.pkg_id}}" ng-if="role_access" ng-click="deleteItem(gi.pkg_id)" class="delete" title="Delete Items" >
			        		<i class="icon-rubbish-bin" aria-hidden="true"></i>
			        	</a>
			        </td>
			    </tr>

		    </tbody>
		</table>
		 
	</div>
</div>
