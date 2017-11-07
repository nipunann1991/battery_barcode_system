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



app.controller('newinvoiceCtrl', ['$scope','ajaxRequest', '$q', 'goTo', 'Notification', '$filter', 'barcodeNoSmall', 
	function($scope, ajaxRequest, $q, goTo, Notification, $filter, barcodeNoSmall ) {


    $scope.title = 'New Invoice';
    $scope.breadcrumb = 'Home > New Invoice'; 

    $scope.num1 = Math.floor(Math.random() * 10000) + 100;
    $scope.currDate = new Date();
    $scope.currTime = new Date();
    
    $scope.date = $filter('date')($scope.currDate, "dd-MM-yyyy");
    $scope.time = $filter('date')($scope.currTime, "HH:mm:ss");

    $scope.invoice_no = 'INV'+$scope.date.replace(/-/g, '')+""+$scope.time.replace(/:/g, '');
 	$scope.itemList = [];
 	$scope.item_barcodes = [];
 	$scope.item_package_barcodes = [];
 	$scope.package_item = []


 


    $scope.navigateTo = function(path){ 
    	goTo.page( path );
    };


    $scope.searchItem = function(){ 

    	var data = $.param({ barcode: $scope.item_barcode })

    	if ($scope.item_barcode.startsWith("P")) {

    		ajaxRequest.post('InvoiceController/getItemsInPackage', data ).then(function(response) { 
    			$scope.getItemsInPackage = response.data.data;  

    			//$scope.itemList.push($scope.getItemsInPackage[0])

    			for (var i = 0; i < $scope.getItemsInPackage.length; i++) {
    				 
    				$scope.item_barcodes.push($scope.getItemsInPackage[i].barcode)
    			}

    			$scope.package_item.push({barcode_id: $scope.item_barcode, package: $scope.getItemsInPackage });
    			$scope.item_barcode = '';  
    			console.log($scope.item_barcodes);
    		});

    	}else{

    	
    	
	    	ajaxRequest.post('InvoiceController/getSingleItem', data ).then(function(response) { 


	    		$scope.getSingleItem =  response.data.data;  
	 
	    		if ( $scope.getSingleItem.length != 0) {
				
	    			if (response.status == 200) {
			    		  
			    		if($scope.item_barcodes.indexOf($scope.item_barcode) != -1) {
			            	Notification.error('Item exists in current invoice. Please try again with a new barcode.');
							
						}else{

							$scope.itemList.push($scope.getSingleItem[0]);
			    			$scope.item_barcodes.push($scope.item_barcode);
			    			$scope.item_barcode = ''; 
			    			console.log($scope.item_barcodes);

						} 
			    		
			    	} 


				}else{
			        Notification.error('Item not found.');

			    }
	    		 

		    });
  		
  		}
  		//getItemsInPackage
    }

    $scope.deleteItem = function(deleteItem){
    	alert(deleteItem)
    }

    	
    

    ajaxRequest.post('InvoiceController/getCompanyDetails' ).then(function(response) {
		
		if (response.status == 200) { 
			
			$scope.getCompanyDetails =  response.data.data[0]; 
			$scope.company_name = $scope.getCompanyDetails.name;
			$scope.company_address = $scope.getCompanyDetails.address;
			$scope.email = $scope.getCompanyDetails.email;
			$scope.tel = $scope.getCompanyDetails.tel;

			
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	});

    
}]);