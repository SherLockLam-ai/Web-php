<?php 
include("layout.php");
include("config.php");
include('link_bootstrap.php');
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Quản lý đơn hàng</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="product.php">Đặt hàng</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Đơn hàng của tôi <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="order_customer_pending.php">Đang xử lý</a></li>
            <li><a href="order_customer_processing.php">Đang giao</a></li>
            <li><a href="order_customer_delivered.php">Đã giao</a></li>
            <li><a href="order_customer_cancelled.php">Đã hủy</a></li>
          </ul>
        </li>
        <li><a href="customer_profile.php">Thông tin tài khoản</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="destroy.php">Đăng xuất <?php echo"(".$_SESSION['username'].")";?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>