<div ng-controller="ItemsStockCtrl" class="page_inner {{animated_class}}">
	
	
		<div class="head">
			<div class="top"> 
				<h2>View Item &amp; Stock </h2>
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
						<md-button ng-click="openModalAddStock()" class="top"><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add new battery</md-button>
						 
						<div class="clearfix"></div>
					</div>
					<table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstance" class="row-border hover table table-responsive table-bordered table-striped">
		  
					</table>

<!-- 				    <table  dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover table table-responsive table-bordered table-striped">
					    <thead>
						    <tr>
						    	
						    	<th class="hide">stock_id</th>
						        <th>Barcode</th>
						        <th title="Manufacture Id">Manufacture ID</th>  
						        <th>Invoice No</th>
						        <th>Supplier</th>
						        <th>Package</th>
						        <th>Status</th>
						       
						        <th> </th>
						    </tr>
					    </thead>
					    <tbody>
						    <tr ng-repeat="gis in getSingleIteminStock" >  
						    	<td class="hide">{{gis.stock_id}}</td>
						        <td> <a href="#items/view-barcode/{{gis.barcode}}">{{gis.barcode}} <i class="icon-printer pull-right print"></i></a></td> 
						        <td>{{gis.manufacture_id}}</td>
						        <td>{{gis.invoice_no}}</td>
						        <td>{{gis.sup_name}}</td>
						        <td>
						        	<span ng-show="gis.package_id == '0'" >-</span>
						        	<span ng-show="gis.package_id == '1'" >{{gis.package_id}}</span> 
						        </td>
						        <td>
						        	<span ng-show="gis.status == '0'" class="label label-danger" >Sold</span>
						        	<span ng-show="gis.package_id == '0' && gis.status == '1'" class="label label-success"  >In Stock</span>
						        	<span ng-click="viewPackage(gis.package_id)" ng-show="gis.package_id > '0' && gis.status == '1'" class="label label-warning"  >Packed</span>
						        </td>

						        <td > 
						        
			 						<a href="" id="edit{{gis.stock_id}}" ng-class="{'test': gis.status == '0'}" title="Edit Stock" class="edit" ng-click="gis.status == '1' && openEditStockModal(gis.stock_id)"><i class="icon-pencil-edit-button" aria-hidden="true"></i></a><a href="" title="Delete Stock" ng-if="role_access" ng-class="{'test': gis.status == '0'}"  id="delete{{gis.stock_id}}" ng-click="gis.status == '1' && deleteItem(gis.stock_id)" class="delete" ><i class="icon-rubbish-bin" aria-hidden="true"></i></a>
			 						
						        </td>
						    </tr>

					    </tbody>
					</table> -->


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


