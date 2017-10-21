
<div ng-controller="posAppCtrl" class="page_inner {{animated_class}}">
	<div class="head hide">
		<div class="top"> 
			<h2>{{title}}</h2>
	  		<span class="breadcrumb">{{breadcrumb}}</span>
	  		<div class="clearfix"></div>
		</div> 
	  	 

	 
	</div>
 
	<div class="body"> 
		<div class="row">
			
			<div class="col-md-6 purchase_items">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<input type="text" placeholder="Barcode" class="form-control" >
						</div>
					</div>
					
				</div>
				
				<div class="invoice">
					<div class="heading hide">
						<div class="col-md-4 title">Item</div>
						<div class="col-md-2 qty padding0">Qty</div>
						<div class="col-md-3 price">Price</div>
						<div class="col-md-3 total">Total</div>
					</div>
					<div class="content">

						<ul class="items_list">
							<li class="item">
								<div class="item_left">
									<span class="title">Munchee Chocolate Biscuit</span>
									<span class="barcode">#1465465400</span> <span class="unit_price">Rs. 50.00 x </span> <span class="qty">2</span>
								</div>
								<div class="item_right">
									<span class="total">100.00</span>
									<a href="#"> <i class="icon-rubbish-bin" aria-hidden="true"></i></a>
								</div>
							</li>

							<li class="item">
								<div class="item_left">
									<span class="title">Coconut Oil 1l</span>
									<span class="barcode">#5455465221</span> <span class="unit_price">Rs. 350.00 x </span> <span class="qty">1</span>
								</div>
								<div class="item_right">
									<span class="total">350.00</span>
									<a href="#"> <i class="icon-rubbish-bin" aria-hidden="true"></i></a>
								</div>
							</li>
	


						</ul>
						
					</div>
				</div> 

			</div>

			<div class="col-md-6 hide">
				
				<div class="pos_item" ng-repeat="gi in getItems">
					<div class="pos_item_img" style="background-image: url('{{gi.image_url}}');"></div>
					<div class="pos_item_details">
						<span class="title">{{gi.item_display_name}}</span>
						<span class="category">{{gi.cat_id}}</span>

					</div>
				</div>

			</div>

			<div class="clearfix"></div>
		</div>
	</div>	

</div>





