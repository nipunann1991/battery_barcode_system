
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
