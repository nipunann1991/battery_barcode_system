
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
					<h2>562</h2>
					<h3>Sales Today</h3>
					<i class="icon-shopping-basket"></i>
				</div>
			</div>
			<div class="col-sm-3 iblock">
				<div class="iblock_inner blue">
					<h2>{{products}}</h2>
					<h3>Total Products</h3>
					<i class="icon-shopping-basket"></i>
				</div>
			</div>
			<div class="col-sm-3 iblock">
				<div class="iblock_inner yellow"> 
					<h2>Rs. 15,365.00</h2>
					<h3>Today's Profit</h3>
					<i class="icon-shopping-basket"></i>
				</div>
			</div>
			<div class="col-sm-3 iblock">
				<div class="iblock_inner pink">
					<h2>{{supplier}}</h2>
					<h3>Total Suppliers</h3>
					<i class="icon-worker-loading-boxes"></i>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="row_ quick_summery">
			 
			<div class="block block1 col-md-7">
				<div class="block_inner">
					<div class="block_head">
						<h2>Monthly Sales</h2>
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
						
						<div class="item" ng-repeat="grp in getRecentProducts">
							<div class="item_img_container" style="background-image: url('{{grp.image_url}}')"></div>
							<div class="item_details">
								<ul>
									<li class="name">{{grp.item_display_name}}</li>
									<li class="category">{{grp.cat_name}}</li>
								</ul>
							</div>
						</div>
						
						<div class="clearfix"></div>
					</div>
				</div> 
			</div>

			<div class="clearfix"></div>
		</div> 
	 	
	</div>


</div>





