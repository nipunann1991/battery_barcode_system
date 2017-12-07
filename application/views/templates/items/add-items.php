<div ng-controller="addItemsCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div>  
	   
		<md-button ng-click="navigateTo('items')"><i class="icon-list-with-dots" aria-hidden="true"></i> View Items</md-button>
	</div>
	<div class="body"> 
  
	    <form class="form-horizontal" name="addItemForm" id="commentForm" > 
 				 
	    	<div class="col-md-3">
	    		<div class="item_img pull-left row">
	    			<input type="file" file-model="myFile" id="imgInp" >
	    		</div>

	    	</div> 
	        <div class="col-md-9"> 
	        	<div class="row_">
		            <div class="col-md-6">
			 			<div class="form-group">
						    <label class="control-label col-sm-12" for="item_id">Item ID : <small class="help-block hide ">Must be a numeric value</small></label>
						    <div class="col-sm-12" ng-class="{ 'has-error' : !addItemForm.item_id.$pristine && addItemForm.item_id.$touched && addItemForm.item_id.$invalid }">
						      <input type="text" class="form-control" id="item_id" name="item_id" ng-model="item_id"  required>  
						      <label class="error" >This field is required.</label>  
						    </div>
					  	</div>
			 		</div> 
			 		<div class="col-md-6">
					  	<div class="form-group" ng-class="{ 'has-error' : addItemForm.category.$touched && addItemForm.category.$invalid }">
						    <label class="control-label col-sm-12" for="category">Category : <small class="help-block hide">Can't be empty</small> <a ng-click="add_category()" class="pull-right"><i class="icon-plus-sign-in-a-black-circle"></i> Add new category</a> </label>
						    <div class="col-sm-12"> 
						    	<select class="form-control" id="category" name="category" ng-model="category" required>
						    		<option ng-repeat="gcl in getCategoryList" value="{{gcl.id}}">{{gcl.id}} - {{gcl.cat_name}}</option> 
						    	</select>

						    	<label class="error">This field is required.</label> 
						    </div>
					  	</div>
				  	</div>
				   
				  	<div class="clearfix"></div>
				</div>
			  	<div class="row_">
			  		<div class="col-md-6">
					  	<div class="form-group" ng-class="{ 'has-error' : addItemForm.item_name.$touched && addItemForm.item_name.$invalid }">
						    <label class="control-label col-sm-12" for="item_name">Item Name : <small class="help-block hide">Can't be empty</small></label>
						    <div class="col-sm-12"> 
						      	<input type="text" class="form-control" id="item_name" name="item_name" ng-model="item_name"  required> 
						      	<label class="error">This field is required.</label>
						    </div>
					  	</div>
				  	</div> 
				  	<div class="col-md-6">
				  		<div class="form-group">
						  	<div class="checkbox related_input">
							  	<label><input type="checkbox" id="use_item_display_name" ng-model="use_item_display_name" ng-change="checked(use_item_display_name)" value="">Use same as Item Display Name.</label> 
							</div>
						</div>
				  	</div>
			  		<div class="clearfix"></div>
			  	</div> 
			  	<div class="row_"> 
				  	<div class="col-md-6">
			 			<div class="form-group" ng-class="{ 'has-error' : addItemForm.item_display_name.$touched && addItemForm.item_display_name.$invalid }">
						    <label class="control-label col-sm-12" for="item_display_name">Item Display Name : <small class="help-block hide ">Must be a numeric value</small></label>
						    <div class="col-sm-12">
						      <input type="text" class="form-control" id="item_display_name" name="item_display_name" ng-model="item_display_name" required>  
						      <label class="error">This field is required.</label>
						    </div>
					  	</div>
			 		</div>
				  	<div class="clearfix"></div>
		        </div>
		 		 
	        </div> 
	       
	      
		  	 <div class="form-group" >
				<div class="col-md-12"  ng-hide="addItemForm.$invalid"> 
					<md-button class="btn_add" type="button" id="add_item" ng-click="addItem()">Add Item</md-button>
					<md-button class="btn-default" ng-click="close()">Close</md-button>

					<!-- <button class="btn btn_add submit" type="submit" id="add_item">Add Item</button> 
					<button class="btn btn-default" type="button">Cancel</button> -->
				</div> 
			</div>
	    </form>
  		



		<div id="myModalAddCategory"  class="modal fade" role="dialog">
			<div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			     	<div class="modal-header"> 
				        <h4 class="modal-title">Add Category</h4>
				      </div>
			      	<div class="modal-body">

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
			            <div class="clearfix"></div>
			      </div>
			     
			    </div>

			  </div>
		</div>



	</div> 
	
</div>






