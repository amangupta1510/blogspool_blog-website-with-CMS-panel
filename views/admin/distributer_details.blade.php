@extends('layout/vendor_dashboard')
@section('page')
<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
	
		<h1 class="section-title" id="services"></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
		  <li class="active">Distributer Details</li>
		</ol><!--breadcrum end-->
	
		<div class="section" id="tbody"> 
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<div class="lead"><a>DISTRIBUTER DETAILS<a>&nbsp;<a class="export_excel btn btn-primary" style="padding: 6px 6px;font-size: 13px;">Download Excel <i class="fas fa-download"></i></a>
								&nbsp;<a style="font-size: 13px;"><input type="radio" name="radio" id="radio_all" value="all"><label for="radio_all">&nbsp;All Data&nbsp;</label></a>&nbsp;<a style="font-size: 13px;"><input type="radio" name="radio" id="radio_month" value="month"><label for="radio_month">&nbsp;Last 6 Months&nbsp;</label></a>&nbsp;<a style="font-size: 13px;"><input type="radio" name="radio" id="radio_date" value="date"><label for="radio_date">&nbsp;By Date </label></a></div>
						</div>

					</div>
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div id="date_div" style="font-size: 12px;display: none;"><label for="start">Start Date&nbsp;</label><input type="date" id="start" name="starting" required=""><label for="end">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;End Date&nbsp;</label><input type="date" id="end" name="ending" required="">&nbsp;&nbsp;&nbsp;<a class=" btn btn-danger" onclick="date()" style="padding: 6px 4px;font-size: 13px;">View</a></div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div id="total" style="font-size: 12px;display: none;margin-top: 5px;margin-bottom: 5px;"><a class="amount btn btn-info" style="font-size: 12px;font-weight: 500"></a>&nbsp;&nbsp;&nbsp;<a class="completed btn btn-success"style="font-size: 12px;font-weight: 500"></a>&nbsp;&nbsp;&nbsp;<a class="due btn btn-danger" style="font-size: 12px;font-weight: 500"></a></div>
				</div>

					<div class="table-responsive" > 
						<table cellspacing="0" cellpadding="0" class="table pmd-table table-hover" id="table-propeller">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Order&nbsp;no.</th>
									<th>Lot&nbsp;no.</th>
									<th>Product&nbsp;name</th>
									<th>Distributer</th>
									<th>Quantity</th>
									<th>Selling&nbsp;&nbsp;Time</th>
									<th>MRP</th>
									<th>Discount</th>
									<th>Extra&nbsp;Discount</th>
									<th>Total&nbsp;Price</th>
									<th>Method</th>
									<th>Payment</th>
								
								</tr>
							</thead>
							<tbody id="table">
					
							</tbody>

						</table>

					</div>
				</div>
			</div> <!-- section content end -->  
		</div>
			
	</div><!-- tab end -->

</div><!--end content area-->
@endsection
@section('js')
<script type="text/javascript">
	function date(){
	var start = $('#start').val();
	var end = $('#end').val();
	if(start!=''&&end!=''){
   	var img ="{{ route('admin-distributer_details_load',['id'=>':id','type'=>':page','start'=>':start','end'=>':end']) }}";
    var img = img.replace('%3Apage','date');
    var img = img.replace('%3Aid',"{{app('request')->input('id')}}")
    var img = img.replace('&amp;','&');
    var img = img.replace('%3Astart',start);
    var img = img.replace('%3Aend',end);
    var img = img.replace('&amp;','&');
    var img = img.replace('&amp;','&');
    $.get(img,function(data){
          $('#table').empty().html('');
          var no = 0; var completed = 0; var due = 0; var amount=0;
          for(var i=0; i<data.length;i++){
          	no++;
              $('#table').append('<tr><td>'+no+'</td><td>'+data[i].order_no+'</td><td>'+data[i].lot_no+'</td><td>'+data[i].p_name+'</td><td>'+data[i].d_name+'</td><td>'+data[i].total_unit+'&nbsp;units</td><td class="time">'+data[i].selling_time+'</td><td>₹&nbsp;'+data[i].total_mrp+'</td><td>₹&nbsp;'+data[i].total_discount+'</td><td>₹&nbsp;'+data[i].special_discount+'</td><td>₹&nbsp;'+data[i].total_price+'</td><td>'+data[i].payment_method+'</td><td>'+data[i].payment_status+'</td></tr>');
              amount = parseFloat(amount)+parseFloat(data[i].total_price);
           if(data[i].payment_status=='Completed'){completed=parseFloat(completed)+parseFloat(data[i].total_price);}
           else{due=parseFloat(due)+parseFloat(data[i].total_price);}
          }
          $('#total').show();
          $('.amount').text('Total Amount: ₹'+amount);
          $('.completed').text('Completed Amount: ₹'+completed);
          $('.due').text('Pending Amount: ₹'+due);
          $('.time').each(function () {
          var img = $(this).text();
          var img = img.replace('T','&nbsp;');
          $(this).html(img);
          $('#table').show();
       });
    })
	}else{
		alert("Please Fill Start Date and End Date...");
	}
}
$(document).ready(function (){

$('input[type="radio"]').on('change', function(e) {
   if($(this).val()=='all'){
   	$('#date_div').hide();
   	var img ="{{ route('admin-distributer_details_load',['id'=>':id','type'=>':page']) }}";
    var img = img.replace('%3Apage','all');
    var img = img.replace('%3Aid',"{{app('request')->input('id')}}")
    var img = img.replace('&amp;','&');
    $.get(img,function(data){
          $('#table').empty().html('');
          var no = 0; var completed = 0; var due = 0; var amount=0;
          for(var i=0; i<data.length;i++){
          	no++;
              $('#table').append('<tr><td>'+no+'</td><td>'+data[i].order_no+'</td><td>'+data[i].lot_no+'</td><td>'+data[i].p_name+'</td><td>'+data[i].d_name+'</td><td>'+data[i].total_unit+'&nbsp;units</td><td class="time">'+data[i].selling_time+'</td><td>₹&nbsp;'+data[i].total_mrp+'</td><td>₹&nbsp;'+data[i].total_discount+'</td><td>₹&nbsp;'+data[i].special_discount+'</td><td>₹&nbsp;'+data[i].total_price+'</td><td>'+data[i].payment_method+'</td><td>'+data[i].payment_status+'</td></tr>');
              amount = parseFloat(amount)+parseFloat(data[i].total_price);
           if(data[i].payment_status=='Completed'){completed=parseFloat(completed)+parseFloat(data[i].total_price);}
           else{due=parseFloat(due)+parseFloat(data[i].total_price);}
          }
          $('#total').show();
          $('.amount').text('Total Amount: ₹'+amount);
          $('.completed').text('Completed Amount: ₹'+completed);
          $('.due').text('Pending Amount: ₹'+due);
          $('.time').each(function () {
          var img = $(this).text();
          var img = img.replace('T','&nbsp;');
          $(this).html(img);
          $('#table').show();
       });
    })
   }
   else if($(this).val()=='month'){
   		$('#date_div').hide();
   	var img ="{{ route('admin-distributer_details_load',['id'=>':id','type'=>':page']) }}";
    var img = img.replace('%3Apage','month');
    var img = img.replace('%3Aid',"{{app('request')->input('id')}}")
    var img = img.replace('&amp;','&');
    $.get(img,function(data){
          $('#table').empty().html('');
          var no = 0; var completed = 0; var due = 0; var amount=0;
          for(var i=0; i<data.length;i++){
          	no++;
              $('#table').append('<tr><td>'+no+'</td><td>'+data[i].order_no+'</td><td>'+data[i].lot_no+'</td><td>'+data[i].p_name+'</td><td>'+data[i].d_name+'</td><td>'+data[i].total_unit+'&nbsp;units</td><td class="time">'+data[i].selling_time+'</td><td>₹&nbsp;'+data[i].total_mrp+'</td><td>₹&nbsp;'+data[i].total_discount+'</td><td>₹&nbsp;'+data[i].special_discount+'</td><td>₹&nbsp;'+data[i].total_price+'</td><td>'+data[i].payment_method+'</td><td>'+data[i].payment_status+'</td></tr>');
              amount = parseFloat(amount)+parseFloat(data[i].total_price);
           if(data[i].payment_status=='Completed'){completed=parseFloat(completed)+parseFloat(data[i].total_price);}
           else{due=parseFloat(due)+parseFloat(data[i].total_price);}
          }
          $('#total').show();
          $('.amount').text('Total Amount: ₹'+amount);
          $('.completed').text('Completed Amount: ₹'+completed);
          $('.due').text('Pending Amount: ₹'+due);
          $('.time').each(function () {
          var img = $(this).text();
          var img = img.replace('T','&nbsp;');
          $(this).html(img);
          $('#table').show();
       });
    })
   }
   else{
   	$('#date_div').show();
   	$('#total').hide();
   	$('#table').hide();
   }
});
$('.export_excel').on("click",function(){
var val = $('input[name="radio"]:checked').val();
if(val=='all'){
	var img ="{{ route('admin-export_distributer_details',['id'=>':id','type'=>':page']) }}";
    var img = img.replace('%3Apage','all');
    var img = img.replace('%3Aid',"{{app('request')->input('id')}}")
    var img = img.replace('&amp;','&');
	window.location.href=img;
}else if(val=='month'){
	var img ="{{ route('admin-export_distributer_details',['id'=>':id','type'=>':page']) }}";
    var img = img.replace('%3Apage','month');
    var img = img.replace('%3Aid',"{{app('request')->input('id')}}")
    var img = img.replace('&amp;','&');
	window.location.href=img;
}
else if(val=='date'){
  var start = $('#start').val();
  var end = $('#end').val();
  if(start!=''&&end!=''){
    var img ="{{ route('admin-export_distributer_details',['id'=>':id','type'=>':page','start'=>':start','end'=>':end']) }}";
    var img = img.replace('%3Apage','date');
    var img = img.replace('%3Aid',"{{app('request')->input('id')}}")
    var img = img.replace('&amp;','&');
    var img = img.replace('%3Astart',$('#start').val());
    var img = img.replace('%3Aend',$('#end').val());
    var img = img.replace('&amp;','&');
    var img = img.replace('&amp;','&');
  window.location.href=img; 
}else{
  alert("Select Start Date and End Date First...");
}
}
else{
 alert("Please Select Atleast One Option..."); 
}
})
});
</script>
@endsection