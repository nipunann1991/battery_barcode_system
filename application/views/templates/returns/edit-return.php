<div ng-controller="editReturnsCtrl" class="page_inner {{animated_class}}">
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
			 		<div class="col-md-6">
			 			<div class="form-group">
						    <label class="control-label col-sm-12" for="return_date">Return Date :  
						    <div class="col-sm-12 padding0" ng-class="{ 'has-error' : !addReturnForm.return_date.$pristine && addReturnForm.return_date.$touched && addReturnForm.return_date.$invalid }">
						       	<md-datepicker ng-model="return_date" md-placeholder="Enter date"></md-datepicker> 
						      	<label class="error" >This field is required.</label>  
						    </div>
					  	</div>
			 		</div>
				   	
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
					<md-button class="btn_add" type="button" id="add_return_btn" ng-click="editReturn()">Edit Details</md-button>
					<md-button class="btn-default" ng-click="close()">Close</md-button>

					<!-- <button class="btn btn_add submit" type="submit" id="add_item">Add Item</button> 
					<button class="btn btn-default" type="button">Cancel</button> -->
					<div class="clearfix"></div>
				</div> 
			</div>
			<div class="clearfix"></div>
	    </form>
  		 
 

	</div> 
	
</div>






