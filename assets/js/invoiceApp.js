app.controller('invoiceCtrl', ['$scope','ajaxRequest', '$q', 'goTo', function($scope, ajaxRequest, $q, goTo ) {

    $scope.title = 'Invoice';
    $scope.breadcrumb = 'Home > Invoice'; 


    $scope.getItems = function(){

      ajaxRequest.post('PosController/getItems').then(function(response) {
          $scope.getItems = response.data.data;  
           

      });
      
    };

    $scope.getItems();


    $scope.navigateTo = function(path){ 
    	goTo.page( path );
    };

    
}]);



app.controller('newinvoiceCtrl', ['$scope','ajaxRequest', '$q', 'goTo', 'Notification', '$filter', function($scope, ajaxRequest, $q, goTo, Notification, $filter ) {

    $scope.title = 'New Invoice';
    $scope.breadcrumb = 'Home > New Invoice'; 

    $scope.num1 = Math.floor(Math.random() * 10000) + 100;
    $scope.currDate = new Date();
    $scope.currTime = new Date();
    
    $scope.date = $filter('date')($scope.currDate, "dd-MM-yyyy");
    $scope.time = $filter('date')($scope.currTime, "HH:mm:ss");

    $scope.invoice_no = 'INV'+$scope.date.replace(/-/g, '')+""+$scope.time.replace(/:/g, '');
 

    $scope.navigateTo = function(path){ 
    	goTo.page( path );
    };

    

    ajaxRequest.post('InvoiceController/getCompanyDetails' ).then(function(response) {
		
		if (response.status == 200) { 
			
			$scope.getCompanyDetails =  response.data.data[0]; 
			$scope.company_name = $scope.getCompanyDetails.name;
			$scope.company_address = $scope.getCompanyDetails.address;
			$scope.email = $scope.getCompanyDetails.email;
			$scope.tel = $scope.getCompanyDetails.tel;

			console.log($scope.getCompanyDetails)
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	});

    
}]);