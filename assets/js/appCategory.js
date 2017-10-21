app.controller('CategoryCtrl', ['$scope', 'ajaxRequest', 'goTo', 'messageBox', 'Notification', function($scope, ajaxRequest, goTo, messageBox, Notification) {

  	$scope.title = 'Categories';
  	$scope.breadcrumb = 'Home > Categories'; 
  	$scope.animated_class = 'animated fadeIn';


 	$scope.getCategoriesList = function(){
  		ajaxRequest.post('CategoryController/getCategories').then(function(response) {
	        $scope.getCategories = response.data.data;  
 
	    });
  	}

  	$scope.getCategoriesList();

  	$scope.navigateTo = function ( path ) {
        goTo.page( path );
    }


    $scope.editCategory = function(id){
    	 goTo.page('/categories/edit-category/'+id);
    };


   
    $scope.deleteCategory = function(id){

        var options = {
            title:'Delete Category',
            message:"Are you sure you want to delete this category?", 
            id: id,
        }

        messageBox.delete(options).then(function(post) {

          if (post == 1) {

            var deleteID =  $.param({ id: id })

            ajaxRequest.post('CategoryController/deleteCategories',deleteID).then(function(response) {
                 
                if (response.status == 200) {
                    Notification.success('Category has been deleted successfully.');
                    $scope.getCategoriesList(); 
                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while deleting category. Please try again.'); 
                 } 
            });
          }


        });
    };




}]);


app.controller('AddCategoriesCtrl', ['$scope', 'goTo', 'getLastCat', 'Notification','ajaxRequest' , function($scope, goTo, getLastCat, Notification, ajaxRequest){

	$scope.title = 'Add Category';
  	$scope.breadcrumb = 'Home > Add Category'; 
  	$scope.animated_class = 'animated fadeIn';

  	getLastCat.id().then(function(id){
		 

		if ( typeof id == 'undefined') {
	        $scope.cat_id = 1;
	    }else{ 
	        $scope.cat_id = parseInt(id) + 1; 
	    }

	});

  	$scope.navigateTo = function ( path ) {
        goTo.page( path );
    }

    $scope.close = function(){
	    goTo.page('categories');
	};

	$scope.resetForm = function(){
		$scope.cat_id++;
		$scope.cat_name = $scope.cat_desc = ''
		$scope.addCategory.$setUntouched();
	}


    $scope.addCategories = function(){

    	$scope.data = $.param({ 
           	id: $scope.cat_id, 
            cat_name: $scope.cat_name, 
            cat_desc: $scope.cat_desc,  

        });


    	ajaxRequest.post('CategoryController/addCategories', $scope.data ).then(function(response) {

            if (response.status == 200) {
                Notification.success('New category has been added successfully.');
                $scope.resetForm();
             }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding category. Please try again.'); 
             }

            
            
        });
        
    }

  	 
	


}]);


app.controller('EditCategoriesCtrl', ['$scope', 'goTo', 'getLastCat', 'Notification','ajaxRequest' , '$routeParams', 
	function($scope, goTo, getLastCat, Notification, ajaxRequest, $routeParams){

	$scope.title = 'Edit Category';
  	$scope.breadcrumb = 'Home > Edit Category'; 
  	$scope.animated_class = 'animated fadeIn';

  	 
  	$scope.navigateTo = function ( path ) {
        goTo.page( path );
    }

    $scope.close = function(){
	    goTo.page('categories');
	};

	$scope.sendID = $.param({ id: $routeParams.id })

	ajaxRequest.post('CategoryController/getSingleCategory', $scope.sendID ).then(function(response) {
	 
		$scope.getCategory = response.data.data[0];

		$scope.cat_id = $scope.getCategory.id;
        $scope.cat_name = $scope.getCategory.cat_name;
        $scope.cat_desc =  $scope.getCategory.cat_desc;

	});

	 

    $scope.editCategories = function(){

    	$scope.data = $.param({ 
           	id: $scope.cat_id, 
            cat_name: $scope.cat_name, 
            cat_desc: $scope.cat_desc,  

        });

    	ajaxRequest.post('CategoryController/updateCategories', $scope.data ).then(function(response) {

            if (response.status == 200) {
                Notification.success('Category details for <b>'+$scope.cat_name+'</b> has been updated successfully.');
             }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while updating category. Please try again.'); 
             }

            
            
        });
        
    }

  	 

}]);


app.service('getLastCat', [ '$q', 'ajaxRequest',  function($q, ajaxRequest){

	this.id = function(){ 

		var deferred = $q.defer();
   	var posts = undefined;

		ajaxRequest.post('CategoryController/getLastIndex').then(function(response) { 

          if (response.data.data.length == 0) {
            deferred.resolve(0); 
          }else{  
            deferred.resolve(response.data.data[0].id); 
          }

        	 
    });

		posts = deferred.promise;   

    return $q.when(posts);

	     
	};

}]);


