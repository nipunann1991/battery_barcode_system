app.controller('dashboardCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

    $scope.title = 'Dashboard';
    $scope.breadcrumb = 'Dashboard';
    $scope.animated_class = 'animated fadeIn'; 


    ajaxRequest.post('DashboardController/getDashboardDetails').then(function(response) {
       //console.log(response.data)
       $scope.invoices = response.data.invoices;
       $scope.suppliers = response.data.suppliers;
       $scope.items = response.data.items;
    });

    ajaxRequest.post('DashboardController/getRecentProducts').then(function(response) {
       $scope.getRecentProducts = response.data.data; 
       
    });

    

    

    $scope.getChart = function(){
    	var chart = c3.generate({
		    bindto: '#chart',

		    data: {
		      columns: [
		        ['Oct', 30, 20, 100, 40, 15, 25],
		        ['Nov', 50, 40, 106, 40, 15, 66]
		      ],
                type: 'bar',
                colors: {
                    Oct: '#00b356',
                    Nov: '#6254b2', 
                },
                color: function (color, d) { 
                    return d.id && d.id === 'data3' ? d3.rgb(color).darker(d.value / 150) : color;
                }
		    }
		});
    };


  
    $scope.getChart();

}]);
