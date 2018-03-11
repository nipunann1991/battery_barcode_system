
app.controller('MissingCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder',
  	function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder) {

	    $scope.title = 'Missing Items List';
	    $scope.breadcrumb = 'Home > Missing Items List';
	    $scope.animated_class = 'animated fadeIn';


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.viewItem = function ( path ) {
	        goTo.page('items/search-battery/'+path);
	    };


	    $scope.editMissing = function ( id ) {
	        goTo.page('missing-items/edit-missing-items/'+id);
	    };

	    $scope.getMissingList = function (){ 

	        var vm = this;
	        vm.dtOptions = DTOptionsBuilder.newOptions()
	          .withOption('ajax', { 
	           url: 'index.php/MissingItemsController/getMissingList',
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

	            DTColumnBuilder.newColumn('id').withTitle('# Id'), 

	            DTColumnBuilder.newColumn('barcode').withTitle('Barcode')
	              .renderWith(function(data, type, full, meta) { 
	                  return  '<a href="javascript:void(0)" ng-click="viewItem('+full.barcode+')">'+full.barcode+'</a>';
	              }),  

	            DTColumnBuilder.newColumn('invoice_no').withTitle('Invoice No'),
	             DTColumnBuilder.newColumn('invoice_date').withTitle('Date'),
	            DTColumnBuilder.newColumn('status').withTitle('Status')
	            
	             .renderWith(function(data, type, full, meta) { 

	               
	  				var label_ = '';

	                 
	                 label_ = '<span class="label label-danger">Lost</span>'
	                 

	                return label_;
	            }), 
	            
	            
	        ];


	        function createdRow(row, data, dataIndex) { 
	            $compile(angular.element(row).contents())($scope);
	        }
	 
	    }

	    $scope.getMissingList();

   }

]);



app.controller('addMissingCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder',
  	function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder) {

	    $scope.title = 'Add Missing Item';
	    $scope.breadcrumb = 'Home > Add Missing Item';
	    $scope.animated_class = 'animated fadeIn';

	  

	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.validateBarcode = function(){ 
	    	 
	    	var data = $.param({ barcode: $scope.barcode });

        	ajaxRequest.post('MissingItemsController/searchItem', data ).then(function(response) {


	        	if (response.status == 200) {
	        		console.log(response)

	        		if (response.data.data.length == 0) { 
	        			$scope.barcode = '';
	        			Notification.error('Item not found. Please try again.'); 
	        		}else{
	        			Notification.success('Package has been added successfully.');
	        		}
	                
	                


                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while adding package. Please try again.'); 
                 } 

	        });
	    }
 

	    $scope.addMissing = function(){

	    	var data = $.param({  

	            barcode: $scope.barcode, 
	            date: moment().format('DD-MM-YYYY'),
	            remarks: $scope.remarks, 
	            status: 0,  

	        });


	        var data_update = $.param({  
	    		
	            barcode: $scope.barcode, 
	            status: -1,

	        });

        	ajaxRequest.post('MissingItemsController/addMissingItems', data ).then(function(response) {


	        	if (response.status == 200) {

	        		ajaxRequest.post('MissingItemsController/updateItem', data_update ).then(function(response) { 

			        	if (response.status == 200) { 

			                Notification.success('Missing Item has been added successfully.');
			                $scope.navigateTo('missing-items');


		                 }else if(response.status == 500 || response.status == 404){
		                    Notification.error('An error occured while adding item. Please try again.'); 
		                 } 

			        });
 

                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while adding item. Please try again.'); 
                 } 

	        });


	    }

 
 

   }

]);



app.controller('editMissingCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder', '$routeParams',
  	function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder, $routeParams) {

	    $scope.title = 'Edit Missing Item';
	    $scope.breadcrumb = 'Home > Edit Missing Item';
	    $scope.animated_class = 'animated fadeIn';


	    
	    var data =  $.param({ id: $routeParams.id })

	    ajaxRequest.post('MissingItemsController/searchMissigItemData', data ).then(function(response) { 

        	if (response.status == 200) { 

        		var results = response.data.data[0] 

 				$scope.barcode  = results.barcode;
 				$scope.remarks  = results.remarks;

 				if (results.status==1) {
 					$scope.found_item = true
 				}else{
 					$scope.found_item = false;
 				}

             }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding item. Please try again.'); 
             } 

        });
	  

	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };




	    $scope.editMissing = function(){

	    	var found_item = 0, item_status = 0;

	    	if ($scope.found_item) {
	    		found_item = 1;
	    		item_status = 1;
	    	}else{
	    		found_item = 0;
	    		item_status = -1;
	    	}

	    	var data = $.param({  

	            id: $routeParams.id,  
	            remarks: $scope.remarks,  
	            status: found_item, 

	        }); 
	      

        	ajaxRequest.post('MissingItemsController/updateMissingItem', data ).then(function(response) {

	        	if (response.status == 200) { 



	        			var data_update = $.param({  
	    		
				            barcode: $scope.barcode, 
				            status: item_status,

				        });

	        			ajaxRequest.post('MissingItemsController/updateItem', data_update ).then(function(response) { 

				        	if (response.status == 200) { 

				                Notification.success('Missing Item has been updated successfully.');
				                $scope.navigateTo('missing-items');


			                 }else if(response.status == 500 || response.status == 404){
			                    Notification.error('An error occured while adding item. Please try again.'); 
			                 } 

				        });

	        	 


	        		
 

                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while adding item. Please try again.'); 
                 } 

	        });


	    }

 
 

   }

]);

