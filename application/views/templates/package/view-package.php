<div ng-controller="viewPackageCtrl" class="page_inner {{animated_class}}">
	
	
		<div class="head">
			<div class="top"> 
				<h2>{{title}} </h2>
		  		<span class="breadcrumb">{{breadcrumb}}</span>
		  		<div class="clearfix"></div>
			</div> 
	 

		</div>
		
		<div class="row profile_details">
			
		 	
			<div class="col-md-4">
				<div class="mid" >  
			    		<div class="item_img row hide">
			    			<input type="file" file-model="myFile" id="imgInp" >
			    		</div>
				    	
		                <svg id="code128" class="barcode" ></svg>
		              
				        <div class="package_details_inner"> 
				        	<a href="" ng-show="status == 1" id="edit{{gis.item_id}}" class="edit" ng-click="editPackage()"><i class="icon-pencil-edit-button" aria-hidden="true"></i></a>
				        	<ul> 
				        		<li><strong>Package ID: </strong> {{pkg_id}}</li>
				        		<li><strong>Barcode: </strong> {{pkg_barcode}}</li> 
				        		<li><strong>Status: </strong> <span class="label " ng-class="label">{{labelText}}</span></li>
				        		<li><strong>Note: </strong> {{note}}</li> 
				        		
				        	</ul>
				        </div>
			      
			        <div class="clearfix"></div>
			  	</div> 
			</div>

			<div class="col-md-8">
				<div class="body"> 
					<div class="top_bar"> 

						<md-button ng-click="navigateTo('package')"  class="top"><i class="icon-list-with-dots" aria-hidden="true"></i> View Package List</md-button>   
						<div class="clearfix"></div>
					</div>
					

				    <table datatable="ng" class="row-border datatable hover table table-responsive table-bordered table-striped">
					    <thead>
						    <tr >
						        <th>#Index</th>
						        <th>Item Name</th> 
						        <th>Category</th> 
						        <th>Invoice No</th>
						        <th>Barcode</th>
						        <th class="hide"></th>   
						    </tr>
					    </thead>
					    <tbody>
					    	<tr ng-repeat="gi in getItemList" >
						        <td>#{{ $index + 1 }}</td>
						        <td><a href="" ng-click="viewItemStock(gi.item_id)">{{gi.item_name}}</a></td> 
						        <td>{{gi.cat_name}}</td> 
						        <td>{{gi.invoice_no}}</td> 
						        <td>{{gi.barcode}}</td>
						        <td class="hide"></td> 
						         
						    </tr>
					    </tbody>
					</table> 


					<div id="myModalAdd" class="modal fade" role="dialog">
					  	<div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					     
					      	<div class="modal-body">
								<h2>Add New Battery to Stock</h2>
					            <form class="form-horizontal" name="addItemStockForm" id="commentForm" > 
					              	<div class="price_column">
					              		<div class="row_">
					              			<div class="col-md-6">
											  	<div class="form-group" ng-class="{ 'has-error' : addItemForm.supplier.$touched && addItemForm.supplier.$invalid }">
												    <label class="control-label col-sm-12" for="supplier">Supplier : <small class="help-block hide">Can't be empty</small></label>
												    <div class="col-sm-12">  
												      	<select class="form-control" id="supplier" name="supplier" ng-model="supplier" required>
												      		<option ng-repeat="gsl in getSupplierList" value="{{gsl.sup_id}}"> {{gsl.sup_id}} -  {{gsl.sup_name}}</option> 
												      	</select> 
												      	<label class="error">This field is required.</label> 
												    </div>
											  	</div>
										  	</div>
										  	 <div class="col-md-6">
						                      <div class="form-group" ng-class="{ 'has-error' : addItemStockForm.barcode.$touched && addItemStockForm.barcode.$invalid }">
						                          <label class="control-label col-sm-12" for="barcode">Barcode No : <small class="help-block hide ">Can't be empty</small></label>
						                          <div class="col-sm-12">

						                            <input type="text" class="form-control" id="barcode" name="barcode" disabled="disabled" ng-model="barcode" required>  
						                            <label class="error">This field is required.</label> 
						                          </div>

						                        </div>
						                    </div>  
										  	<div class="clearfix"></div>
										</div>
					                  	<div class="row_"> 
						                   	<div class="col-md-6">
						                        <div class="form-group">
						                          <label class="control-label col-sm-12" for="manufacture_id">Manufacture ID : <small class="help-block hide">Can't be empty</small></label>
						                          <div class="col-sm-12"  ng-class="{ 'has-error' : addItemStockForm.manufacture_id.$touched && addItemStockForm.manufacture_id.$invalid }"> 
						                              <input type="text" class="form-control" id="manufacture_id" ng-change="getBarcode()" name="manufacture_id" ng-model="manufacture_id" required>
						                              <label class="error">This field is required.</label>  
						                          </div>
						                        </div>
						                    </div>
											<div class="col-md-6">
						                        <div class="form-group" ng-class="{ 'has-error' : addItemStockForm.invoice_id.$touched && addItemStockForm.invoice_id.$invalid }">
						                            <label class="control-label col-sm-12" for="invoice_id">Invoice No : <small class="help-block hide ">Must be a numeric value</small></label>
						                            <div class="col-sm-12">
						                                <input type="text" class="form-control" id="invoice_id" name="invoice_id" ng-model="invoice_id"  required>  
						                                <label class="error">This field is required.</label> 
						                            </div> 
						                          </div>
						                      </div> 
						                    <div class="clearfix"></div>
					                  	</div>

					                   	 
					                    <div class="row_">  
							  				<div class="col-md-12">
						                    	<svg id="code128" class=barcode></svg>
						                    </div>
					                	</div> 
						                <div class="clearfix"></div>
					                </div>
					              </form>
					            <div class="clearfix"></div>
					      </div>
					      <div class="modal-footer" ng-hide="addItemStockForm.$invalid">

					      	<md-button class="btn_add" type="button" id="edit_item"  ng-click="addStockItem(stock_id)">Add Stock</md-button>
							<md-button class="btn-default"  data-dismiss="modal">Close</md-button>

					        
					      </div>
					    </div>

					  </div>
					</div>
			 

					<div id="myModalEdit" class="modal fade" role="dialog">
					  	<div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					    
					      	<div class="modal-header hide">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Edit Item Stock</h4>
					      	</div>

					      	<div class="modal-body">
								<h2>Edit Item Stock</h2>
								<form class="form-horizontal" name="editItemStockForm" id="commentForm" > 
					              	<div class="price_column">
					              		<div class="row_">
					              			<div class="col-md-6">
											  	<div class="form-group" ng-class="{ 'has-error' : editItemStockForm.supplier.$touched && editItemStockForm.supplier.$invalid }">
												    <label class="control-label col-sm-12" for="supplier">Supplier : <small class="help-block hide">Can't be empty</small></label>
												    <div class="col-sm-12">  
												      	<select class="form-control" id="supplier" name="supplier" ng-model="supplier" required>
												      		<option ng-repeat="gsl in getSupplierList" value="{{gsl.sup_id}}"> {{gsl.sup_id}} -  {{gsl.sup_name}}</option> 
												      	</select> 
												      	<label class="error">This field is required.</label> 
												    </div>
											  	</div>
										  	</div>
										  	 <div class="col-md-6">
						                      <div class="form-group" ng-class="{ 'has-error' : editItemStockForm.barcode.$touched && editItemStockForm.barcode.$invalid }">
						                          <label class="control-label col-sm-12" for="barcode">Barcode No : <small class="help-block hide ">Can't be empty</small></label>
						                          <div class="col-sm-12">

						                            <input type="text" class="form-control" id="barcode" name="barcode" disabled="disabled" ng-model="barcode" required>  
						                            <label class="error">This field is required.</label> 
						                          </div>

						                        </div>
						                    </div>  
										  	<div class="clearfix"></div>
										</div>
					                  	<div class="row_"> 
						                   	<div class="col-md-6">
						                        <div class="form-group">
						                          <label class="control-label col-sm-12" for="manufacture_id">Manufacture ID : <small class="help-block hide">Can't be empty</small></label>
						                          <div class="col-sm-12"  ng-class="{ 'has-error' : editItemStockForm.manufacture_id.$touched && editItemStockForm.manufacture_id.$invalid }"> 
						                              <input type="text" class="form-control" id="manufacture_id" ng-change="getBarcode()" name="manufacture_id" ng-model="manufacture_id" required>
						                              <label class="error">This field is required.</label>  
						                          </div>
						                        </div>
						                    </div>
											<div class="col-md-6">
						                        <div class="form-group" ng-class="{ 'has-error' : editItemStockForm.invoice_id.$touched && editItemStockForm.invoice_id.$invalid }">
						                            <label class="control-label col-sm-12" for="invoice_id">Invoice No : <small class="help-block hide ">Must be a numeric value</small></label>
						                            <div class="col-sm-12">
						                                <input type="text" class="form-control" id="invoice_id" name="invoice_id" ng-model="invoice_id"  required>  
						                                <label class="error">This field is required.</label> 
						                            </div> 
						                          </div>
						                      </div> 
						                    <div class="clearfix"></div>
					                  	</div>

					                   	 
					                    <div class="row_">  
							  				<div class="col-md-12">
						                    	<svg id="code128" class=barcode></svg>
						                    </div>
					                	</div> 
						                <div class="clearfix"></div>
					                </div>
					              </form>

					             
					            <div class="clearfix"></div>
					      </div>
					      <div class="modal-footer">

					      	<md-button class="btn_add" type="button" id="edit_item"   ng-click="editStockItem(stock_id)">Edit Stock</md-button>
							<md-button class="btn-default"  data-dismiss="modal">Close</md-button>

					        
					      </div>
					    </div>

					  </div>
					</div>

						 
				</div>
			</div>
		</div>
</div>


