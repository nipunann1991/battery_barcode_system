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

    .when("/categories", {  templateUrl : "index.php/Pages/categories",  css: 'style.css' })
    .when("/categories/add-category", {  templateUrl : "index.php/Pages/addCategories",  css: 'style.css' })
    .when("/categories/edit-category/:id", {  templateUrl : "index.php/Pages/editCategories",  css: 'style.css' })

    .when("/suppliers", {  templateUrl : "index.php/Pages/supplier",  css: 'style.css' })
    .when("/suppliers/add-suppliers", {  templateUrl : "index.php/Pages/addSupplier",  css: 'style.css' })
    .when("/suppliers/edit-suppliers/:id", {  templateUrl : "index.php/Pages/editSupplier",  css: 'style.css' })

    .when("/POS-app", { templateUrl : "index.php/Pages/POS",  css: 'style.css' })

    .when("/settings", { templateUrl : "index.php/Pages/settings",  css: 'style.css' })

 
  $locationProvider.hashPrefix('');

}]);

/*
* Navigation Menu & Links
*/

app.controller('navCtrl', function($scope) {
  
  $scope.application_name = 'Barcode System';
 


  $scope.nav_links = [
    { page_name: 'Dashboard' ,page_icon: 'icon-dashboard' , page_link: '#/', page_sublinks: '' },

    { page_name: 'POS App' ,page_icon: 'glyphicon glyphicon-qrcode' , page_link: '#/POS-app', page_sublinks: '' },

    { page_name: 'Items' ,page_icon: 'icon-shopping-basket' , page_link: '#items' , page_sublinks: [
        {subpage_name: 'View Items' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#items'},
        {subpage_name: 'Add Items' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#items/add-item'}, 
    ]},

    { page_name: 'Package' ,page_icon: 'icon-shopping-basket' , page_link: '#package' , page_sublinks: [
        {subpage_name: 'View Package' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#package'},
        {subpage_name: 'Add Package' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#package/add-package'}, 
    ]},

    { page_name: 'Categories' ,page_icon: 'icon-category' , page_link: '#categories' , page_sublinks: [
      {subpage_name: 'View Category' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#categories'},
        {subpage_name: 'Add Category' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#categories/add-category'},

    ]},
    { page_name: 'Suppliers' ,page_icon: 'icon-worker-loading-boxes' , page_link: '#suppliers' , page_sublinks: [
        {subpage_name: 'View Suppliers' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#suppliers'},
        {subpage_name: 'Add Suppliers' ,subpage_icon: 'icon-shopping-basket' , subpage_link: '#suppliers/add-suppliers'}, 

    ]},
 
   
    
    { page_name: 'Settings' ,page_icon: 'glyphicon glyphicon-cog' , page_link: '#/settings', page_sublinks: '' },
  ];


});