app.controller('dashboardCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

    $scope.title = 'Dashboard';
    $scope.breadcrumb = 'Dashboard';
    $scope.animated_class = 'animated fadeIn'; 

    ajaxRequest.post('DashboardController/getCountProducts').then(function(response) {
        $scope.getCountProducts = response.data.data[0];   
        $scope.products =$scope.getCountProducts.count;
    });

    ajaxRequest.post('DashboardController/getRecentProducts').then(function(response) {
        $scope.getRecentProducts = response.data.data;   
        console.log($scope.getRecentProducts)
    });

    ajaxRequest.post('DashboardController/getCountSupplires').then(function(response) {
        $scope.getCountSupplires = response.data.data[0];   
        $scope.supplier =$scope.getCountSupplires.count;
    });

    

    $scope.getChart = function(){
    	var chart = c3.generate({
		    bindto: '#chart',
		    data: {
		      columns: [
		        ['data1', 30, 200, 100, 400, 150, 250],
		        ['data2', 50, 20, 10, 40, 15, 25]
		      ]
		    }
		});
    };


  
    $scope.getChart();

}]);
