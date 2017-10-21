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
	    		<div class="item_img row">
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
						    <label class="control-label col-sm-12" for="category">Category : <small class="help-block hide">Can't be empty</small></label>
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
	         
	        

			<!-- price -->
	     

	       
	      
		  	 <div class="form-group" >
				<div class="col-md-12"  ng-hide="addItemForm.$invalid"> 
					<md-button class="btn_add" type="button" id="add_item" ng-click="addItem()">Add Item</md-button>
					<md-button class="btn-default" ng-click="close()">Close</md-button>

					<!-- <button class="btn btn_add submit" type="submit" id="add_item">Add Item</button> 
					<button class="btn btn-default" type="button">Cancel</button> -->
				</div> 
			</div>
	    </form>
	</div>
</div>
