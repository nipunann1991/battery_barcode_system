var currency = 'Rs.'
var app = angular.module('pos_app', ['ngRoute','ngMaterial','ngMessages','datatables', 'ngBootbox','validation', 'validation.rule', 'ui-notification', 'ui.bootstrap.datetimepicker']);

app.config(function(NotificationProvider) {
    NotificationProvider.setOptions({
        delay: 3000,
        startTop: 70,
        startRight: 10,
        verticalSpacing: 20,
        horizontalSpacing: 20,
        positionX: 'right',
        positionY: 'top'
    });
});





app.controller('logCtrl', ['$scope', 'ajaxRequest', '$routeParams' , function($scope, ajaxRequest, $routeParams) {

  ajaxRequest.post('SupplierController/getSessionData').then(function(response) {

      var getSessionData = response.data.user;


      url = window.location.href;
      var activeItem = url.split('/#/')[1]
 
      var activeLink = activeItem.split('/')[0];

      console.log(activeLink)

      if (activeLink == '') {
        $scope.activeMenu = 'Dashboard';
      }else{
        $scope.activeMenu = activeLink.charAt(0).toUpperCase() + activeLink.slice(1);
      }
      

      if (typeof getSessionData != 'undefined') {

        sessionStorage.setItem('loginStatus', JSON.stringify(getSessionData));

        var loginStatus =  JSON.parse(sessionStorage.getItem('loginStatus'))
        $scope.role_access = true;

         if (loginStatus != null) {
              $scope.loginStatus = 'true';
              $scope.name = loginStatus.username;
              $scope.role = loginStatus.role;
              $scope.role_id = loginStatus.role_id;

              if ($scope.role_id == 1) {
                $scope.role_access = false;
             
              } 

         }

      }
      

  });
 
 
  $scope.classNav = "open";
  $scope.classContent = "";


  $scope.toggleNav = function(){
    
    if ($scope.classNav == "open"){
      $scope.classNav = "closed";
      $scope.classContent = "open";
    }else{
      $scope.classNav = "open";
      $scope.classContent = "";
    }
      

  }


   $scope.timeCtrl = function($interval) {
    var timeController = this;
    
    timeController.clock = { time: "", interval: 1000 };
    
     $interval(function () { 
     timeController.clock.time = Date.now();}, 
     timeController.clock.interval);
  };


  $scope.logout = function($interval) {

    ajaxRequest.post('SupplierController/clearSessionData').then(function(response) {

      if (response.data.status == 200) {
        sessionStorage.clear();
        location.reload();
      }
 
  

    });

  };
 
  
  $scope.setActive = function(menuItem) {
      $scope.activeMenu = menuItem;
  }
 
    
}]);


 



app.controller('loginFormCtrl', ['$scope','ajaxRequest', '$q', function($scope, ajaxRequest, $q ) {

  $scope.error = '';
  
  $scope.login = function(){

    if (($scope.email == '' || $scope.password == '') || ( typeof $scope.email == 'undefined' || typeof $scope.password == 'undefined') ) {
      $scope.error = "Login error. Username or Password can't be empty feilds.";

    }else{

  
      $scope.data = $.param({ 
          username: $scope.email, 
          password: $scope.password,  
      }); 

      ajaxRequest.post('SupplierController/getLoginCredentials', $scope.data).then(function(response) {
          $scope.getLogin = response.data.data;   
          console.log( $scope.getLogin );
          
          if ( $scope.getLogin.length != 0 ) {  
            
            var loginStatus = { status: true, username: $scope.getLogin[0].username, role: $scope.getLogin[0].role_name, role_id: $scope.getLogin[0].role_id }
            sessionStorage.setItem('loginStatus', JSON.stringify(loginStatus));
            $scope.loginStatus = true;
            
           location.reload();

          }else{
            $scope.error = "Login error. Please insert your username and password correctly";
          }

      });

    } 

  }

    
}]);


 



/*
*  Navigate to location 
*/

app.factory('goTo', ['$location', function($location) {

    return {
        page: function(path) {
           $location.path( path );
        }
    };
}]);



app.factory('myService', ['$http','$q', function($http,$q){
  
  return {
      get : function(){

    var deferred = $q.defer();
    $http({
        method : "GET",
        url : "http://l-lin.github.io/angular-datatables/archives/data.json", 
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

    }).then(function success(response) { 
        deferred.resolve(response); 

    }, function error(response) {
        deferred.resolve(response); 
         console.log('error')
    });
 
    $q.when(deferred.promise); 

  },

  };

 
 
}]);


/*
*  Generate Barcode 
*/

app.factory('barcodeNo',  function() {

    return {
        generateBarcode: function(barcode) {
           
           JsBarcode("#code128", barcode , {  
              width:2,
              height:30,
              fontSize: 14 
            });

        }
    };
});


app.factory('barcodeNoSmall',  function() {

    return {
        generateBarcode: function(barcode) {
           
           JsBarcode("html .code128sm", barcode , {  
              width:1.5,
              height:20,
              fontSize: 12 
            });

        }
    };
});


 
/*
* Bootbox 
*/

 

app.service('messageBox', ['$ngBootbox','$q', function($ngBootbox, $q) {
  

  this.delete = function(options){

    var deferred = $q.defer();
    var posts = undefined;

    $ngBootbox.confirm({

          title: options.title,
          message: options.message, 
          className: 'short_modal',
          buttons: {
             confirm: {
                label: 'Yes',
                className: 'btn_add'
            },
            cancel: {
                label: 'No',
                className: 'btn-default'
            }
          }
           
        })
        .then(function() {
            console.log('Confirmed!');
            posts = 1
            deferred.resolve(posts);
        }, function() {
            console.log('Confirm dismissed!');
            posts = 0
            deferred.resolve(posts);
        });

        posts = deferred.promise; 

     return $q.when(posts);

  };



    
}]);



/*
*  Ajax call 
*/

app.service('ajaxRequest', ['$http','$q', function($http,$q){
  

  this.post = function(url, data){

    var deferred = $q.defer();
    $http({
        method : "POST",
        url : "index.php/"+url,
        data: data,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

    }).then(function success(response) { 
        deferred.resolve(response); 

    }, function error(response) {
        deferred.resolve(response); 
         console.log('error')
    });
 
    return $q.when(deferred.promise); 


  };



}]);



app.directive('fileModel', ['$parse', function ($parse) {
    return {
    restrict: 'A',
    link: function(scope, element, attrs) {
        var model = $parse(attrs.fileModel);
        var modelSetter = model.assign;

        element.bind('change', function(){
            scope.$apply(function(){
                modelSetter(scope, element[0].files[0]);
            });
        });
    }
   };
}]);



// We can write our own fileUpload service to reuse it in the controller
app.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl, name, item_id){
         var fd = new FormData();
         fd.append('file', file);
         fd.append('name', name);
         fd.append('item_id', item_id);
         
         $http.post(uploadUrl, fd, {
             transformRequest: angular.identity,
             headers: {'Content-Type': undefined,'Process-Data': false}
         })
         .then(function success(response) { 
            console.log(response)

        }, function error(response) { 
             console.log('error')
        });
     }
 }]);




app.service('getLastCat', [ '$q', 'ajaxRequest',  function($q, ajaxRequest){

  this.id = function(){ 

    var deferred = $q.defer();
    var posts = undefined;

    ajaxRequest.post('CategoryController/getLastIndex').then(function(response) { 

          if (response.data.data.length == 0) {
            deferred.resolve(0); 
          }else{  
            deferred.resolve(response.data.data[0].id); 
          }

           
    });

    posts = deferred.promise;   

    return $q.when(posts);

       
  };

}]);


 

 
/*
*/