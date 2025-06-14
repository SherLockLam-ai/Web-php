<?php
include("layout.php");
include("config.php");
include('link_datatable.php');

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

if($_SESSION['type']=='admin'){
	include("menu_admin_2.php");
}else{
	include("menu_customer.php");
}
?>


<script>
	$(document).ready(function() {
		var dataTable = $('#order_customer_cancelled').DataTable( {
			"processing": true,
			"serverSide": true,
			"ajax":{
				url :"data_order_customer_cancelled.php", // json datasource
				type: "post",  // method  , by default get
				
				error: function(){  // error handling
					$(".order_customer_cancelled-error").html("");
					$("#order_customer_cancelled").append('<tbody class="order_customer_cancelled-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#order_customer_cancelled_processing").css("display","none");
					
				}
			},
			
		} );
		
		$("#order_customer_cancelled_filter").css("display","none");  // hiding global search box
		$('.search-input-text').on( 'keyup', function () {   // for text boxes
			var i =$(this).attr('data-column');  // getting column index
			var v =$(this).val();  // getting search input value
			dataTable.columns(i).search(v).draw();
		} );
		


		$("#order_customer_cancelled").on("click", "td button", function(e) {
			// nothin to do here
		});

		
		
		
	} );
</script>

		
<?php
	//include('link_bootstrap.php'); 
?>
		
		
<div class="container">
		
	<div style="text-align: center"><h3>Đơn hàng đã hủy</h3></div>
	<table id="order_customer_cancelled" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Tên sản phẩm</th>
				<th>Ngày đặt hàng</th>
				<th>Số lượng</th>
				
			</tr>
		</thead>
		<thead>
			<tr>
				<td><input type="text" data-column="0"  class="search-input-text"></td>
				<td><input type="text" data-column="1"  class="search-input-text"></td>
				<td><input type="text" data-column="2"  class="search-input-text"></td>
				<td><input type="text" data-column="3"  class="search-input-text"></td>
				
			</tr>
		</thead>
	</table>
	<p><br><br><br><br></p>
</div>

<?php include('footer.php')?>