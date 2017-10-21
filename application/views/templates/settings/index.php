
<div ng-controller="SettingsCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

	 
	</div>
 
	<div class="body"> 

		<div ng-cloak>
		  <md-content>
		    <md-tabs md-dynamic-height md-border-bottom>
		    	<md-tab label="Company ">
			        <md-content class="md-padding"> 
			          	 
		          	 	<form class="form-horizontal" name="companyDetailsForm" id="commentForm" > 

				        	<div class="row">
				        		<div class="col-md-6">
				        			 
						 			<div class="form-group">
									    <label class="control-label col-sm-12" for="company_name">Company Name : <small class="help-block hide ">Must be a numeric value</small></label>
									    <div class="col-sm-12" ng-class="{ 'has-error' : !companyDetailsForm.company_name.$pristine && companyDetailsForm.company_name.$touched && companyDetailsForm.company_name.$invalid }">
									      <input type="text" class="form-control" id="company_name" name="company_name" ng-model="company_name"  required>  
									      <label class="error" >This field is required.</label>  
									    </div>
								  	</div>
						 		
						 			<div class="form-group">
									    <label class="control-label col-sm-12" for="company_address">Company Address : <small class="help-block hide ">Must be a numeric value</small></label>
									    <div class="col-sm-12" ng-class="{ 'has-error' : !companyDetailsForm.company_address.$pristine && companyDetailsForm.company_address.$touched && companyDetailsForm.company_address.$invalid }">
									      <textarea type="text" class="form-control" id="company_address" name="company_address" ng-model="company_address" rows="5" required>  </textarea>
									      <label class="error" >This field is required.</label>  
									    </div>
								  	</div>
						 		
						 			<div class="form-group">
									    <label class="control-label col-sm-12" for="company_tel">Company Tel : <small class="help-block hide ">Must be a numeric value</small></label>
									    <div class="col-sm-12" ng-class="{ 'has-error' : !companyDetailsForm.company_tel.$pristine && companyDetailsForm.company_tel.$touched && companyDetailsForm.company_tel.$invalid }">
									      <input type="text" class="form-control" id="company_tel" name="company_tel" ng-model="company_tel"  required>  
									      <label class="error" >This field is required.</label>  
									    </div>
								  	</div>
						 		
						 			<div class="form-group">
									    <label class="control-label col-sm-12" for="company_email">Company Email : <small class="help-block hide ">Must be a numeric value</small></label>
									    <div class="col-sm-12" ng-class="{ 'has-error' : !companyDetailsForm.company_email.$pristine && companyDetailsForm.company_email.$touched && companyDetailsForm.company_email.$invalid }">
									      <input type="text" class="form-control" id="company_email" name="company_email" ng-model="company_email"  required>  
									      <label class="error" >This field is required.</label>  
									    </div>
								  	</div>
							 		
								  	<div class="clearfix"></div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
									    <label class="control-label col-sm-12" for="company_note">Note : </label>
									    <div class="col-sm-12" >
									      <textarea type="text" class="form-control" id="company_note" name="company_note" ng-model="company_note" rows="17" >  </textarea>  
									    </div>
								  	</div>
								</div>
							</div>
						  	<div class="form-group" >
								<div class="col-md-12"  ><br/>  <!-- ng-hide="companyDetailsForm.$invalid" -->
									<md-button class="btn_add" type="button" id="add_item" ng-click="updateCompanyDetails()">Update Details</md-button>
									<md-button class="btn-default" ng-click="close()">Close</md-button> 
								</div> 
							</div>
					    </form>
			           
			        </md-content>
		      	</md-tab>
		      	<md-tab label="Users">
			        <md-content class="md-padding">
			        	<div class="row">
			        		<md-button class="dark_purple pull-right" ng-click="openAddUserModal()" ><i class="icon-plus-sign-in-a-black-circle" aria-hidden="true"></i> Add User</md-button> 
			        	</div> 
	          		    <table datatable="ng" class="row-border hover table table-responsive table-bordered table-striped">  <!-- datatable="ng"  -->
						    <thead>
							    <tr>
							        <th>Login ID</th>
							        <th>Username</th>
									<th>Password</th>
									<th>Role</th>
							        <th ng-if="role_access"> </th>
							    </tr>
						    </thead>
						    <tbody>
							     <tr ng-repeat="gu in getUsers" >
									<td>{{gu.login_id}}</td>
							        <td>{{gu.username}}</td>
									<td>
										********
										<a href="" id="view_stock1" class="view_stock pull-right links" ng-click="viewItemStock()"> 
										 	<i class="glyphicon glyphicon-eye-open" title="View Stock" aria-hidden="true"></i>
										</a>   
										
									</td>
									<td>{{gu.role_name}}</td>
							        
									<td ng-if="role_access"> 

				 						<a href="" id="edit{{gu.login_id}}" title="Edit User" ng-if="gu.role_id != '0'" class="edit" ng-click="editUser(gu.login_id)"><i class="icon-pencil-edit-button" aria-hidden="true"></i></a><a href="" title="Delete User" ng-if="gu.role_id != '0'" id="delete{{gu.login_id}}" ng-click="deleteUser(gu.login_id)" class="delete" ><i class="icon-rubbish-bin" aria-hidden="true"></i></a>
				 						
							        </td>
							        
							     </tr> 
						    </tbody>
						</table>
			        </md-content>
		      	</md-tab>
		      
		     
		    </md-tabs>
		  </md-content>
		</div> 
		 
	</div>

	<div id="modalAddUser" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    
      	<div class="modal-header hide">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add New User</h4>
      	</div>

      	<div class="modal-body">
			<h2>Add New User</h2>
            <form class="form-horizontal" name="addUser" id="commentForm" > 
              	<div class="inner_form">
              		
                  	<div class="row_">
	                    <div class="col-md-12">
	                      <div class="form-group" ng-class="{ 'has-error' : addUser.user.$touched && addUser.user.$invalid }">
	                          <label class="control-label col-sm-12" for="user">Username : <small class="help-block hide ">Can't be empty</small></label>
	                          <div class="col-sm-12">

	                            <input type="text" class="form-control" id="user" ng-minlength="4" name="user" ng-model="user" required>  
	                            <label class="error">Username must contain atleast 4 characters.</label> 
	                          </div>

	                        </div>
	                    </div> 

	                   	<div class="col-md-12">
	                        <div class="form-group">
	                          <label class="control-label col-sm-12" for="user_password">Password: <small class="help-block hide">Can't be empty</small></label>
	                          <div class="col-sm-12"  ng-class="{ 'has-error' : addUser.user_password.$touched && addUser.user_password.$invalid }"> 
	                              <input type="password" class="form-control" id="user_password" ng-minlength="6" name="user_password" ng-model="user_password" required>
	                              <label class="error">Password must contain atleast 6 characters</label>  
	                          </div>
	                        </div>
	                    </div>
	                    <div class="col-md-6">
						  	<div class="form-group" ng-class="{ 'has-error' : addUser.role.$touched && addUser.role.$invalid }">
							    <label class="control-label col-sm-12" for="role">Role : <small class="help-block hide">Can't be empty</small></label>
							    <div class="col-sm-12">  
							      	<select class="form-control" id="role" name="role" ng-model="role" required>
							      		<option ng-repeat="gr in getRoles" value="{{gr.role_id}}">  {{gr.role_name}}</option> 
							      	</select> 
							      	<label class="error">This field is required.</label> 
							    </div>
						  	</div>
					  	</div> 
	                    <div class="clearfix"></div>
                  	</div>

	                <div class="clearfix"></div>
                </div>
              </form>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer" ng-hide="addUser.$invalid" >

      	<md-button class="btn_add" type="button" id="edit_item"  ng-click="addUserLogin()">Add User</md-button>
		<md-button class="btn-default"  data-dismiss="modal">Close</md-button>

        
      </div>
    </div>

  </div>
</div>

</div>





