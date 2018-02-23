<div ng-controller="addReturnsCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div>  
	   
		<md-button ng-click="navigateTo('returns')"><i class="icon-list-with-dots" aria-hidden="true"></i> View Return List</md-button>
	</div>
	<div class="body"> 
  
	    <form class="form-horizontal" name="addReturnForm" id="commentForm" > 
 				 
	        	<div class="row_">
		            <div class="col-md-6">
			 			<div class="form-group">
						    <label class="control-label col-sm-12" for="barcode">Barcode : <small class="help-block hide ">Must be a numeric value</small></label>
						    <div class="col-sm-12" ng-class="{ 'has-error' : !addReturnForm.barcode.$pristine && addReturnForm.barcode.$touched && addReturnForm.barcode.$invalid }">
						      <input type="text" class="form-control" id="barcode" name="barcode" ng-model="barcode"  required>  
						      <label class="error" >This field is required.</label>  
						    </div>
					  	</div>
			 		</div>  
			 		<div class="col-md-6">
			 			<div class="form-group">
						    <label class="control-label col-sm-12" for="rep_name">Rep Name : <small class="help-block hide ">Must be a numeric value</small></label>
						    <div class="col-sm-12" ng-class="{ 'has-error' : !addReturnForm.rep_name.$pristine && addReturnForm.rep_name.$touched && addReturnForm.rep_name.$invalid }">
						      <input type="text" class="form-control" id="rep_name" name="rep_name" ng-model="rep_name"  required>  
						      <label class="error" >This field is required.</label>  
						    </div>
					  	</div>
			 		</div>
				   
				  	<div class="clearfix"></div>
				</div>
			  	<div class="row_">
			  		<div class="col-md-12">
					  	<div class="form-group" ng-class="{ 'has-error' : addReturnForm.remarks.$touched && addReturnForm.remarks.$invalid }">
						    <label class="control-label col-sm-12" for="remarks">Return Note : <small class="help-block hide">Can't be empty</small></label>
						    <div class="col-sm-12"> 
						      	<textarea type="text" class="form-control" cols="30" rows="4" id="remarks" name="remarks" ng-model="remarks"  required>
						      		
						      	</textarea>
						      	<label class="error">This field is required.</label>
						    </div>
					  	</div>
				  	</div>  
			  		<div class="clearfix"></div>
			  	</div> 
 
	      
	       
	      
		  	 <div class="row_" >
				<div class="col-md-12"  ng-hide="addReturnForm.$invalid"> 
					<md-button class="btn_add" type="button" id="add_return_btn" ng-click="addReturn()">Add Return Details</md-button>
					<md-button class="btn-default" ng-click="close()">Close</md-button>

					<!-- <button class="btn btn_add submit" type="submit" id="add_item">Add Item</button> 
					<button class="btn btn-default" type="button">Cancel</button> -->
					<div class="clearfix"></div>
				</div> 
			</div>
			<div class="clearfix"></div>
	    </form>
  		



<!-- 		<div id="myModalAddCategory"  class="modal fade" role="dialog">
			<div class="modal-dialog">
 
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
 -->


	</div> 
	
</div>






