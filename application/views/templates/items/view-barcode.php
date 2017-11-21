
 


<div class="col-md-12 padding0">
	<md-button class="btn btn_add noPrint" onclick="javascript:window.print()"><i class="icon-printer print" aria-hidden="true"></i>&nbsp; Print Barcode</md-button> <br/>
	<svg class="barcode"></svg><svg class="barcode"></svg><svg class="barcode"></svg><svg class="barcode"></svg>
</div>



<script>   
 	
 	url = window.location.href;
	var barcode = url.substr(url.lastIndexOf('/') + 1);
	 

	JsBarcode(".barcode", barcode , {  
      width:2,
      height:30,
      fontSize: 14 
    });
</script>