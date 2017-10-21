<div ng-controller="CategoryCtrl"  class="{{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('categories/add-category')" ><i class="icon-list-with-dots" aria-hidden="true"></i> Add Category</md-button>
	</div>
	<div class="body"> 
		
		<table datatable="ng" class="row-border hover table table-responsive table-bordered table-striped">
		    <thead>
			    <tr>
		         <!--  <th># Id</th> -->
			        <th>Category Id</th>
		          	<th>Category Name</th>
			      	<th>Description</th> 
			      	<th class="edit_btns"></th>   
			    </tr>
		    </thead>
		    <tbody>
				<tr ng-repeat="gc in getCategories">
			        <td>{{gc.id}}</td>
			        <td>{{gc.cat_name}}</td>
			        <td>{{gc.cat_desc}}</td> 
			        <td> 
 
			        	<a href="" id="edit{{gc.id}}" class="edit" ng-click="editCategory(gc.id)"><i class="icon-pencil-edit-button" aria-hidden="true"></i></a><a href="" id="delete{{gc.id}}" ng-click="deleteCategory(gc.id)" class="delete" ><i class="icon-rubbish-bin" aria-hidden="true"></i></a>
			        </td>
			    </tr> 
		    </tbody> 
		</table> 

	</div>


	  
</div>