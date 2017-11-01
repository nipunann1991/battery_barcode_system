
app.controller('PackageCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

	    $scope.title = 'View Packages';
	    $scope.breadcrumb = 'Package > View Packages';
	    $scope.animated_class = 'animated fadeIn';


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    ajaxRequest.post('PackageController/getItems').then(function(response) { 

	    	if (response.status == 200) {
	    		$scope.getItem = response.data.data;
	    		console.log($scope.getItem)


	    	}else if(response.status == 500 || response.status == 404){
                console.log('An error occured while getting item. Please try again.'); 
            } 

	    });


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
	    var Item_barcodes = []; 

	    ajaxRequest.post('PackageController/getAutoIncrementID').then(function(response) { 

	    	if (response.status == 200) {
	    		$scope.pkg_id = response.data.data[0].AUTO_INCREMENT;
	    	}
	    });


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.searchItem = function () { 


	    	var data = $.param({ barcode: $scope.item_barcode })

	    	ajaxRequest.post('PackageController/getSingleItem', data ).then(function(response) {
                 
                if (response.status == 200) {

                	$scope.response = response.data.data[0];
                	

                	console.log(Item_barcodes);
                    
                    if (typeof $scope.response != "undefined") {
  
           	 			if(Item_barcodes.indexOf($scope.item_barcode) !== -1) {
	                    	Notification.error('Item exists in current list. Please try again with a new barcode.');
							
						}else{

							Item.push($scope.response);  
	                    	Item_barcodes.push($scope.response.barcode);
	                    	$scope.getItem = Item; 
	                    	Notification.success('Item has been added successfully.');
						}
                    	 

                    }else{
                    	Notification.error('Item not found. Please try again.');
                    }
	    			 

 					$scope.item_barcode =''

                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while deleting item. Please try again.'); 
                 } 
            });


        };

        $scope.addItem = function () {

        	var data_pkg = $.param({ 
	           
	            pkg_barcode: $scope.barcode, 
	            pkg_items: Item_barcodes.toString(),  
	 
	        });


        	if (Item.length >= 2) {
		        
		        ajaxRequest.post('PackageController/addItem', data_pkg ).then(function(response) {

		        	for (var i = 0; i < Item.length; i++) {
		        		 

		        		var data = $.param({  
				            package_id: $scope.pkg_id, 
				            stock_id: Item[i].stock_id,  
				 
				        });


		        		ajaxRequest.post('PackageController/updateSingleItem', data ).then(function(response) {
		        			
		        			if (response.status == 200) { 
				                console.log('Package has been updated successfully.');  

			                }else if(response.status == 500 || response.status == 404){
			                   console.log('An error occured while updating package. Please try again.'); 
			                } 
		          
		        		});

		        	}

		        	if (response.status == 200) {

		                Notification.success('Package has been added successfully.');
		                $scope.navigateTo('package');


	                 }else if(response.status == 500 || response.status == 404){
	                    Notification.error('An error occured while adding package. Please try again.'); 
	                 } 

		        });

		    }else{ 
		    	Notification.error('Package must contain atleast 2 items.'); 
		    }
	         
        };


   }

]);

