<div class="container" ng-controller="loginFormCtrl">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Log In</h1>
            <div class="account-wall">
                <img class="profile-img" src="assets/images/default-avatar.png"
                    alt="">
                <form class="form-signin form-horizontal" name="loginItemForm">
                
                <div class="form-group">
                    
                    <div class="col-sm-12" ng-class="{ 'has-error' : !loginItemForm.email.$pristine && loginItemForm.email.$touched && loginItemForm.email.$invalid }">
 
                      <input type="text" class="form-control" placeholder="Email" name="email" ng-model="email" required> 
                      <label class="error" >This field is required.</label>  
                    </div>
                </div>
                <div class="form-group">
                    
                    <div class="col-sm-12" ng-class="{ 'has-error' : !loginItemForm.password.$pristine && loginItemForm.password.$touched && loginItemForm.password.$invalid }">
                        <input type="password" class="form-control" placeholder="Password" name="password" ng-model="password" > 
                      <label class="error" >This field is required.</label>  
                    </div>
                </div>
                
               <md-button class="" type="button" id="login" ng-click="login()">Login</md-button>
               

                </form>
            </div> 
        </div>
    </div>
</div>