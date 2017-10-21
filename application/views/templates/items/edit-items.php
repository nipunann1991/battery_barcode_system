<div ng-controller="editItemsCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}} - {{item_name}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div>  
	    
	</div>
	<div class="body"> 
		
	    <form class="form-horizontal" name="addItemForm" id="commentForm" > 
	    	
	        <div class="col-md-9">
	        	<div class="row">
		        	<div class="row_">
			            <div class="col-md-6">
				 			<div class="form-group">
							    <label class="control-label col-sm-12" for="item_id">Item ID : <small class="help-block hide ">Must be a numeric value</small></label>
							    <div class="col-sm-12" ng-class="{ 'has-error' : !addItemForm.item_id.$pristine && addItemForm.item_id.$touched && addItemForm.item_id.$invalid }">
							      <input type="text" class="form-control" id="item_id" name="item_id" ng-model="item_id" disabled required>  
							      <label class="error" >This field is required.</label>  
							    </div>
						  	</div>
				 		</div>
				 		<div class="col-md-6">
						  	<div class="form-group" ng-class="{ 'has-error' : addItemForm.category.$touched && addItemForm.category.$invalid }">
							    <label class="control-label col-sm-12" for="category">Category : <small class="help-block hide">Can't be empty</small></label>
							    <div class="col-sm-12"> 
							    	<select class="form-control" id="category" name="category" ng-model="category" required>
							    		<option  ng-repeat="gcl in getCategoryList" ng-selected="category == gcl.id"  value="{{gcl.id}}">{{gcl.id}} - {{gcl.cat_name}}</option> 
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
	        </div>
	        <div class="col-md-3">
	    		<div class="item_img ">
	    			<input type="file" file-model="myFile" id="imgInp" >
	    		</div>
	    	</div>
	         <br/>
	         
	      	<div class="col-md-12"><br/></div>
		  	<div class="form-group" >
				<div class="col-md-12" ng-hide="addItemForm.$invalid" > 
					<div class="col-md-12">
						<md-button class="btn_add" type="button" id="add_item" ng-click="editItem()">Edit Item</md-button>
						<md-button class="btn-default" ng-click="navigateTo('items/view-item-stock')">Close</md-button>
					</div> 
				</div> 
			</div>
	    </form>
	</div>
</div>


<!-- <script src="assets/js/appItem.js"></script> -->