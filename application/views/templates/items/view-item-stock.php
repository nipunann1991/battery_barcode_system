<div ng-controller="ItemsStockCtrl" class="page_inner {{animated_class}}">
	
	
		<div class="head">
			<div class="top"> 
				<h2>View Packages List</h2>
		  		<span class="breadcrumb">{{breadcrumb}}</span>
		  		<div class="clearfix"></div>
			</div> 
	 

		</div>
		
		<div class="row profile_details">
			
		 	
			<div class="col-md-3">
				<div class="mid" >
					 
			  		<a href="" id="edit{{gis.item_id}}" class="edit" ng-click="editItem(item_id)"><i class="icon-pencil-edit-button" aria-hidden="true"></i></a>
			  		
			    		<div class="item_img row">
			    			<input type="file" file-model="myFile" id="imgInp" >
			    		</div>
			    	
			        <div class="">
			        	<h2>{{item_display_name}} </h2>
			        	<p>{{item_name}}</p>
			        	<ul> 
			        		<li><strong>Categoty ID: </strong> {{category_id}}</li>
			        		<li><strong>Categoty Name: </strong> {{category_name}}</li>
			        		<!-- <li><strong>Supplier ID: </strong>{{supplier_id}}</li>
			        		<li><strong>Supplier Name: </strong>{{supplier_name}}</li> -->
			        		
			        	</ul>
			        </div>
			      
			        <div class="clearfix"></div>
			  	</div> 
			</div>

			<div class="col-md-9">
				<div class="body"> 
					<div class="top_bar"> 

						<md-button ng-click="navigateTo('items')"  class="top"><i class="icon-list-with-dots" aria-hidden="true"></i> View Items List</md-button> 
						<md-button ng-click="openAddBulkStock()" class="top"><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add New Packages</md-button>
					<!-- 	<md-button ng-click="openModalAddStock()" class="top"><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add Single battery</md-button> -->
						 
						<div class="clearfix"></div>
					</div>
					<table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstance" class="row-border hover table table-responsive table-bordered table-striped">
		  
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
					
					<div id="addBulkStock" class="modal fade" role="dialog">
					  	<div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					    
					      	<div class="modal-header hide">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Add Bulk Stock</h4>
					      	</div>

					      	<div class="modal-body">
								<h2>Add Bulk Stock</h2>
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
						                        <div class="form-group" ng-class="{ 'has-error' : editItemStockForm.invoice_id.$touched && editItemStockForm.invoice_id.$invalid }">
						                            <label class="control-label col-sm-12" for="invoice_id">Invoice No : <small class="help-block hide ">Must be a numeric value</small></label>
						                            <div class="col-sm-12">
						                                <input type="text" class="form-control" id="invoice_id" name="invoice_id" ng-model="invoice_id" ng-change="getBarcode()" required>  
						                                <label class="error">This field is required.</label> 
						                            </div> 
						                        </div>
						                     </div> 
						                  
						                    <div class="col-md-6">
						                        <div class="form-group" ng-class="{ 'has-error' : editItemStockForm.grn.$touched && editItemStockForm.grn.$invalid }">
						                            <label class="control-label col-sm-12" for="grn">Goods Recieve No (GRN): <small class="help-block hide ">Must be a numeric value</small></label>
						                            <div class="col-sm-12">
						                                <input type="text" class="form-control" id="grn" name="grn" ng-model="grn" ng-change="getBarcode()" required>  
						                                <label class="error">This field is required.</label> 
						                            </div> 
						                        </div>
						                     </div>

						                     <div class="col-md-4">
						                        <div class="form-group">
						                          <label class="control-label col-sm-12" for="bat_qty">Battery Quantity : <small class="help-block hide">Can't be empty</small></label>
						                          <div class="col-sm-12"  ng-class="{ 'has-error' : editItemStockForm.bat_qty.$touched && editItemStockForm.bat_qty.$invalid }"> 
						                              <input type="text" class="form-control" id="bat_qty" ng-change="getBarcode()" name="bat_qty" ng-model="bat_qty" required>
						                              <label class="error">This field is required.</label>  
						                          </div>
						                        </div>
						                    </div> 
						                    <div class="col-md-4">
						                        <div class="form-group" ng-class="{ 'has-error' : editItemStockForm.pkg_qty.$touched && editItemStockForm.pkg_qty.$invalid }">
						                            <label class="control-label col-sm-12" for="pkg_qty">Package Quantity: <small class="help-block hide ">Must be a numeric value</small></label>
						                            <div class="col-sm-12">
						                                <input type="text" class="form-control" id="pkg_qty" name="pkg_qty" ng-model="pkg_qty" ng-change="getBarcode()" required>  
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

					      	<md-button class="btn_add" type="button" id="edit_item"   ng-click="addBulkStockItem()">Add Bulk Stock</md-button>
							<md-button class="btn-default"  data-dismiss="modal">Close</md-button>

					        
					      </div>
					    </div>

					  </div>
					</div>


						 
				</div>
			</div>
		</div>
</div>


