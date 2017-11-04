<div ng-controller="editPackageCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div>  
	   
		<md-button ng-click="navigateTo('package')"><i class="icon-list-with-dots" aria-hidden="true"></i> View Packages</md-button>
	</div>
	<div class="body"> 

	 
	 
		
	    <form class="form-horizontal" name="addItemForm" id="commentForm" > 
 				 
	    	
	        <div class="col-md-12 padding0"> 
	        	<div class="row">
		            <div class="col-md-6">
			 			<div class="form-group">
						    <label class="control-label col-sm-12" for="item_barcode">Package Barcode : <small class="help-block hide ">Must be a numeric value</small></label>
						    <div class="col-sm-12" ng-class="{ 'has-error' : !addItemForm.item_barcode.$pristine && addItemForm.item_barcode.$touched && addItemForm.item_barcode.$invalid }">
						      <input type="text" class="form-control" id="item_barcode" name="item_barcode" disabled="disabled" ng-model="barcode"  required>  
						      <label class="error" >This field is required.</label>  
						    </div> 
					  	</div>
						<svg id="code128" class="barcode" ></svg>
			 		</div> 

			 		<div class="col-lg-6">
			        	<div class="form-group">
						    <label class="control-label col-sm-12" for="note">Package Note : <small class="help-block hide ">Must be a numeric value</small></label>
						    <div class="col-sm-12">
						    	<textarea type="text" class="form-control" id="note" name="note" ng-model="note" rows="5">  </textarea>
						   	</div>	
					  	</div> 
			        </div> 

			 		 
				   
				  	<div class="clearfix"></div>
				</div>
				 
			  	 
				<div class="col-md-12 add_items_package">	

					<div class="row">  
						<div class="col-lg-6">
						    <div class="input-group">
						      <input type="text" class="form-control" ng-model="item_barcode" placeholder="Search for item">
						      <span class="input-group-btn">
						        <md-button ng-click="searchItem()" class="btn btn_purple btn-default" type="button"> <i class="glyphicon glyphicon-search"></i> Search</md-button>
						      </span>
						    </div>
						    <div class="clearfix"></div>
						 </div>
						<div class="col-md-12 item_list">
							
							<div class="head">
								
							</div>
							<div class="col-md-12 padding0">

								<table datatable="ng" id="tbl_package_items" class="row-border hover table table-responsive table-bordered table-striped">
								    <thead>
									    <tr >
									        <th>#Index</th>
									        <th>Item Name</th> 
									        <th>Category</th> 
									        <th>Invoice No</th>
									        <th>Barcode</th>  
									        <th> </th>
									    </tr>
								    </thead>
								    <tbody>
								    	<tr ng-repeat="gi in getItemList" >
									        <th>#{{ $index + 1 }}</th>
									        <th>{{gi.item_name}}</th> 
									        <th>{{gi.cat_name}}</th> 
									        <th>{{gi.invoice_no}}</th> 
									        <th>{{gi.barcode}}</th> 
									        <!-- <th><svg id="code128sm" class="barcode" ></svg></th>   -->
									        <th>
												<a href="" id="delete{{gi.id}}" ng-if="role_access" ng-click="deleteItem(gi.stock_id, gi.barcode , $index)" class="delete ng-scope" title="Delete Items">
									        		<i class="icon-rubbish-bin" aria-hidden="true"></i>
									        	</a>
									        </th>
									    </tr>
								    </tbody>
								</table> 
								
							</div>
							 
						</div>

					</div>
					
				</div> 

	        </div>
	        	         	      
		  	 <div class="form-group" >
				<div class="col-md-12"  ng-show="getItemList.length > 1"> 
					<md-button class="btn_add" type="button" id="add_item" ng-click="addItem()">Save Package</md-button>
					<md-button class="btn-default" ng-click="close()">Close</md-button>

					<!-- <button class="btn btn_add submit" type="submit" id="add_item">Add Item</button> 
					<button class="btn btn-default" type="button">Cancel</button> -->
				</div> 
			</div>
	    </form>
	</div>
</div>
