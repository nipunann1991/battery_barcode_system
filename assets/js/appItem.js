
/*
* ref: items.php
*/
  

app.controller('ItemsCtrl', ['$scope', '$compile','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder',
  function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder) {

    $scope.title = 'View Items';
    $scope.breadcrumb = 'Warn';
    $scope.animated_class = 'animated fadeIn';
   
     

      $scope.getItemsList = function (){ 

        var vm = this;
        vm.dtOptions = DTOptionsBuilder.newOptions()
          .withOption('ajax', { 
           url: 'index.php/ItemsController/getItemsJoined',
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
            DTColumnBuilder.newColumn('item_id').withTitle('#Item Id')
              .renderWith(function(data, type, full, meta) { 
                  return  '<a href="javascript:void(0)" ng-click="viewItemStock('+full.item_id+')">#'+full.item_id+'</a>';
              }), 
            DTColumnBuilder.newColumn('item_name').withTitle('Item Name')
              .renderWith(function(data, type, full, meta) { 
                  return  '<a href="javascript:void(0)" ng-click="viewItemStock('+full.item_id+')">'+full.item_name+'</a>';
              }), 
            DTColumnBuilder.newColumn('item_name').withTitle('Item Display'), 
            DTColumnBuilder.newColumn('cat_name').withTitle('Category'),
            DTColumnBuilder.newColumn(null).withTitle(' ')
             .renderWith(function(data, type, full, meta) { 

              var class_ = '', action_btns = '', hide_ = '';
 

                  if (!$scope.role_access) {
                    hide_ = 'hide';
                  }

                  return  `<div class="w100">
                          <a href="" id="view`+full.item_id+`" ng-click="viewItemStock(`+full.item_id+`)"  class="view" title="View Items" >
                            <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>
                          </a>
                          <a href="" id="edit`+full.item_id+`"  class="edit `+class_+`" title="Edit Items" ng-click="editItem(`+full.item_id+`)">
                            <i class="icon-pencil-edit-button" aria-hidden="true"></i>
                          </a>
                          <a href="" id="delete`+full.item_id+`" ng-click="deleteItem(`+full.item_id+`)" class="delete  `+hide_+`" title="Delete Items" >
                            <i class="icon-rubbish-bin" aria-hidden="true"></i>
                          </a></div>
                          `;
              }), 
            
        ];


        function createdRow(row, data, dataIndex) { 
            $compile(angular.element(row).contents())($scope);
        }
 
    }

    $scope.getItemsList();
 
  
    $scope.navigateTo = function ( path ) {
        goTo.page( path );
    };




    $scope.reInitTable = function(){
      var table = $('#datatableData').DataTable();
      table.clear().draw();
       $scope.getItemsList();

    }

    $scope.displayPrice = function(price){
      return price+'.00';
    };

 
    $scope.editItem = function(item_id){ 
      goTo.page('/items/edit-item/'+item_id);
    };


     $scope.viewItemStock = function(item_id){  
      goTo.page('/items/view-item-stock/'+item_id);
    }

 

    $scope.deleteItem = function(item_id){

        var options = {
            title:'Delete Item',
            message:"Are you sure you want to delete this item?", 
            id: item_id,
            className: 'short_modal',
        }

        messageBox.delete(options).then(function(post) {

          if (post == 1) {
            var deleteItemID =  $.param({ item_id: item_id })

            ajaxRequest.post('ItemsController/deleteItems',deleteItemID).then(function(response) {
                 
                if (response.status == 200) {
                    $scope.reInitTable();
                    Notification.success('Item has been deleted successfully.');
                    
                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while deleting item. Please try again.'); 
                 } 
            });

          } 

        });
    };
 

}]);


app.controller('SearchItemsCtrl', ['$scope', '$compile','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder', '$routeParams',
  function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder,$routeParams) {

    $scope.initBk = function(barcode){
        JsBarcode("#code128",  barcode , {  
          width:2,
          height:30,
          fontSize: 14 
        }); 
    }
 
   $scope.initBk('-');


     
  $scope.searchBAttery = function(item_barcode=null){  
        
      var barcode = '';

      if (item_barcode) {
        barcode = $.param({ barcode: item_barcode });
      }else{
        barcode = $.param({ barcode: $scope.item_barcode });
      }
     


      ajaxRequest.post('ItemsController/searchBattery',barcode).then(function(response) {
                 
          if (response.status == 200) {
                
              var result = response.data.data[0]

              if (typeof result != 'undefined') {
      
                $scope.barcode = result.barcode;
                $scope.cat_name = result.cat_name;
                $scope.invoice_no = result.invoice_no;
                $scope.grn = result.grn;
                $scope.item_name = result.item_name; 
                $scope.package_barcode = result.package_barcode; 
                $scope.sup_name = result.sup_name; 
                
                $scope.initBk($scope.barcode);

              }else{
                Notification.error('Battery Not Found.'); 
              }
              
              
           }else if(response.status == 500 || response.status == 404){
              Notification.error('An error occured while deleting item. Please try again.'); 
           } 
      });

    }

    if ( $routeParams.id ) {
      $scope.searchBAttery($routeParams.id);
    }

    $scope.navigateTo = function ( path ) {
        goTo.page( path );
    };


}]);


app.controller('printAllBarcode', ['$scope', '$compile','$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', 'DTOptionsBuilder', 'DTColumnBuilder', '$routeParams',
  function($scope, $compile, $location, ajaxRequest, goTo, messageBox, Notification, DTOptionsBuilder, DTColumnBuilder, $routeParams) {

    // $scope.initBk = function(i,barcode){
    //     JsBarcode(".barcode",  barcode , {  
    //       width:2,
    //       height:30,
    //       fontSize: 14 
    //     }); 
    // }
 
    //


     

    var barcode  = $.param({ barcode: $routeParams.id })
    $scope.pkg_bcode = $routeParams.id;
    JsBarcode(".barcode").init();
 
    ajaxRequest.post('ItemsController/getBatteryData', barcode).then(function(response) {
     
        $scope.results = response.data.data;
     
  
       for (var i = 0; i < $scope.results.length; i++) {
         $('.a').append('<svg class="barcode" jsbarcode-value="'+$scope.results[i].barcode+'" jsbarcode-textmargin="0" jsbarcode-fontSize="14" jsbarcode-height="30" jsbarcode-width="2" style="display: block; margin: 5px auto;"></svg> <script>JsBarcode(".barcode").init();</script>')
       }

 
    });

    
 

}]);



/*
* ref: add-items.php
*/
 

app.controller('addItemsCtrl', ['$scope', '$http', 'goTo', 'ajaxRequest', '$q' , 'Notification', 'fileUpload', 'barcodeNo', 'getLastCat',
  function($scope, $http, goTo, ajaxRequest, $q, Notification, fileUpload, barcodeNo, getLastCat) {


    $scope.title = 'Add Items';
    $scope.breadcrumb = 'Warn';
    $scope.animated_class = 'animated fadeIn';

     
    ajaxRequest.post('ItemsController/getSupplierList').then(function(response) {
        $scope.getSupplierList = response.data.data;  
    });


    ajaxRequest.post('ItemsController/getLastIndex').then(function(response) {
     
      if (response.data.data.length == 0) {
        $scope.item_id = 1;
      }else{  
        $scope.item_id = parseInt(response.data.data[0].item_id) + 1; 
      }
      
 
    });

    $("#imgInp").change(function(){
        $scope.readURL(this);
    });



    $scope.uploadFile = function(){
        
    };

    $scope.readURL = function(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.item_img').attr('style', 'background-image: url('+e.target.result+')');
            }

            reader.readAsDataURL(input.files[0]);


        }
    };

    


    $scope.close = function(){
      goTo.page('items');
    };

  
    $scope.addItem = function(){

        var myFile = $scope.myFile;
        var item_id = $scope.item_id;
        var item_name = $scope.item_name;
        var item_display_name =  $scope.item_display_name;
        var category = $scope.category;
      

        var data_item = $.param({ 
            item_id: item_id, 
            item_name: item_name, 
            item_display_name: item_display_name,  
            cat_id: category,
            image_url: '', 
 
        });



         
        ajaxRequest.post('ItemsController/addItem', data_item ).then(function(response) {


            if (response.status == 200) {

              var file = $scope.myFile;
              var uploadUrl = "index.php/ItemsController/fileUpload";
              var text = $scope.name;

              fileUpload.uploadFileToUrl(file, uploadUrl, text, item_id);

              if (response.status == 200) {
                  Notification.success('New item has been added successfully.'); 
                  $scope.navigateTo('items');
              }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding item. Please try again.'); 

              }  


             }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding item. Please try again.'); 
             } 
            
        });   
    };



    $scope.navigateTo = function ( path ) {
        goTo.page( path );
    };


    $scope.add_category = function () {
      $scope.animated_class = '';
      $('#myModalAddCategory').modal('show');
    };


    $scope.getCategoryListData = function () {

       ajaxRequest.post('ItemsController/getCategoryList').then(function(response) {
          $scope.getCategoryList = response.data.data;   
      });

    };
   

    $scope.getCategoryListData();

    /*
    * Add Category
    */

    getLastCat.id().then(function(id){

      if ( typeof id == 'undefined') {
            $scope.cat_id = 1;
        }else{ 
            $scope.cat_id = parseInt(id) + 1; 
        }

    });

   
    $scope.close = function(){ 
      $('#myModalAddCategory').modal('hide');
    };


    $scope.resetFormCategories = function(){
      $scope.cat_id++;
      $scope.cat_name = $scope.cat_desc = ''
      $scope.addCategory.$setUntouched();
    };


    $scope.addCategories = function(){

      $scope.data = $.param({ 
        id: $scope.cat_id, 
        cat_name: $scope.cat_name, 
        cat_desc: $scope.cat_desc,  

      });


      ajaxRequest.post('CategoryController/addCategories', $scope.data ).then(function(response) {

            if (response.status == 200) {
                Notification.success('New category has been added successfully.');
                $scope.resetFormCategories();
                $scope.getCategoryListData();
                $('#myModalAddCategory').modal('hide');
             }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding category. Please try again.'); 
             }

            
            
        });
        
    }


    
}]);



 



/*
* ref: edit-items.php
*/

app.controller('editItemsCtrl', ['$scope', '$http', 'goTo', 'ajaxRequest', '$q', '$routeParams' , 'Notification', 'fileUpload',
  function($scope, $http, goTo, ajaxRequest, $q, $routeParams, Notification, fileUpload) {
    $scope.title = 'Edit Items';
    $scope.breadcrumb = 'Warn';
    $scope.animated_class = 'animated fadeIn';

    $scope.discount_type = 1;

    $scope.routeParams = $routeParams.id;

    
    $("#imgInp").change(function(){
      $scope.readURL(this);

    });

    $scope.uploadFile = function(){
        
    };

    $scope.readURL = function(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.item_img').attr('style', 'background-image: url('+e.target.result+')');
            }

            reader.readAsDataURL(input.files[0]);

         }
    };

    var sendItemID = $.param({ item_id: $routeParams.id })
 

    ajaxRequest.post('ItemsController/getCategoryList').then(function(response) {
        $scope.getCategoryList = response.data.data; 
    });

    ajaxRequest.post('ItemsController/getSupplierList').then(function(response) {
        $scope.getSupplierList = response.data.data;  
    });

    $scope.discount_type_vals = [{ id: 1, value: 'Rs.' },{ id: 2, value: '%' }];


    ajaxRequest.post('ItemsController/getSingleItem', sendItemID ).then(function(response) {


        $scope.getDetails = response.data.data[0];

        $scope.item_id = $scope.getDetails.item_id;
        $scope.item_name = $scope.getDetails.item_name;
        $scope.item_display_name = $scope.getDetails.item_display_name;
        $scope.supplier = $scope.getDetails.sup_id;
        $scope.category = $scope.getDetails.cat_id;
        $scope.barcode = $scope.getDetails.barcode;
        $scope.manufacture_id = $scope.getDetails.manufacture_id;
        $scope.buy_price = parseInt($scope.getDetails.buy_price);
        $scope.sell_price = parseInt($scope.getDetails.sell_price);
        $scope.quantity = parseInt($scope.getDetails.quantity);
        $scope.reorder_level = parseInt($scope.getDetails.reorder_level);
        $scope.discount = parseInt($scope.getDetails.discount);
        $scope.discount_type = $scope.getDetails.discount_type;
        $scope.net_amount = parseInt($scope.getDetails.net_amount);

        var image_url = $scope.getDetails.image_url;

        if ($scope.getDetails.image_url.split('/')[2] == '') {
          image_url = 'assets/images/upload-image.png';
        }

        $('.item_img').attr('style', 'background-image: url('+image_url+')');

  

        if ($scope.getDetails.calc_item) {
          $scope.calc_item = true;
          $scope.calc_item1 = 1;
        }else{
          $scope.calc_item1 = 0;
        }


        if ($scope.getDetails.price_changable) {
          $scope.price_changable = true;
          $scope.price_changable1 = 1;
        }else{
          $scope.price_changable1 = 0;
        }
       
         

    });

    

    $scope.navigateTo = function ( path ) {
        goTo.page( path+"/"+$scope.routeParams );
    };


    $scope.close = function(){
      goTo.page('items');
    };


    $scope.checked = function(){

      if ($scope.use_item_display_name) {
        $scope.item_display_name = $scope.item_name;
      } 


      if (!$scope.price_changable) {
          $scope.price_changable1 = 0;
      }


      if (!$scope.calc_item) {
        $scope.calc_item1 = 0;
      }

    };


    $scope.net_price = function(){


      if (isNaN($scope.sell_price)) {
        $scope.net_amount = 0;
      }else{ 
  
          switch($scope.discount_type){
 
            case '1' :  $scope.net_amount = $scope.sell_price - $scope.discount;
                      break;

            case '2' :  $scope.net_amount = $scope.sell_price - ( $scope.sell_price * $scope.discount / 100 );
                      break;

            default: break
          }
         
      }

      return $scope.net_amount;
       
    };


    $scope.editItem = function(){

        var item_id = $scope.item_id;
        var item_name = $scope.item_name;
        var item_display_name =  $scope.item_display_name;
        var supplier = $scope.supplier;
        var category = $scope.category;
        var barcode = $scope.barcode;
        var manufacture_id = $scope.manufacture_id;
        var buy_price = $scope.buy_price;
        var sell_price = $scope.sell_price;
        var quantity = $scope.quantity;
        var reorder_level = $scope.reorder_level;
        var discount = $scope.discount;
        var discount_type = $scope.discount_type;
        var net_amount = $scope.net_amount;
        var price_changable = $scope.price_changable1;
        var calc_item = $scope.calc_item1;


        var data = $.param({ 
            item_id: item_id, 
            item_name: item_name, 
            item_display_name: item_display_name, 
            cat_id: category,   

        });


      ajaxRequest.post('ItemsController/updateItems', data).then(function(response) {
        
           if (response.status == 200) {

              var file = $scope.myFile;
              var uploadUrl = "index.php/ItemsController/fileUpload";
              var text = $scope.name;
              
              if (typeof $scope.myFile != 'undefined') {
                fileUpload.uploadFileToUrl(file, uploadUrl, text, item_id);
              }
              
              Notification.success('Item details for <b>'+item_display_name+'</b> has been updated successfully.');
              $('#myModalEdit').modal('hide');

           }else if(response.status == 500 || response.status == 404){
              Notification.error('An error occured while updating. Please try again.'); 
           }
      });


    }

    $scope.resetForm = function(){
       $scope.item_id = $scope.barcode = '' 
       $scope.addItemForm.$setUntouched();
    }

 
    
}]);





/*
* ref: view-item-stock.php
*/

app.controller('ItemsStockCtrl', ['$scope', '$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', '$routeParams', 'barcodeNo', 'DTOptionsBuilder', 'DTColumnBuilder',  
  function($scope, $compile,  $location, ajaxRequest, goTo, messageBox, Notification, $routeParams, barcodeNo, DTOptionsBuilder, DTColumnBuilder ) {

    $scope.title = 'View Stock';
    $scope.breadcrumb = 'Warn';
    $scope.animated_class = 'animated fadeIn';
 
    var sendItemID = $.param({ item_id: $routeParams.id })

    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [[0, 'desc']]);
 

    ajaxRequest.post('ItemsController/getSingleItemJoined', sendItemID ).then(function(response) {

        $scope.getDetails = response.data.data[0];
        $scope.stock_id = $scope.getDetails.stock_id; 
        $scope.item_id = $scope.getDetails.item_id;
        $scope.item_name = $scope.getDetails.item_name;
        $scope.item_display_name = $scope.getDetails.item_display_name;
        $scope.supplier_id = $scope.getDetails.sup_id;
        $scope.supplier_name = $scope.getDetails.sup_name;
        $scope.category_id = $scope.getDetails.cat_id;
        $scope.category_name = $scope.getDetails.cat_name;
        $scope.rm_stock = $scope.getDetails.rm_stock;

 

        $scope.num1 = Math.floor(Math.random() * 10000) + 1000;
        $scope.num2 = Math.floor(Math.random() * 10000) + 1000  
        
         var image_url = $scope.getDetails.image_url;

        if ($scope.getDetails.image_url.split('/')[2] == '') {
          image_url = 'assets/images/upload-image.png';
        }

        $('.item_img').attr('style', 'background-image: url('+image_url+')');
 

    });

 

    $scope.viewInvoice = function(invoice_id){ 
      goTo.page('invoice/view-invoice/'+invoice_id);
    };


    $scope.viewPackage = function(package_id){ 
      goTo.page('package/view-package/'+package_id);
    };

    $scope.getBarcode = function(){ 
      
      $scope.total_qty = $scope.pkg_qty * $scope.bat_qty;
 
      $scope.barcode = ($scope.invoice_id + $scope.grn) +$scope.manufacture_id+ $scope.pkg_qty +$scope.bat_qty;
      barcodeNo.generateBarcode($scope.barcode);
    };

    $scope.getBarcode();

 

    $scope.getSingleItemStock = function (){  
       
        $scope.dtOptions = DTOptionsBuilder.newOptions()
          .withOption('ajax', { 
           url: 'index.php/ItemsController/getSingleItemStock',
           type: 'POST',
           data: { item_id: $routeParams.id },

       })
      
      .withDataProp('data')
      .withOption('processing', true) 
      .withOption('serverSide', true) 
      .withOption('paging', true) 
      .withOption("destroy", true)
      .withOption('stateSave', false)
      .withDisplayLength(10) 
      .withOption('createdRow', createdRow) 
      .withOption('aaSorting',[0,'asc']);
        $scope.dtColumns = [
            DTColumnBuilder.newColumn('stock_id').withTitle('# Stock ID'), 
            DTColumnBuilder.newColumn('barcode').withTitle('Package Barcode')
              .renderWith(function(data, type, full, meta) { 
 
                  return  '<a href="#items/view-package_items/'+full.barcode+'">'+full.barcode+'</a><a href="#items/view-barcode/'+full.barcode+'"><i class="icon-printer pull-right print"></i></a>';
              }), 
            
            DTColumnBuilder.newColumn('invoice_no').withTitle('Invoice No'),  
            DTColumnBuilder.newColumn('grn').withTitle('GRN'), 
            DTColumnBuilder.newColumn('manufacture_id').withTitle('Note')
              .renderWith(function(data, type, full, meta) { 
                  //console.log(full)
                  return  'GRN: '+full.grn+' / '+full.bat_qty+'x'+full.pkg_qty
              }), 
            
            DTColumnBuilder.newColumn('rm_stock').withTitle('Stock'), 
            DTColumnBuilder.newColumn('status').withTitle('Status')
              .renderWith(function(data, type, full, meta) {  

                  var label_ = '';

                  if (full.status == 0) {
                    label_ = '<span class="label label-danger sold" title="Click to view invoice" ng-click="viewInvoice('+full.invoice_id+')"  >Sold</span>';
                  }else if(full.status == 1){
                    label_ = '<span class="label label-success"  >In Stock</span>'
                  }else if(full.status == -1){
                    label_ = '<span ng-click="viewPackage('+full.package_id+')" title="Click to view package" class="label label-warning packed"  >Missing</span>'
                  } 
               
                  return  label_;

              }),  
              DTColumnBuilder.newColumn(null).withTitle('Note')
              .renderWith(function(data, type, full, meta) { 
                  //console.log(full)
                  return  'Edit'
              }),
            
        ];
        

        function createdRow(row, data, dataIndex) { 
          $compile(angular.element(row).contents())($scope);
        }

        ajaxRequest.post('ItemsController/getSupplierList').then(function(response) {
            $scope.getSupplierList = response.data.data;  
        });

    };

 
    
 

    $scope.editItem = function(item_id){ 
      goTo.page('/items/edit-item/'+item_id);
    };


    /*
    * Edit Item
    */

    $scope.openEditStockModal = function(stock_id){

       

        var sendItemBarcode = $.param({ stock_id: stock_id }); 
        $scope.stock_id =  stock_id;

        ajaxRequest.post('ItemsController/getSingleItemFromStock', sendItemBarcode ).then(function(response) {

            $scope.getSingleItemFromStock = response.data.data[0]; 
            
 

            $scope.barcode = $scope.getSingleItemFromStock.barcode;
            $scope.invoice_id = $scope.getSingleItemFromStock.invoice_no;
            $scope.manufacture_id = $scope.getSingleItemFromStock.manufacture_id;
            $scope.supplier = $scope.getSingleItemFromStock.sup_id;

             
              JsBarcode("#code128",  $scope.barcode , {  
                width:2,
                height:30,
                fontSize: 14 
              }); 

            
        });

          $scope.animated_class = ''
          $('#myModalEdit').modal('show');

    };



      $scope.openAddBulkStock = function(stock_id){

        
        $scope.animated_class = ''; 

        $scope.barcode = '0';
        $scope.manufacture_id = '';
        $scope.buy_price = 0;
        $scope.sell_price = 0;
        $scope.quantity = 1;
        $scope.reorder_level = 1;
        $scope.discount = 0;
        $scope.discount_type = '1';
        $scope.net_amount = 0;

        $scope.total_qty = 0;

        $scope.invoice_id = $scope.grn = $scope.manufacture_id = $scope.pkg_qty  =  $scope.bat_qty  = 0;

        barcodeNo.generateBarcode($scope.barcode);

        $scope.animated_class = ''

        $('#addBulkStock').modal('show');

    };


    $scope.editStockItem = function(stock_id){
    
        var data = $.param({ 
          item_id: $routeParams.id, 
          stock_id: stock_id,
          barcode: $scope.barcode,
          sup_id: $scope.supplier,
          manufacture_id: $scope.manufacture_id,
          invoice_no: $scope.invoice_id,
        });

         
      ajaxRequest.post('ItemsController/updateItemsStock', data).then(function(response) {
        
          if (response.status == 200) {
              Notification.success('Item details has been updated successfully.');
              $scope.getSingleItemStock();
              $('#myModalEdit').modal('hide');
          }else if(response.status == 500 || response.status == 404){
              Notification.error('An error occured while updating. Please try again.'); 
          }


      });

    
    };



     $scope.openModalAddStock = function(){
            
        $scope.animated_class = ''; 

        $scope.barcode = '0';
        $scope.manufacture_id = '';
        $scope.buy_price = 0;
        $scope.sell_price = 0;
        $scope.quantity = 1;
        $scope.reorder_level = 1;
        $scope.discount = 0;
        $scope.discount_type = '1';
        $scope.net_amount = 0;

        barcodeNo.generateBarcode($scope.barcode);

        $scope.animated_class = ''
        $('#myModalAdd').modal('show');
     };


     $scope.addStockItem = function(){

        var data_add_item_stock = $.param({ 
          item_id: $routeParams.id, 
          barcode: $scope.barcode,
          sup_id: $scope.supplier,
          manufacture_id: $scope.manufacture_id,
          invoice_no: $scope.invoice_id,
          package_id: '0',
          status: '1',

        });
 

        ajaxRequest.post('ItemsController/addItemStock', data_add_item_stock ).then(function(response) {

            if (response.status == 200) {
                Notification.success('New Stock has been added successfully.');  
                $scope.reInitTable();

                $('#myModalAdd').modal('hide');
            }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding item. Please try again.'); 
            }   

        });


     };


     $scope.addBulkStockItem = function(){

      $('.loader1').removeClass('hide');

        var data_add_item_stock = $.param({ 
          barcode: $scope.barcode,
          invoice_no: $scope.invoice_id, 
          item_id: $routeParams.id, 
          grn: $scope.grn,
          bat_qty: $scope.bat_qty,
          pkg_qty: $scope.pkg_qty, 
          sup_id: $scope.supplier,
          package_id: '0',
          status: '1',
          note: $scope.note,
        });
         

 
 
        $scope.count = 0;


        ajaxRequest.post('ItemsController/addBulkItemStock', data_add_item_stock ).then(function(response) {

            if (response.status == 200) {

                Notification.success('New Stock has been added successfully.');  
                $scope.reInitTable();
                $('#addBulkStock').modal('hide');
                $('.loader1').addClass('hide');

                
            }else if(response.status == 500 || response.status == 404){
                Notification.error('An error occured while adding item. Please try again.'); 
            }   

        });


     };


    $scope.deleteItem = function(stock_id){
       
        var options = {
            title:'Delete Item',
            message:"Are you sure you want to delete this item?", 
            id: stock_id,
            className: 'short_modal',
        }

        messageBox.delete(options).then(function(post) {

          if (post == 1) {
            var deleteItemStockID =  $.param({ stock_id: stock_id })


            ajaxRequest.post('ItemsController/deleteItemsStock',deleteItemStockID).then(function(response) {
                 
                if (response.status == 200) {
                    Notification.success('Item has been deleted successfully.'); 
                    $scope.reInitTable();
                    
                 }else if(response.status == 500 || response.status == 404){
                    Notification.error('An error occured while deleting item. Please try again.'); 
                 } 
            });
          }


        });
    };

    
    $scope.reInitTable = function(){
      var table = $('#datatableData').DataTable();
      table.clear().draw();
      $scope.getSingleItemStock();

    }

    $scope.net_price = function(){

      if (isNaN($scope.sell_price)) {
        $scope.net_amount = 0;
      }else{ 
  
          switch($scope.discount_type){
 
            case '1' :  $scope.net_amount = $scope.sell_price - $scope.discount;
                      break;

            case '2' :  $scope.net_amount = $scope.sell_price - ( $scope.sell_price * $scope.discount / 100 );
                      break;

            default: break
          }
         
      }

      return $scope.net_amount;
       
    };

    $scope.navigateTo = function ( path ) {
        goTo.page( path );
    };


    $scope.displayDiscount = function(discount, discount_type ){

       if (discount_type == 1) {
         return currency+''+discount;

       }else if(discount_type == 2){
          return discount+'%';

       }else{

       }

    };


 
    $scope.getSingleItemStock();

   
 

}]);


app.controller('PackageItemsStockCtrl', ['$scope', '$compile', '$location', 'ajaxRequest', 'goTo', 'messageBox' , 'Notification', '$routeParams', 'barcodeNo', 'DTOptionsBuilder', 'DTColumnBuilder',  
  function($scope, $compile,  $location, ajaxRequest, goTo, messageBox, Notification, $routeParams, barcodeNo, DTOptionsBuilder, DTColumnBuilder ) {

    $scope.title = 'View Stock';
    $scope.breadcrumb = 'Warn';
    $scope.animated_class = 'animated fadeIn';
    $scope.barcode  =$routeParams.id;
    var barcode = $.param({ barcode: $routeParams.id })


    ajaxRequest.post('ItemsController/getPackageItemData', barcode ).then(function(response) {
        $scope.getPackageItemData = response.data.data[0];  

        $scope.category_name = $scope.getPackageItemData.cat_name;
        $scope.category_id = $scope.getPackageItemData.cat_id;
        $scope.invoice_no = $scope.getPackageItemData.invoice_no;
        $scope.grn = $scope.getPackageItemData.grn;
        $scope.items = $scope.getPackageItemData.bat_qty;
        $scope.item_name = $scope.getPackageItemData.item_name;
        $scope.item_display_name = $scope.getPackageItemData.item_display_name;
        $scope.item_id = $scope.getPackageItemData.item_id;

 
    });

    $scope.viewInvoice = function(invoice_id){ 
      goTo.page('invoice/view-invoice/'+invoice_id);
    };



    $scope.getPackageItemList = function (){  
       
        $scope.dtOptions = DTOptionsBuilder.newOptions()
          .withOption('ajax', { 
           url: 'index.php/ItemsController/getPackageItemList',
           type: 'POST',
           data: { barcode: $routeParams.id },

       })
      
      .withDataProp('data')
      .withOption('processing', true) 
      .withOption('serverSide', true) 
      .withOption('paging', true) 
      .withOption("destroy", true)
      .withOption('stateSave', false)
      .withDisplayLength(10) 
      .withOption('createdRow', createdRow) 
      .withOption('aaSorting',[0,'asc']);
        $scope.dtColumns = [
            DTColumnBuilder.newColumn('stock_id').withTitle('# Index')
            .renderWith(function(data, type, full, meta) {  

                  return meta.row + 1;
              }), 
            DTColumnBuilder.newColumn('barcode').withTitle('Barcode')
              .renderWith(function(data, type, full, meta) {  
                  return  '<a href="javascript:void(0);">'+full.barcode+'</a><a href="#items/view-barcode/'+full.barcode+'"><i class="icon-printer pull-right print"></i></a>';
              }), 
             
             
            DTColumnBuilder.newColumn('invoice_id').withTitle('Invoice ID'),
            DTColumnBuilder.newColumn('status').withTitle('Status')
              .renderWith(function(data, type, full, meta) {  

                  var label_ = '';

                  if (full.status == 0 ) {
                    label_ = '<span class="label label-danger sold" title="Click to view invoice" ng-click="viewInvoice('+full.invoice_id+')"  >Sold</span>';
                  }else if(full.status == 1 ){
                    label_ = '<span class="label label-success"  >In Stock</span>'
                  }else if(full.status == -1 ){
                    label_ = '<span ng-click="viewPackage('+full.package_id+')" title="Click to view package" class="label label-warning packed"  >Missing</span>'
                  } 
               
                  return  label_;

              }), 

            
            
        ];
        

        function createdRow(row, data, dataIndex) { 
          $compile(angular.element(row).contents())($scope);
        }

        // ajaxRequest.post('ItemsController/getSupplierList').then(function(response) {
        //     $scope.getSupplierList = response.data.data;  
        // });

    };

    $scope.navigateTo = function () {
        goTo.page('items/view-item-stock/'+$scope.item_id );
    };

    $scope.navigateToPrintAll = function () {
        goTo.page( 'items/print-all-barcode/'+$scope.barcode );
    };


    $scope.getPackageItemList();
    

}]);


