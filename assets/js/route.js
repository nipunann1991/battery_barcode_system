/*
* Routes
*/
app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
  $routeProvider
    
    .when("/", { templateUrl : "index.php/Pages/dashboard",  css: 'style.css' })

    .when("/items", { templateUrl : "index.php/Pages/items",  css: 'style.css' })
    .when("/items/add-item", { templateUrl : "index.php/Pages/addItems",  css: 'style.css' }) // templateUrl : templates/items/add-items.php
    .when("/items/edit-item/:id", { templateUrl : "index.php/Pages/editItems",  css: 'style.css' })
    .when("/items/view-item-stock/:id", { templateUrl : "index.php/Pages/viewItemStock",  css: 'style.css' })
    .when("/items/view-barcode/:barcode", { templateUrl : "index.php/Pages/viewBarcode",  css: 'style.css' })

    .when("/package", {  templateUrl : "index.php/Pages/package",  css: 'style.css' })
    .when("/package/add-package", {  templateUrl : "index.php/Pages/addPackage",  css: 'style.css' })
    .when("/package/edit-package/:id", {  templateUrl : "index.php/Pages/editPackage",  css: 'style.css' })
    .when("/package/view-package/:id", {  templateUrl : "index.php/Pages/viewPackage",  css: 'style.css' })

    .when("/categories", {  templateUrl : "index.php/Pages/categories",  css: 'style.css' })
    .when("/categories/add-category", {  templateUrl : "index.php/Pages/addCategories",  css: 'style.css' })
    .when("/categories/edit-category/:id", {  templateUrl : "index.php/Pages/editCategories",  css: 'style.css' })

    .when("/suppliers", {  templateUrl : "index.php/Pages/supplier",  css: 'style.css' })
    .when("/suppliers/add-suppliers", {  templateUrl : "index.php/Pages/addSupplier",  css: 'style.css' })
    .when("/suppliers/edit-suppliers/:id", {  templateUrl : "index.php/Pages/editSupplier",  css: 'style.css' })

    .when("/invoice", { templateUrl : "index.php/Pages/invoice",  css: 'style.css' })
    .when("/invoice/new-invoice", { templateUrl : "index.php/Pages/newInvoice",  css: 'style.css' })

    .when("/settings", { templateUrl : "index.php/Pages/settings",  css: 'style.css' })

 
  $locationProvider.hashPrefix('');

}]);

/*
* Navigation Menu & Links
*/

app.controller('navCtrl', function($scope) {
  
  $scope.application_name = 'Logo';
 


  $scope.nav_links = [
    { page_name: 'Dashboard' ,page_icon: 'icon-icon' , page_link: '#/', page_sublinks: '' },

    { page_name: 'Invoice' ,page_icon: 'icon-list' , page_link: '#/invoice', page_sublinks: '' },

    { page_name: 'Items' ,page_icon: 'icon-car-battery' , page_link: '#items' ,  page_sublinks: ''},

    { page_name: 'Package' ,page_icon: 'icon-box' , page_link: '#package' ,  page_sublinks: '' },

    { page_name: 'Categories' ,page_icon: 'icon-share' , page_link: '#categories' ,  page_sublinks: ''},

    { page_name: 'Suppliers' ,page_icon: 'icon-truck' , page_link: '#suppliers' , page_sublinks: ''},
 
   
    
    { page_name: 'Settings' ,page_icon: 'icon-settings' , page_link: '#/settings', page_sublinks: '' },
  ];


});


    // { page_name: 'Suppliers' ,page_icon: 'icon-worker-loading-boxes' , page_link: '#suppliers' , page_sublinks: [
    //     {subpage_name: 'View Suppliers' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#suppliers'},
    //     {subpage_name: 'Add Suppliers' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#suppliers/add-suppliers'}, 

    // ]},