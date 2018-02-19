<div ng-controller="PackageItemsStockCtrl" class="page_inner {{animated_class}}">
	
	
		<div class="head">
			<div class="top"> 
				<h2>View Items in #{{barcode}} </h2>
		  		<span class="breadcrumb">{{breadcrumb}}</span>
		  		<div class="clearfix"></div>
			</div> 
	 

		</div>
		
		<div class="row profile_details">
			
		 	
			<div class="col-md-3">
				<div class="mid" >
			 
			    		<div class="item_img row" >
			    			<!-- <input type="file" file-model="myFile" id="imgInp" > -->
			    		</div>
			    	
			        <div class="">
			        	<h2>{{item_display_name}} </h2>
			        	<p>{{item_name}}</p>

			        	<ul> 

			        		<li><strong>Barcode: </strong> #{{barcode}}</li>
			        		<li><strong>Categoty ID: </strong> {{category_id}}</li>
			        		<li><strong>Categoty Name: </strong> {{category_name}}</li>
			        		<li><strong>Item Name: </strong> {{item_name}}</li>
			        		<li><strong>Invoice No: </strong>{{invoice_no}}</li>
			        		<li><strong>GRN : </strong>{{grn}}</li>
			        		<li><strong>No of Items : </strong>{{items}}</li>
			        		
			        		
			        	</ul>
			        </div>
			      
			        <div class="clearfix"></div>
			  	</div> 
			</div>

			<div class="col-md-9">
				<div class="body"> 
					<div class="top_bar"> 

						<md-button ng-click="navigateTo()"  class="top"><i class="icon-list-with-dots" aria-hidden="true"></i> View Package List</md-button> 
						<md-button ng-click="navigateToPrintAll()"  class="top light_blue"><i class="icon-printer" aria-hidden="true"></i> Print All Barcode</md-button> 
												 
						<div class="clearfix"></div>
					</div>
					<table id="datatableData" datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstance" class="row-border hover table table-responsive table-bordered table-striped">
		  
					</table>


 

						 
				</div>
			</div>
		</div>
</div>


