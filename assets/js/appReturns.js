
app.controller('ReturnsCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder',
  	function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder) {

	    $scope.title = 'Item Returns';
	    $scope.breadcrumb = 'Home > Returns';
	    $scope.animated_class = 'animated fadeIn';


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.viewItem = function ( path ) {
	        goTo.page('items/search-battery/'+path);
	    };


	    $scope.editReturn = function ( id ) {
	        goTo.page('returns/edit-return/'+id);
	    };

	    $scope.getReturnList = function (){ 

	        var vm = this;
	        vm.dtOptions = DTOptionsBuilder.newOptions()
	          .withOption('ajax', { 
	           url: 'index.php/ReturnsController/getReturnsList',
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
	            DTColumnBuilder.newColumn('rep_name').withTitle('Rep Name'), 
	             DTColumnBuilder.newColumn('return_date').withTitle('Return Date'),
	            DTColumnBuilder.newColumn('remarks').withTitle('remarks'),
	            DTColumnBuilder.newColumn(null).withTitle(' ')
	             .renderWith(function(data, type, full, meta) { 

	              var class_ = '', action_btns = '', hide_ = '';
	 

	                  if (!$scope.role_access) {
	                    hide_ = 'hide';
	                  }

	                  return  `<div class="w100"> 
	                          <a href="" id="edit`+full.item_id+`"  class="edit `+class_+`" title="Edit Items" ng-click="editReturn(`+full.id+`)">
	                            <i class="icon-pencil-edit-button" aria-hidden="true"></i>
	                          </a>
	                          
	                          `;
	              }), 
	            
	        ];


	        function createdRow(row, data, dataIndex) { 
	            $compile(angular.element(row).contents())($scope);
	        }
	 
	    }

	    $scope.getReturnList();

   }

]);


app.controller('addReturnsCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder',
  	function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder) {

	    $scope.title = 'Add Returns';
	    $scope.breadcrumb = 'Home > Add Returns';
	    $scope.animated_class = 'animated fadeIn'; 


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    };


	    $scope.addReturn = function(){

	    	var data = $.param({ 
	           
	            barcode: $scope.barcode, 
	            rep_name: $scope.rep_name,
	            remarks: $scope.remarks,   

	        });

	        ajaxRequest.post('ReturnsController/addReturns', data ).then(function(response) {
 

		        	if (response.status == 200) {

		                Notification.success('Package has been added successfully.');
		                $scope.navigateTo('returns');


	                 }else if(response.status == 500 || response.status == 404){
	                    Notification.error('An error occured while adding package. Please try again.'); 
	                 } 

		        });


	    }


   }

]);


app.controller('editReturnsCtrl', ['$scope','$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder', '$routeParams',
  	function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder, $routeParams) {

	    $scope.title = 'Edit Returns';
	    $scope.breadcrumb = 'Home > Edit Returns';
	    $scope.animated_class = 'animated fadeIn';


	    $scope.navigateTo = function ( path ) {
	        goTo.page( path );
	    }; 

	    var data =  $.param({ id: $routeParams.id })

	    ajaxRequest.post('ReturnsController/getSingleReturns', data ).then(function(response) {
 
        	if (response.status == 200) {

        		var result = response.data.data[0];

 				console.log(result);
 				$scope.barcode = result.barcode;
 				$scope.rep_name = result.rep_name;
 				$scope.remarks = result.remarks; 
 				$scope.return_date = new Date(result.return_date);


            }else if(response.status == 500 || response.status == 404){
                //Notification.error('An error occured while adding package. Please try again.'); 
            } 

        });

	    $scope.editReturn = function(){

	    	var data = $.param({ 
	           	id: $routeParams.id,
	            barcode: $scope.barcode, 
	            rep_name: $scope.rep_name,
	            remarks: $scope.remarks,   
	            return_date: $scope.return_date,

	        });


	        console.log(data);

	        	ajaxRequest.post('ReturnsController/updateReturns', data ).then(function(response) {
 

		        	if (response.status == 200) {

		                Notification.success('Return has been edited successfully.');
		                $scope.navigateTo('returns');


	                 }else if(response.status == 500 || response.status == 404){
	                    Notification.error('An error occured while editing. Please try again.'); 
	                 } 

		        });


	    }


   }

]);



