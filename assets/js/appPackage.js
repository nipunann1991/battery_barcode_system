
app.controller('PackageCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

	    $scope.title = 'View Packages';
	    $scope.breadcrumb = 'Package > View Packages';
	    $scope.animated_class = 'animated fadeIn';


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };

	    $scope.viewPackageStock = function ( id ) {
	       goTo.page('package/view-package/'+id);
		};

		$scope.editPackage = function(item_id){
	      goTo.page('/package/edit-package/'+item_id);
	    }


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

	    $scope.title = 'Add New Package';
	    $scope.breadcrumb = 'Package > Add Package';
	    $scope.animated_class = 'animated fadeIn';
	   
	    $scope.num1 = Math.floor(Math.random() * 10000) + 100;
	    $scope.currDate = new Date();
	    $scope.currTime = new Date();
	    
	    $scope.date = $filter('date')($scope.currDate, "dd-MM-yyyy");
	    $scope.time = $filter('date')($scope.currTime, "HH:mm:ss");

	    $scope.barcode = 'P'+$scope.date.replace(/-/g, '')+""+$scope.num1+""+$scope.time.replace(/:/g, '');

	    barcodeNo.generateBarcode($scope.barcode);

	    var item = [];
	    var Item_barcodes = []; 

	    ajaxRequest.post('PackageController/getAutoIncrementID').then(function(response) { 

	    	if (response.status == 200) {
	    		$scope.pkg_id = response.data.data[0].AUTO_INCREMENT;
	    	}
	    });


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };

	    $scope.deleteItem = function (barcode, id ) {
	        var options = {
	            title:'Delete Item',
	            message:"Are you sure you want to remove this item from the package?", 
	            id: id,
	            className: 'short_modal',
	        }

	        messageBox.delete(options).then(function(post) {

		        if (post == 1) {
		            var deleteItemID =  $.param({ item_id: id })
  
		            var index = Item_barcodes.indexOf(barcode);
		            Item_barcodes.splice(index, 1);
		            item.splice(id, 1)
		            $scope.getItem = item;  
		        }


	        });
	    };


	    $scope.searchItem = function () { 


	    	var data = $.param({ barcode: $scope.item_barcode })

	    	ajaxRequest.post('PackageController/getSingleItem', data ).then(function(response) {
                 
                if (response.status == 200) {

                	$scope.response = response.data.data[0];
                	

                	//console.log(Item_barcodes);
                    
                    if (typeof $scope.response != "undefined") {
  
           	 			if(Item_barcodes.indexOf($scope.item_barcode) !== -1) {
	                    	Notification.error('Item exists in current list. Please try again with a new barcode.');
							
						}else{

							item.push($scope.response);  
	                    	Item_barcodes.push($scope.response.barcode);
	                    	$scope.getItem = item; 
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
	            note: $scope.note,   

	        });


        	if (item.length >= 2) {
		        
		        ajaxRequest.post('PackageController/addItem', data_pkg ).then(function(response) {

		        	for (var i = 0; i < item.length; i++) {
		        		 

		        		var data = $.param({  
				            package_id: $scope.pkg_id, 
				            stock_id: item[i].stock_id,  
				 
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





app.controller('viewPackageCtrl', ['$scope', '$filter','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'barcodeNo', '$routeParams',
  function($scope, $filter, $location, ajaxRequest, goTo, messageBox, Notification, barcodeNo, $routeParams) {

   	$scope.title = 'View Package & Item List';
    $scope.breadcrumb = 'Package > View Package';
    $scope.animated_class = 'animated fadeIn';


    
    $scope.navigateTo = function ( path ) {
	    goTo.page( path );
	};


	$scope.viewItemStock = function(item_id){
      goTo.page('/items/view-item-stock/'+item_id);
    }
 	

 	$scope.editPackage = function(){ 
      	goTo.page('/package/edit-package/'+$routeParams.id);
    }

  
   	var data =  $.param({ package_id: $routeParams.id })

   	ajaxRequest.post('PackageController/getSinglePackage', data ).then(function(response) {
		
		if (response.status == 200) { 
			
			$scope.getPackage =  response.data.data[0];

			$scope.pkg_id = $scope.getPackage.pkg_id;
			$scope.pkg_barcode = $scope.getPackage.pkg_barcode;
			$scope.note = $scope.getPackage.note; 

			if ($scope.getPackage.note == '') {
				$scope.note = '-'
			}

			barcodeNo.generateBarcode($scope.getPackage.pkg_barcode);
			
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	});


	ajaxRequest.post('PackageController/getItemsInPackage', data ).then(function(response) {
		
		if (response.status == 200) { 
			
			$scope.getItemList =  response.data.data; 
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	});
  

}]);



app.controller('editPackageCtrl', ['$scope', '$filter','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'barcodeNo', '$routeParams',
  function($scope, $filter, $location, ajaxRequest, goTo, messageBox, Notification, barcodeNo, $routeParams) {

	    $scope.title = 'Edit Package';
	    $scope.breadcrumb = 'Package > Edit Package';
	    $scope.animated_class = 'animated fadeIn';
	    var item = [];
	    var Item_barcodes = []; 


	    var data =  $.param({ package_id: $routeParams.id })

	   	ajaxRequest.post('PackageController/getSinglePackage', data ).then(function(response) {
			
			if (response.status == 200) { 
				
				$scope.getPackage =  response.data.data[0];

				$scope.pkg_id = $scope.getPackage.pkg_id;
				$scope.barcode = $scope.getPackage.pkg_barcode;
				$scope.note = $scope.getPackage.note;  
				 
				barcodeNo.generateBarcode($scope.barcode);
				
	 
		    }else if(response.status == 500 || response.status == 404){
		       console.log('An error occured while updating package. Please try again.'); 
		    } 

		});
	   

	   ajaxRequest.post('PackageController/getItemsInPackage', data ).then(function(response) {
			
			if (response.status == 200) { 
				
				$scope.getItemList =  response.data.data; 

				console.log($scope.getItemList[0])

				for (var i = 0; i < $scope.getItemList.length; i++) {
					item.push($scope.getItemList[i]);  
	   				Item_barcodes.push($scope.getItemList[i].barcode);
				}
 
	 
		    }else if(response.status == 500 || response.status == 404){
		       console.log('An error occured while updating package. Please try again.'); 
		    } 

		});
	    

	   

	    ajaxRequest.post('PackageController/getAutoIncrementID').then(function(response) { 

	    	if (response.status == 200) {
	    		$scope.pkg_id = response.data.data[0].AUTO_INCREMENT;
	    	}
	    });


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.close = function () {
	        history.back();
	    }; 


	    $scope.addItem = function () {
			Notification.success('Item has been updated successfully.'); 
	    }; 
 

	    $scope.deleteItem = function ( stock_id, barcode, id ) {

	        var options = {
	            title:'Delete Item',
	            message:"Are you sure you want to delete this item?", 
	            id: stock_id,
	            className: 'short_modal',
	        }

	        //alert(stock_id)

	        var index = Item_barcodes.indexOf(barcode);
            Item_barcodes.splice(index, 1);
            item.splice(id, 1) 


	        var data = $.param({  
	            package_id: 0, 
	            stock_id: stock_id,   
	        });


    		ajaxRequest.post('PackageController/updateSingleItem', data ).then(function(response) {
    			
    			if (response.status == 200) { 

	                  $scope.getItemList = item; 

                }else if(response.status == 500 || response.status == 404){
                   console.log('An error occured while updating package. Please try again.'); 
                } 
      
    		});
	    };


	    $scope.searchItem = function () { 


	    	var data = $.param({ barcode: $scope.item_barcode })

	    	ajaxRequest.post('PackageController/getSingleItem', data ).then(function(response) {
                 
                if (response.status == 200) {

                	$scope.response = response.data.data[0]; 
                    
                    if (typeof $scope.response != "undefined") {
  
           	 			if(Item_barcodes.indexOf($scope.item_barcode) !== -1) {
	                    	Notification.error('Item exists in current list. Please try again with a new barcode.');
							
						}else{

							item.push($scope.response);  
	                    	Item_barcodes.push($scope.response.barcode);
	                    	$scope.getItemList = item; 
 
 
	                    	var data = $.param({  
					            package_id: $routeParams.id, 
					            stock_id: $scope.response.stock_id,  
					 
					        });


			        		ajaxRequest.post('PackageController/updateSingleItem', data ).then(function(response) {
			        			
			        			if (response.status == 200) { 

					                Notification.success('Item has been added successfully.');

				                }else if(response.status == 500 || response.status == 404){
				                   console.log('An error occured while updating package. Please try again.'); 
				                } 
			          
			        		});
	 
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

        

   }

]);