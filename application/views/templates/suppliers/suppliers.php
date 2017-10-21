<div ng-controller="SupplierCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('suppliers/add-suppliers')" ><i class="icon-list-with-dots" aria-hidden="true"></i> Add Supplier</md-button>
	</div>
	<div class="body"> 
		
		<table datatable="ng" class="row-border hover table table-responsive table-bordered table-striped">
		    <thead>
			    <tr>
		         <!--  <th># Id</th> -->
			        <th>Supplier Id</th>
		          	<th>Supplier Name</th>
		          	<th>Dealer</th>
		          	<th>NIC</th>
			      	<th>Address</th> 
			      	<th>Tel</th> 
			      	<th>Fax</th> 
			      	<th>Email</th>
			      	<th class="edit_btns"></th>   
				
			    </tr>
		    </thead>
		    <tbody>
				  <tr ng-repeat="gs in getSuppliers">
			        <td>{{gs.sup_id}}</td> 
			        <td>{{gs.sup_name}}</td> 
			        <td>{{gs.dealer}}</td> 
			        <td>{{gs.nic}}</td> 
			        <td>{{gs.address}}</td> 
			        <td>{{gs.tel}}</td> 
			        <td>{{gs.fax}}</td> 
			        <td>{{gs.email}}</td> 
			        <td>  
			        	<a href="" id="edit{{gs.sup_id}}" class="edit" ng-click="editSupplier(gs.sup_id)"><i class="icon-pencil-edit-button" aria-hidden="true"></i></a><a href="" id="delete{{gs.sup_id}}" ng-click="deleteSupplier(gs.sup_id)" class="delete" ><i class="icon-rubbish-bin" aria-hidden="true"></i></a>
			        </td>
			    </tr>
		
		    </tbody> 
		</table> 

	</div>
	  
 </div>