<div ng-controller="AddSupplierCtrl" class="{{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

		<md-button ng-click="navigateTo('suppliers')" ><i class="icon-list-with-dots" aria-hidden="true"></i> View Suppliers</md-button>
	</div>
	<div class="body"> 

		<form class="form-horizontal" name="addSupplierForm" id="addSupplierForm" > 

		    <div class="row">
				<div class="col-md-6">
		 			<div class="form-group">
					    <label class="control-label col-sm-12" for="sup_id">Supplier ID <i>*</i> : <small class="help-block hide ">Must be a numeric value</small></label>
					    <div class="col-sm-12"  ng-class="{ 'has-error' : !addSupplierForm.sup_id.$pristine && addSupplierForm.sup_id.$touched && addSupplierForm.sup_id.$invalid }">
					      <input type="text" class="form-control" id="sup_id" name="sup_id" ng-model="sup_id"  required>
					      <label class="error" >This field is required.</label>    
					    </div>
				  	</div>
		 		</div>
			  	<div class="col-md-6">
				  	<div class="form-group" ng-class="{ 'has-error' : !addSupplierForm.sup_name.$pristine && addSupplierForm.sup_name.$touched && addSupplierForm.sup_name.$invalid }">
					    <label class="control-label col-sm-12" for="sup_name">Supplier Name <i>*</i> : <small class="help-block hide">Can't be empty</small></label>
					    <div class="col-sm-12"> 
					      	<input type="text" class="form-control" id="sup_name" name="sup_name" ng-model="sup_name" required>
					      	<label class="error" >This field is required.</label>    
					    </div>
				  	</div>
			  	</div>
			</div>
				<div class="row">
				<div class="col-md-6">
				  	<div class="form-group">
					    <label class="control-label col-sm-12" for="dealer">Dealer : <small class="help-block hide">Can't be empty</small></label>
					    <div class="col-sm-12"> 
					      	<input type="text" class="form-control" id="dealer" name="dealer" ng-model="dealer" > 
					    </div>
				  	</div>
				</div>
				<div class="col-md-6">
				  	<div class="form-group" ng-class="{ 'has-error' : !addSupplierForm.nic.$pristine && addSupplierForm.nic.$touched && addSupplierForm.nic.$invalid }">
					    <label class="control-label col-sm-12" for="nic">NIC <i>*</i> : <small class="help-block hide">Can't be empty</small></label>
					    <div class="col-sm-12"> 
					      	<input type="text" class="form-control" id="nic" name="nic" ng-model="nic" required> 
					      	<label class="error" >This field is required.</label>    
					    </div>
				  	</div>
				</div>
			</div>
		  	<div class="form-group">
			    <label class="control-label col-sm-12" for="sup_address">Address : <small class="help-block hide">Can't be empty</small> </label>
			    <div class="col-sm-12"> 
			    	<textarea name="" cols="30" rows="4" id="sup_address" class="form-control"  ng-model="address" ></textarea> 
			    </div>
		  	</div> 
		  	<div class="row">
				<div class="col-md-6">
				  	<div class="form-group">
					    <label class="control-label col-sm-12" for="tel">Tel <i>*</i> : <small class="help-block hide">Can't be empty</small></label>
					    <div class="col-sm-12"> 
					      	<input type="text" class="form-control" id="tel" name="tel" ng-model="tel" placeholder="Ex: 07********" required> 
					    </div>
				  	</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					    <label class="control-label col-sm-12" for="fax">Fax : <small class="help-block hide">Can't be empty</small></label>
					    <div class="col-sm-12"> 
					      	<input type="text" class="form-control" id="fax" name="fax" placeholder="Ex: 07********"  ng-model="fax" > 
					    </div>
				  	</div>
				</div>
			</div>
			<div class="form-group">
			    <label class="control-label col-sm-12" for="email">Email : <small class="help-block hide">Can't be empty</small></label>
			    <div class="col-sm-12"> 
			      	<input type="email" class="form-control" id="email" name="email"  ng-model="email"> 
			    </div>
		  	</div>

		    <div class="form-group">
				<div class="col-md-12" ng-hide="addSupplierForm.$invalid">
					<md-button class="btn btn_add submit" type="submit" ng-click="addSupplier()">Add Supplier</md-button>
					<md-button class="btn btn-default" type="button" id="cancel" ng-click="close()">Close</md-button>
				</div> 
			</div>
		    <p>
		      <!-- <input class="submit" type="submit" value="Submit" > -->
		      
		    </p>
		   
		</form> 

	</div>

</div>