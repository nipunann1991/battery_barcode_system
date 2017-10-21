app.controller('posAppCtrl', ['$scope','ajaxRequest', '$q', function($scope, ajaxRequest, $q ) {

    $scope.title = 'POS App';
    $scope.breadcrumb = 'Home > POS App'; 


    $scope.getItems = function(){

      ajaxRequest.post('PosController/getItems').then(function(response) {
          $scope.getItems = response.data.data;  
          
          console.log($scope.getItems);

      });
      
    };

    $scope.getItems();

    
}]);