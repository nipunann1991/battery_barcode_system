app.controller('invoiceCtrl', ['$scope','ajaxRequest', '$q', 'goTo', 'DTOptionsBuilder', 'DTColumnBuilder', 
	function($scope, ajaxRequest, $q, goTo, DTOptionsBuilder, DTColumnBuilder ) {

    $scope.title = 'Invoice';
    $scope.breadcrumb = 'Home > Invoice'; 


    $scope.getInvoiceList = function(){

      var vm = this;
	    vm.dtOptions = DTOptionsBuilder.newOptions()
        .withOption('ajax', {
         		 
         url: 'index.php/InvoiceController/getInvoiceList',
         type: 'GET'
     })
      
     .withDataProp('data')
 		.withOption('processing', true) 
   		.withOption('serverSide', true) 
   		.withOption('paging', true) 
        .withDisplayLength(10) 
        .withOption('aaSorting',[0,'asc']);
	    vm.dtColumns = [
	        DTColumnBuilder.newColumn('invoice_id').withTitle('Invoice Id')
	        	.renderWith(function(data, type, full, meta) { 
                return  '<a href="#/invoice/view-invoice/'+full.invoice_id+'">'+full.invoice_id+'</a>';
            }), 
	        DTColumnBuilder.newColumn('invoice_no').withTitle('Invoice No')
	         .renderWith(function(data, type, full, meta) { 
                return  '<a href="#/invoice/view-invoice/'+full.invoice_id+'">'+full.invoice_no+'</a>';
            }), 
	        DTColumnBuilder.newColumn('invoice_date').withTitle('Invoice Date'), 
	        DTColumnBuilder.newColumn('no_of_items').withTitle('No of Items'),
	        DTColumnBuilder.newColumn(null).withTitle(' ')
	         .renderWith(function(data, type, full, meta) { 
                return  '<a href="#/invoice/view-invoice/'+full.invoice_id+'"><i class="glyphicon glyphicon-eye-open"></i></a>';
            }), 
	        
	    ];
      
    };




    $scope.getInvoiceList();


    $scope.navigateTo = function(path){ 
    	goTo.page( path );
    };

    $scope.viewInvoice = function(id){ 
    	goTo.page( 'invoice/view-invoice/'+id );
    }
    	

    
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
 	$scope.package_ids = []
 	var package_ids;



    $scope.navigateTo = function(path){ 
    	goTo.page( path );
    };


    $scope.searchItem = function(){ 

    	var data = $.param({ barcode: $scope.item_barcode })

    		ajaxRequest.post('InvoiceController/getGrn', data ).then(function(response) { 

	    		$scope.getGrn =  response.data.data;  
	 			console.log($scope.getGrn);

		    });

    	if ($scope.item_barcode.startsWith("P")) {


    		ajaxRequest.post('InvoiceController/getItemsInPackageBK', data ).then(function(response) { 
    			
    			$scope.getItemsInPackage = response.data.data;  
  
    			for (var i = 0; i < $scope.getItemsInPackage.length; i++) {
    				 
    				

    					if($scope.item_barcodes.indexOf($scope.item_barcode) != -1) {
			            	Notification.error('Package exists in current invoice. Please try again with a new Package.');
							
						}else{

							$scope.item_barcodes.push($scope.getItemsInPackage[i].barcode);
							

						} 
    				

    				if ($scope.package_ids.indexOf($scope.getItemsInPackage[i].stock_id) == -1) {
    					$scope.package_ids.push($scope.getItemsInPackage[i].stock_id)
    				}
    			}

    			Notification.success('Package added to invoice.');
    			$scope.package_item.push({barcode_id: $scope.item_barcode, package: $scope.getItemsInPackage });
    			$scope.item_barcode = '';  
    			console.log($scope.package_ids, $scope.package_item);

    			package_ids = $scope.package_ids;


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
							Notification.success('Item added to invoice.');


						} 
			    		
			    	} 


				}else{
			        Notification.error('Item sold / not found.');

			    }
	    		 

		    });
  		
  		}
  		 
    }

    $scope.deleteItem = function(deleteItem){
    	alert(deleteItem)
    }


 

    $scope.saveInvoice = function(){
 

	    var date = $filter('date')($scope.currDate, "yyyy-MM-dd");

    	var data = $.param({ 
    		invoice_no: $scope.invoice_no, 
    		invoice_date: date, 
    		no_of_items: $scope.item_barcodes.length, 
    		invoiced_by: $scope.role  
    	});
 

		ajaxRequest.post('InvoiceController/addInvoice' ,data ).then(function(response) {
			

			if (response.status == 200) { 

				var getInsertedId = response.data.data.inserted_id; 
				 
				angular.forEach($scope.item_barcodes, function(value, key) { 
					 
					var invoice_data = $.param({ invoice_id: getInsertedId ,  barcode: value, status: 0  })
					
					ajaxRequest.post('InvoiceController/saveInvoice' ,invoice_data ).then(function(response) {
										
						if (response.status == 200) { 
				 			Notification.success('Invoice has been added saved.');

				 			$scope.navigateTo('invoice');

					    }else if(response.status == 500 || response.status == 404){
					       console.log('An error occured while updating package. Please try again.'); 

					    } 

					});
				});

				for (var i = 0; i < package_ids.length; i++) {

					var package_data = $.param({ stock_id: package_ids[i], invoice_id: getInsertedId,  status: 0  });
					
					ajaxRequest.post('InvoiceController/savePackageInfo' ,package_data ).then(function(response) {

					});

				}

			}else if(response.status == 500 || response.status == 404){
		       console.log('An error occured while updating package. Please try again.'); 

		    } 

		});




 		console.log(data)

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


app.controller('viewInvoiceCtrl', ['$scope','ajaxRequest', '$q', 'goTo', 'Notification', '$filter', 'barcodeNoSmall', '$routeParams', 
	function($scope, ajaxRequest, $q, goTo, Notification, $filter, barcodeNoSmall, $routeParams ) {

	$scope.title = 'View Invoice';
    $scope.breadcrumb = 'Home > View Invoice'; 
    $scope.itemList = []; 
 	$scope.package_item = [];
 	$scope.item_package_id = [];
 	$scope.item_package_barcodes = [];


    var data =  $.param({ invoice_id: $routeParams.id });

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
 
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	});
 

	ajaxRequest.post('InvoiceController/getSingleInvoice', data ).then(function(response) {
		
		if (response.status == 200) { 
			
			$scope.getInvoiceDetails =  response.data.data[0]; 
			$scope.invoice_no = $scope.getInvoiceDetails.invoice_no;
			$scope.invoice_date = $scope.getInvoiceDetails.invoice_date;
			$scope.invoiced_by = $scope.getInvoiceDetails.invoiced_by;
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	});

	
	ajaxRequest.post('InvoiceController/getSingleItemsInvoiced', data ).then(function(response) {
		
		if (response.status == 200) { 
			
			$scope.getSingleItemsInvoiced = response.data.data;

			console.log($scope.getSingleItemsInvoiced)
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	})


	ajaxRequest.post('InvoiceController/getPackageInvoiced', data ).then(function(response) {
		
		if (response.status == 200) {  
			
			$scope.getPackageInvoiced = response.data.data;  

			console.log($scope.getPackageInvoiced);

			for (var i =  0; i < $scope.getPackageInvoiced.length; i++) { 

					var package_data =  $.param({ stock_id: $scope.getPackageInvoiced[i].stock_id, invoice_id: $routeParams.id });
					var pkg_barcode = $scope.getPackageInvoiced[i].barcode;

					ajaxRequest.post('InvoiceController/getItemsInPackage', package_data ).then(function(response) {
						$scope.getItemsInPackage  = response.data.data; 
						$scope.package_item.push({ barcode_id: pkg_barcode, package: $scope.getItemsInPackage });
					}); 
			} 
 
	    }else if(response.status == 500 || response.status == 404){
	       console.log('An error occured while updating package. Please try again.'); 
	    } 

	})


	$scope.printDiv = function() {
	   window.print();
	} 

	





}]);