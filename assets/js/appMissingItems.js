
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
	        goTo.page('returns/edit-return/'+id);
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
	            DTColumnBuilder.newColumn('remarks').withTitle('remarks'),
	            DTColumnBuilder.newColumn(null).withTitle(' ')
	             .renderWith(function(data, type, full, meta) { 

	              var class_ = '', action_btns = '', hide_ = '';
	 

	                  if (!$scope.role_access) {
	                    hide_ = 'hide';
	                  }

	                  return  `<div class="w100"> 
	                          <a href="" id="edit`+full.item_id+`"  class="edit `+class_+`" title="Edit Items" ng-click="editMissing(`+full.id+`)">
	                            <i class="icon-pencil-edit-button" aria-hidden="true"></i>
	                          </a>
	                          
	                          `;
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
			                $scope.navigateTo('returns');


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
