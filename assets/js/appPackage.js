
app.controller('PackageCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder',
  function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder) {

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

	    $scope.deletePackage = function(package_id){

	    	var options = {
	            title:'Delete Package',
	            message:"Are you sure you want to remove this package?", 
	            id: package_id,
	            className: 'short_modal',
	        }

	        messageBox.delete(options).then(function(post) {

		        if (post == 1) {
		            var deleteItemID = package_id;

		            var data = $.param({ package_id: package_id })
		            var deletePackageData = $.param({ pkg_id : package_id })

		            ajaxRequest.post('PackageController/getItemsInPackage', data).then(function(response) { 

				    	if (response.status == 200) {

				    		$scope.getItemsInPackage = response.data.data;
				    		

				    		for (var i = 0; i < $scope.getItemsInPackage.length; i++) {
				    			 
				    			var removeStock = $.param({   
				    				stock_id: $scope.getItemsInPackage[i].stock_id,
						            package_id: 0,    
						        });

						    	ajaxRequest.post('PackageController/updateSingleItem', removeStock).then(function(response) { 

							    	if (response.status == 200) { 

							    		
							    	}else if(response.status == 500 || response.status == 404){
						                console.log('An error occured while updateSingleItem. Please try again.'); 
						            } 


							    });
				    		}


				    	}else if(response.status == 500 || response.status == 404){
			                console.log('An error occured while getting item. Please try again.'); 
			            } 

				    });

				    ajaxRequest.post('PackageController/deletePackage', deletePackageData).then(function(response) { 

				    	if (response.status == 200) { 
				    		Notification.success('Package has been deleted successfully.');
				    		  
				    	}else if(response.status == 500 || response.status == 404){
			                Notification.error('Package delete faild.');
			            } 

				    });

		            
		        }


	        });
	    }


 


	    $scope.getItems = function(){

	    	var vm = this;
	        vm.dtOptions = DTOptionsBuilder.newOptions()
	          .withOption('ajax', { 
	           url: 'index.php/PackageController/getItems',
	           type: 'GET',

	       })
	        
	      .withDataProp('data')
	      .withOption('processing', true) 
	      .withOption('serverSide', true) 
	      .withOption('paging', true) 
	      .withDisplayLength(10) 
	      .withOption('createdRow', createdRow)
	      .withOption('aaSorting',[0,'asc']);
	        vm.dtColumns = [
	            DTColumnBuilder.newColumn('pkg_id').withTitle('#Package Id')
	              .renderWith(function(data, type, full, meta) { 
	                  return  '<a href="javascript:void(0)" ng-click="viewPackageStock('+full.pkg_id+')">#'+full.pkg_id+'</a>';
	              }), 
	            DTColumnBuilder.newColumn('pkg_barcode').withTitle('Package Barcode')
	              .renderWith(function(data, type, full, meta) { 
	                  return  full.pkg_barcode;
	              }), 
	            DTColumnBuilder.newColumn('note').withTitle('Note'),  
	            DTColumnBuilder.newColumn(null).withTitle(' ')
	             .renderWith(function(data, type, full, meta) { 

	              var class_ = '', action_btns = '', hide_ = '';
	 

	                  if (!$scope.role_access) {
	                    hide_ = 'hide';
	                  }

	                  return  `<div class="w100">
	                          <a href="" id="view`+full.pkg_id+`" ng-click="viewPackageStock(`+full.pkg_id+`)"  class="view" title="View Items" >
	                            <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>
	                          </a>
	                          <a href="" id="edit`+full.pkg_id+`"  class="edit `+class_+`" title="Edit Items" ng-click="editPackage(`+full.pkg_id+`)">
	                            <i class="icon-pencil-edit-button" aria-hidden="true"></i>
	                          </a>
	                          <a href="" id="delete`+full.pkg_id+`" ng-click="deletePackage(`+full.pkg_id+`)" class="delete  `+hide_+`" title="Delete Items" >
	                            <i class="icon-rubbish-bin" aria-hidden="true"></i>
	                          </a></div>
	                          `;
	              }), 
	            
	        ];


	        function createdRow(row, data, dataIndex) { 
	            $compile(angular.element(row).contents())($scope);
	        }

	    }

	    $scope.getItems();


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
  
           	 			if(Item_barcodes.indexOf($scope.item_barcode) != -1) {
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
	            status: 1,
	            note: $scope.note,   

	        });


        	if (item.length >= 2) {
		        
		        ajaxRequest.post('PackageController/addItem', data_pkg ).then(function(response) {

		        	for (var i = 0; i < item.length; i++) {
		        		 

		        		var data = $.param({  
				            package_id: $scope.pkg_id, 
				            stock_id: item[i].stock_id,  
				 			status: 1,
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

			$scope.labelText = 'In Stock';
			$scope.label = 'label-success';

			// console.log($scope.getItemList[0].invoice_id)

			 if ($scope.getItemList[0].invoice_id == '0') {
			 	$scope.label = 'label-success';
			 	$scope.labelText = 'In Stock';
			 	$scope.status = 1;
			 }else{
			 	$scope.label = 'label-danger';
			 	$scope.labelText = 'Sold';
			 	$scope.status = 0;
			 }
 
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


	    $scope.editItem = function () {

	    	var data_pkg = $.param({  

	            pkg_id: $routeParams.id,  
	            note: $scope.note,   

	        });

	    	ajaxRequest.post('PackageController/updateItem', data_pkg).then(function(response) { 

		    	if (response.status == 200) {
		    		Notification.success('Item has been updated successfully.');
		    		history.back();
		    	}

		    });

			 
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