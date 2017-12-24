
<div ng-controller="dashboardCtrl" class="page_inner {{animated_class}}">
	<div class="head">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

	 
	</div>
 
	<div class="body">
		
		<div class="row_ quick_summery">
			<div class="col-sm-3 iblock">
				<div class="iblock_inner purple"> 
					<h2>{{invoices}}</h2>
					<h3>Invoices Today</h3>
					<i class="icon-list"></i>
				</div>
			</div>
			<div class="col-sm-3 iblock">
				<div class="iblock_inner blue">
					<h2>{{items}}</h2>
					<h3>Total Items</h3>
					<i class="icon-car-battery"></i>
				</div>
			</div>
			<div class="col-sm-3 iblock">
				<div class="iblock_inner yellow"> 
					<h2>{{packages}}</h2>
					<h3>Packages Today</h3>
					<i class="icon-box"></i>
				</div>
			</div>
			<div class="col-sm-3 iblock">
				<div class="iblock_inner pink">
					<h2>{{suppliers}}</h2>
					<h3>Total Suppliers</h3>
					<i class="icon-truck"></i>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="row_ quick_summery">
			 
			<div class="block block1 col-md-7">
				<div class="block_inner">
					<div class="block_head">
						<h2>Last 5 Days Invoices</h2>
					</div>
					<div class="block_body">
						
						 <div id="chart"></div>
						
						<div class="clearfix"></div>
					</div>
				</div> 
			</div>

			<div class="block block1 col-md-5">
				<div class="block_inner">
					<div class="block_head">
						<h2>Recent Products</h2>
					</div>
					<div class="block_body">
						
						<div class="item" ng-repeat="grp in getRecentProducts" ng-if="getRecentProducts">
							<div class="item_img_container" style="background-image: url('{{grp.image_url}}')"></div>
							<div class="item_details">
								<ul>
									<li class="name">{{grp.item_display_name}}</li>
									<li class="category">{{grp.cat_name}}</li>
								</ul>
							</div>
						</div>

						<div class="item empty" ng-if="!getRecentProducts">
							<p>No products in inventory</p>
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div> 
			</div>

			<div class="clearfix"></div>
		</div> 
	 	
	</div>


</div>





