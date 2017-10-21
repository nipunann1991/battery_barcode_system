
app.controller('SupplierCtrl', [ '$scope', 'ajaxRequest', '$q', 'goTo', 'messageBox', 'Notification',
	function($scope, ajaxRequest, $q, goTo, messageBox, Notification) {

  $scope.title = 'Supplier';
  $scope.breadcrumb = 'Home > Suppliers'; 
  $scope.animated_class = 'animated fadeIn';


  	

  	$scope.getSuppliersList = function(){
  		ajaxRequest.post('SupplierController/getSuppliers').then(function(response) {
	        $scope.getSuppliers = response.data.data;   
	    });
  	}

  	$scope.getSuppliersList();


  	$scope.navigateTo = function ( path ) {
        goTo.page( path );
    };

  	$scope.editSupplier = function(sup_id){ 
      goTo.page('/suppliers/edit-suppliers/'+sup_id);
  	}

  	$scope.deleteSupplier = function(sup_id){
  		
  		var options = {
            title:'Delete Supplier',
            message:"Are you sure you want to delete this supplier?", 
            id: sup_id,
        }

        messageBox.delete(options).then(function(post) {

          if (post == 1) {

	            var deleteSupplierID = $.param({ sup_id: sup_id })

	            ajaxRequest.post('SupplierController/deleteSupplier',deleteSupplierID).then(function(response) {
	                 
	                if (response.status == 200) {
	                    Notification.success('Supplier has been deleted successfully.');
	                    $scope.getSuppliersList(); 
	                }else if(response.status == 500 || response.status == 404){
	                    Notification.error('An error occured while deleting item. Please try again.'); 
	                } 
	            });
          }


        });

  	}




}]);



app.controller('AddSupplierCtrl', [ '$scope', 'ajaxRequest', '$q', 'goTo', 'messageBox', 'Notification',
	function($scope, ajaxRequest, $q, goTo, messageBox, Notification) {

    $scope.title = 'Add Supplier';
  	$scope.breadcrumb = 'Home > Add Suppliers'; 
  	$scope.animated_class = 'animated fadeIn';


  	$scope.addSupplier = function(){

  		$scope.data = $.param({ 
	        sup_id: $scope.sup_id, 
	        sup_name: $scope.sup_name,  
	        dealer: $scope.dealer, 
	        nic: $scope.nic, 
	        address: $scope.address, 
	        tel: $scope.tel, 
	        fax: $scope.fax, 
	        email: $scope.email, 

	    }); 

		  ajaxRequest.post('SupplierController/addSupplier', $scope.data ).then(function(response) {

          if (response.status == 200) {
              Notification.success('New Supplier has been added successfully.');
              $scope.resetForm();
           }else if(response.status == 500 || response.status == 404){
              Notification.error('An error occured while adding supplier. Please try again.'); 
           }

          
          
      });
  };


  $scope.close = function(){
    goTo.page('suppliers');
  };
 

	 $scope.navigateTo = function ( path ) {
      goTo.page( path );
    };


}]);



app.controller('EditSupplierCtrl', ['$scope','goTo', '$http', 'ajaxRequest', '$q', '$routeParams', 'Notification',
  function($scope, goTo, $http, ajaxRequest, $q, $routeParams, Notification ) {

  $scope.title = 'Edit Supplier';
  $scope.breadcrumb = 'Home > Suppliers > Edit Supplier'; 
  $scope.editId = $.param({ sup_id: $routeParams.id });
 
  ajaxRequest.post('SupplierController/getSingleSupplier', $scope.editId ).then(function(response) {
      $scope.getSuppliers = response.data.data[0]; 

      $scope.sup_id = $scope.getSuppliers.sup_id;
      $scope.sup_name = $scope.getSuppliers.sup_name ;
      $scope.dealer = $scope.getSuppliers.dealer;
      $scope.nic = $scope.getSuppliers.nic;
      $scope.address = $scope.getSuppliers.address;
      $scope.tel = $scope.getSuppliers.tel;
      $scope.fax = $scope.getSuppliers.fax;
      $scope.email = $scope.getSuppliers.email;

      console.log($scope.getSuppliers);
  });




  $scope.editSupplier = function(){


    $scope.data = $.param({ 
        sup_id: $scope.sup_id, 
        sup_name: $scope.sup_name,  
        dealer: $scope.dealer, 
        nic: $scope.nic, 
        address: $scope.address, 
        tel: $scope.tel, 
        fax: $scope.fax, 
        email: $scope.email, 

    });


   ajaxRequest.post('SupplierController/updateSupplier', $scope.data).then(function(response) {

         if (response.status == 200) {
            Notification.success('Supplier details for <b>'+$scope.sup_name+'</b> has been updated successfully.');
         }else if(response.status == 500 || response.status == 404){
            Notification.error('An error occured while updating. Please try again.'); 
         }
    });

  };


  $scope.close = function(){
    goTo.page('suppliers');
  };


  $scope.navigateTo = function ( path ) {
      goTo.page( path );
  };



}]);