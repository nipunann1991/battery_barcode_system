
app.controller('PackageCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

	    $scope.title = 'View Packages';
	    $scope.breadcrumb = 'Package > View Packages';
	    $scope.animated_class = 'animated fadeIn';


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


   }

]);



app.controller('addPackageCtrl', ['$scope', '$filter','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'barcodeNo',
  function($scope, $filter, $location, ajaxRequest, goTo, messageBox, Notification, barcodeNo) {

	    $scope.title = 'Add Package';
	    $scope.breadcrumb = 'Package > Add Package';
	    $scope.animated_class = 'animated fadeIn';
	   
	    $scope.num1 = Math.floor(Math.random() * 10000) + 100;
	    $scope.currDate = new Date();
	    $scope.currTime = new Date();
	    
	    $scope.date = $filter('date')($scope.currDate, "dd-MM-yyyy");
	    $scope.time = $filter('date')($scope.currTime, "HH:mm:ss");

	    $scope.barcode = 'P'+$scope.date.replace(/-/g, '')+""+$scope.num1+""+$scope.time.replace(/:/g, '');

	    barcodeNo.generateBarcode($scope.barcode);
	    var Item = [];

	    //$scope.getItem = [{id: 1, item_name: 'SW101', category: 'car battery', }, {id: 2, item_name: 'SW102', category: 'car battery', }]
	    


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.searchItem = function () { 


	    	var data = $.param({ barcode: $scope.item_barcode })

	    	ajaxRequest.post('PackageController/getSingleItem', data ).then(function(response) {
                 
                if (response.status == 200) {

                	$scope.response = response.data.data[0];
                    
                    if (typeof $scope.response != "undefined") {

                    	var data_added = $.param({ barcode: $scope.item_barcode })

                    	ajaxRequest.post('PackageController/getSingleItem', data_added ).then(function(response) {
                 
              
           	 			});
                    	
                    	Item.push($scope.response); 
                    	console.log($scope.response);
                    	
                    	$scope.getItem = Item; 
                    	Notification.success('Item has been added successfully.');

                    }else{
                    	Notification.error('Item not found. Please try again.');
                    }
	    			 

 					$scope.item_barcode =''

                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while deleting item. Please try again.'); 
                 } 
            });


        };


   }

]);

