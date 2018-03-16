app.controller('dashboardCtrl', ['$scope','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification',
  function($scope, $location, ajaxRequest, goTo, messageBox, Notification) {

    $scope.title = 'Dashboard';
    $scope.breadcrumb = 'Dashboard';
    $scope.animated_class = 'animated fadeIn'; 

    var currMonthName  = moment().format('MMM');
var prevMonthName  = moment().subtract(1, "month").format('MMM');

console.log(currMonthName);
console.log(prevMonthName);


    ajaxRequest.post('DashboardController/getDashboardDetails').then(function(response) {
       //console.log(response.data)
       $scope.invoices = response.data.invoices;
       $scope.suppliers = response.data.suppliers;
       $scope.items = response.data.items;
       $scope.packages = response.data.packages;
    });

    ajaxRequest.post('DashboardController/getRecentProducts').then(function(response) {
       $scope.getRecentProducts = response.data.data; 
       
    });

    ajaxRequest.post('DashboardController/getLastInvoices').then(function(response) {
       $scope.getLastInvoices = response.data.data; 
       console.log($scope.getLastInvoices)

       $scope.getChart($scope.getLastInvoices);
       
    });

    

    

  $scope.getChart = function(data){

      //console.log(data)
      //data.total_invoices = ['Invoices',12,60,70,55,46];

    	var chart = c3.generate({
		    bindto: '#chart',

 
        data: {
            x: 'x', 
            columns: [
              data.dates,
              data.total_invoices, 
            ],

            colors: {
              Invoices: '#00b356', 
          },

          color: function (color, d) { 
              return d.id && d.id === 'data3' ? d3.rgb(color).darker(d.value / 150) : color;
          }
        },
        axis: {

            x: {
                type: 'timeseries',
                tick: {
                    format: '%Y-%m-%d'
                }
            },

            y: {
                min: 0,
                tick: {
                    format: d3.format('d')
                },
                padding: {top: 0, bottom: 0}
            }

        },
        bar: { 
            width: 80 

        },
        grid: {
        x: {
            show: true
        },
        y: {
            show: true
        }
    }
		});
  };


  
    

}]);
