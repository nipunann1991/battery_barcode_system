<div ng-controller="AddCategoriesCtrl" class="{{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('categories')" ><i class="icon-list-with-dots" aria-hidden="true"></i> View Categories</md-button>
	</div>
	<div class="body">
		<form class="form-horizontal" name="addCategory" id="addCategory">
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" ng-class="{ 'has-error' : !addCategory.cat_id.$pristine && addCategory.cat_id.$touched && addCategory.cat_id.$invalid }">
					    <label class="control-label col-sm-12" for="cat_id">Category ID: <small class="help-block hide ">Must be a numeric value</small></label>
					    <div class="col-sm-12">
					      <input type="text" class="form-control" id="cat_id" name="cat_id" ng-model="cat_id" disabled required>
					      <label class="error" >This field is required.</label>   
					    </div>
				  	</div>
				</div>
			  	<div class="col-md-6">
				  	<div class="form-group" ng-class="{ 'has-error' : !addCategory.cat_name.$pristine && addCategory.cat_name.$touched && addCategory.cat_name.$invalid }">
					    <label class="control-label col-sm-12" for="cat_name">Category Name: <small class="help-block hide">Can't be empty</small></label>
					    <div class="col-sm-12">  
					      	<input type="text" class="form-control" id="cat_name" name="cat_name" ng-pattern="/^[a-zA-Z0-9 ]*$/" ng-model="cat_name" required> 
					      	<label class="error" >This field is required.</label>
					    </div>
				  	</div>
				</div>
			</div> 
		  	<div class="form-group">
			    <label class="control-label col-sm-12" for="cat_desc">Category Description: <small class="help-block hide">Can't be empty</small> </label>
			    <div class="col-sm-12"> 
			    	<textarea name="" cols="30" rows="4" id="cat_desc" ng-model="cat_desc" class="form-control"></textarea> 
			    </div>
		  	</div>  
		  	<div class="form-group">
				<div class="col-md-12" ng-hide="addCategory.$invalid">
					<md-button class="btn btn_add submit" type="submit" ng-click="addCategories()">Add Category</md-button>
					<md-button class="btn btn-default" type="button" id="cancel" ng-click="close()">Close</md-button>
				</div> 
			</div> 
		</form>
	</div>
</div>