<div ng-controller="ItemsCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('items/add-item')" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add Items</md-button> 
	</div>
 
	<div class="body"> 

	    <table datatable="ng" class="row-border hover table table-responsive table-bordered table-striped">
		    <thead>
			    <tr >
			        <th>Item Id</th>
			        <th>Item Name</th> 
			        <th>Item Display Name</th> 
			        <th>Category</th>  
			        <th> </th>
			    </tr>
		    </thead>
		    <tbody>
			    <tr ng-repeat="gi in getItem">
			        <td> <a href="" ng-click="viewItemStock(gi.item_id)">{{gi.item_id}}</a> </td>
			        <td> <a href="" ng-click="viewItemStock(gi.item_id)">{{gi.item_name}}</a> </td>
			        <td>{{gi.item_name}}</td>
			        <td>{{gi.cat_name}}</td> 
			        <td  width="100">  
						<a href="" id="view_stock{{gi.item_id}}" class="view_stock" ng-click="viewItemStock(gi.item_id)"> 
						 	<i class="glyphicon glyphicon-eye-open" title="View Stock" aria-hidden="true"></i>
						</a>
			        	<a href="" id="edit{{gi.item_id}}" ng-if="role_access" class="edit" title="Edit Items" ng-click="editItem(gi.item_id)">
			        		<i class="icon-pencil-edit-button" aria-hidden="true"></i>
			        	</a>
			        	<a href="" id="delete{{gi.item_id}}" ng-if="role_access" ng-click="deleteItem(gi.item_id)" class="delete" title="Delete Items" >
			        		<i class="icon-rubbish-bin" aria-hidden="true"></i>
			        	</a>
			        </td>
			    </tr>

		    </tbody>
		</table>
		 
	</div>
</div>
