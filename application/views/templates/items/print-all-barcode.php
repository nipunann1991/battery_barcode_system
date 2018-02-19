<div ng-controller="printAllBarcode" class="page_inner {{animated_class}}">
	<!-- <div class="loader_ {{loader_class}}"></div> -->
	 <div class="col-md-12 padding0">
	<md-button class="btn btn_add noPrint" onclick="javascript:window.print()"><i class="icon-printer print" aria-hidden="true"></i>&nbsp; Print Barcode</md-button> <br/> 

	<svg class="barcode" jsbarcode-value="{{pkg_bcode}}" jsbarcode-textmargin="0" jsbarcode-fontSize="14" jsbarcode-height="30" jsbarcode-width="2" style="display: block; margin: auto; margin-bottom: 15px;"></svg>  

	<div class="a"></div>
	 


</div>


 
</div>