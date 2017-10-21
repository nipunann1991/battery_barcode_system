app.controller('SettingsCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

    $scope.title = 'Settings';
    $scope.breadcrumb = 'Settings';
    $scope.animated_class = 'animated fadeIn';
    $scope.user = '', $scope.user_password = '';

    ajaxRequest.post('SettingsController/getRoles').then(function(response) {
      	$scope.getRoles = response.data.data; 
	});

    ajaxRequest.post('SettingsController/getCompanyDetails').then(function(response) {
        $scope.getCompanyDetails = response.data.data[0]; 

        $scope.company_name = $scope.getCompanyDetails.name;
        $scope.company_address = $scope.getCompanyDetails.address;
        $scope.company_tel = $scope.getCompanyDetails.tel;
        $scope.company_email = $scope.getCompanyDetails.email;
        $scope.company_note = $scope.getCompanyDetails.note;

    });


    $scope.getUsersList = function(){

    	ajaxRequest.post('SettingsController/getUsers').then(function(response) {
	      	$scope.getUsers = response.data.data;  
		});

    };


	$scope.getUsersList();


    $scope.openAddUserModal = function(){

    	$scope.animated_class = '';
    	$('#modalAddUser').modal('show');

    };


    $scope.addUserLogin = function(){

    	$scope.data = $.param({  
	        username: $scope.user,  
	        password: $scope.user_password, 
	        role_id: $scope.role,  
	    });

	   
     	 
     	ajaxRequest.post('SettingsController/addUsers', $scope.data).then(function(response) {
	      	if (response.status == 200) {
	            Notification.success('Supplier has been deleted successfully.');
                $scope.getUsersList(); 
            }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while deleting item. Please try again.'); 
            } 
		});

    };


    $scope.editUser= function(id){ 
        alert(id)
    }


    $scope.deleteUser= function(id){ 

        var options = {
            title:'Delete User',
            message:"Are you sure you want to delete this user?", 
            id: id,
            className: 'short_modal',
        }

        messageBox.delete(options).then(function(post) {

          if (post == 1) {
            
            var deleteItemStockID =  $.param({ login_id: id })


            ajaxRequest.post('SettingsController/deleteUsers',deleteItemStockID).then(function(response) {
                 
                if (response.status == 200) {
                    Notification.success('User has been deleted successfully.'); 
                    $scope.getUsersList();
                    
                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while deleting item. Please try again.'); 
                 } 
            });
          }


        });
    };


    $scope.updateCompanyDetails = function(){
        
        $scope.data = $.param({  
            id: 1,
            name: $scope.company_name,   
            address: $scope.company_address,  
            tel: $scope.company_tel, 
            email: $scope.company_email,  
            note: $scope.company_note,
        });

       // console.log($scope.data)

        ajaxRequest.post('SettingsController/updateCompanyDetails',$scope.data).then(function(response) {
                 
            if (response.status == 200) {
                Notification.success('Company details has been updated successfully.'); 
                $scope.getUsersList();
                
             }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while updating. Please try again.'); 
             } 

        });
          
    }



}]);
