<?php
include("layout.php");
include("config.php");

session_start();
if(!isset($_SESSION['username'])){
	header('location: login.php');
}

if($_SESSION['type']=='admin'){
	include("menu_admin_2.php");
	//echo "<h2>Hello Admin</h2>";
}else{
	include("menu_customer.php");
	//echo "<h2>Hello Customer</h2>";
}

?>

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
		    	<h3 class="panel-title">Đơn hàng của tôi</h3>
		    </div>
		    <div class="panel-body">
		    	<div class="row col-md-12">
		    		<div class="alert alert-success" id="flash-success" hidden>
					    <strong>Đặt hàng thành công!</strong>
					</div>

					<p><br></p>
			    	<table class="table table-striped table-bordered">
					    <tr><thId</th><th>Tên sản phẩm</th><th>Ngày đặt hàng</th><th>Số lượng</th><th>Trạng thái</th><th>Tùy chỉnh</th></tr>
					    
					    <?php 
					    	$stmt = $conn->prepare("SELECT * FROM orders where user_id=?");
					    	$stmt->bindParam(1, $_SESSION['id']);    // id of customer
							$stmt->execute();
							$rows = $stmt->fetchAll();
							//print_r($row);
							foreach ($rows as $row) {
								//echo $row['price']."<br>";
						?>
								<tr>
									<td><?php echo $row['id'];?></td>
									<td>
										<?php 

											//echo $row['product_id'];
											$stmt_find_product_name = $conn->prepare("SELECT name FROM product where id=?");
											$stmt_find_product_name->bindParam(1, $row['product_id']);
											$stmt_find_product_name->execute();
											$row_product = $stmt_find_product_name->fetch();
											echo $row_product['name'];
										?>
									</td>
									<td><?php echo $row['date_of_order'];?></td>
									<td><?php echo $row['quantity'];?></td>
									<td><?php echo $row['status'];?></td>
									<?php 
										if($_SESSION['type']=='customer' && $row['status']=='pending'){
									?>
									<td><a href="#" class="btn btn-info product_order">Hủy đơn hàng</a></td>
									<?php 
										}elseif($_SESSION['type']=='admin'){
									?>
									<td>
										<a href="#" class="btn btn-warning product_edit">Cập nhật trạng thái</a>   
										<a href="#" class="btn btn-danger product_delete">Xóa đơn hàng</a>
									</td>
									<?php 
										}
									?>
								</tr>
						<?php
							}
					    ?>

					</table>

		    	</div>
		    </div>
		</div>
	</div>
</div>