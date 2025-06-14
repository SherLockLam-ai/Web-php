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
	//echo "<h2>Hello Customer. This is your profile page. Its under construction</h2>";
}

// collect customer information from DB
$stmt = $conn->prepare("select * from customer where user_id=?");
$stmt->bindParam(1, $_SESSION['id']);
$result = $stmt->execute();
$row = $stmt->fetch();
?>

<script>
	$(document).ready(function() {

		// ********* Code for date picker *****************
		// note: Modal enforces to focus on itself instead of datepicker thats why 
		// this code is needed to resolve month and year dropdown issue in Datepicker 
		// when you put it in a modal 
		$.fn.modal.Constructor.prototype.enforceFocus = function () {
		$(document)
		  .off('focusin.bs.modal') // guard against infinite focus loop
		  .on('focusin.bs.modal', $.proxy(function (e) {
		    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
		      this.$element.focus()
		    }
		  }, this))
		}
		
		$( function() {
		    $( "#modal_user_date_of_birth" ).datepicker({
		    	beforeShow: function(input, inst) {
			        $(document).off('focusin.bs.modal');
			    },
			    onClose:function(){
			        $(document).on('focusin.bs.modal');
			    },
		    	changeMonth: true,
		    	changeYear: true,
		    	yearRange: "1901:2099",
		    	dateFormat: 'yy-mm-dd',
		    });
		});
		// ********* End of Date Picker **********************
		
		$("#button_edit_profile").on("click", function(e) {
			//alert('hi');
			var user_id = $('#user_id').val();
			var name = $('#name').text();
			var sex = $('#sex').text();
			var date_of_birth = $('#date_of_birth').text();
			var location = $('#location').text();
			var phone = $('#phone').text();
			var email = $('#email').text();
			//alert(user_id);
			$('#modal_user_id').val(user_id);
			$('#modal_user_name').val(name);
			$('#modal_user_sex').val(sex);
			$('#modal_user_date_of_birth').val(date_of_birth);
			$('#modal_user_location').val(location);
			$('#modal_user_phone').val(phone);
			$('#modal_user_email').val(email);
			$('#modal_profile_update').modal('show');
			
		});

		
		$("#profile_edit_confirm").on("click", function(e) {
			
			var user_id = $('#modal_user_id').val();
			var name = $('#modal_user_name').val();
			var sex = $('#modal_user_sex').val();
			var date_of_birth = $('#modal_user_date_of_birth').val();
			var location = $('#modal_user_location').val();
			var phone = $('#modal_user_phone').val();
			var email = $('#modal_user_email').val();

			
			// email validation 
			function validateEmail(email) {
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
				if (filter.test(email)) {
					return true;
				}else{
					return false;
				}
			}
			
			if ($.trim(email).length == 0) {
				alert('Please enter valid email location');
				e.preventDefault();
			}else{
				if (!validateEmail(email)) {
					alert('Invalid Email location');
					e.preventDefault();
				}else{
					// sending data to server 
					$.ajax({
						method: "POST",
					    url : "update_customer_profile.php",
					    data : {
					    	user_id:user_id,
					    	name:name,
					    	sex:sex,
					    	date_of_birth:date_of_birth,
					    	location:location,
					    	phone:phone,
					    	email:email
					    },
					    dataType: 'html',
					    success: function(data, textStatus, jqXHR)
					    {
					        console.log(data);
					        if(data=='valid'){
					        	$('#flash-customer-update').show();
					        }else{
					        	$('#flash-error').show();
					        }
					        
					        setTimeout(function () {
						        $('#flash-customer-update').hide();
						        $('#flash-error').hide();
						        window.location.reload();
						    }, 3000);
					    },
					    error: function (jqXHR, textStatus, errorThrown)
					    {
					 		$('#flash-error').show();
					        setTimeout(function () {
						        //window.location.reload();
						        $('#flash-error').hide();
						    }, 3000);
					    }
					});
					
				}
			}
		});
		
	} );
</script>

<div class="container">

	<div class="alert alert-danger" id="flash-error" hidden>
		<strong>Oops.. There was an error! Thử lại với dữ liệu hợp lệ.</strong>
	</div>
	<div class="alert alert-success" id="flash-customer-update" hidden>
	    <strong>Cập nhật thông tin thành công!</strong>
	</div>

	<div id="modal_profile_update" class="modal fade" role="dialog">
	    <div class="modal-dialog">

		    <!-- Modal for updating Customer profile-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Update Personal Information</h4>
		      </div>
		      
		      <div class="modal-body">
		        <p>Please provide correct input.</p>
		        <form action=''>
		        	<div class="form-group" hidden>
				    	<label>User Id:</label>
				    	<input disabled type="text" class="form-control" id="modal_user_id" name="modal_user_id">
				    </div>
		        	<div class="form-group">
				    	<label>Tên của bạn</label>
				    	<input type="text" class="form-control" id="modal_user_name" name="modal_user_name">
				    </div>
				    <div class="form-group">
				    	<label>Giới tính</label>
				    	<select class="form-control" id='modal_user_sex'>
							<option value="M">Nam (M)</option>
							<option value="F">Nữ (F)</option>
						</select>
				    </div>
				    <div class="form-group">
				    	<label>Ngày sinh</label>
				    	<input type="text" class="form-control" id="modal_user_date_of_birth" name="modal_user_date_of_birth">
				    </div>
				    <div class="form-group">
				    	<label>Địa chỉ</label>
				    	<textarea class="form-control" id="modal_user_location" name="modal_user_location"></textarea>
				    </div>
				    <div class="form-group">
				    	<label>SĐT</label>
				    	<input type="text" class="form-control" id="modal_user_phone" name="modal_user_phone">
				    </div>
				    <div class="form-group">
				    	<label>Email</label>
				    	<input type="text" class="form-control" id="modal_user_email" name="modal_user_email">
				    </div>
		        </form>
		      </div>

		      <div class="modal-footer">
		      	<button type="button" id="profile_edit_confirm" class="btn btn-success" data-dismiss="modal">Cập nhật</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
		      </div>
		    </div>

	    </div>
	</div>


	<div class="row">
		<div class="panel panel-default">
		    <div class="panel-heading">
		    	<h3 class="panel-title">Thông tin cá nhân</h3>
		    </div>
		    <div class="panel-body">
		    	 <!-- List group -->
			    <ul class="list-group col-md-6">
			    	<input type="hidden" id="user_id" value="<?php echo $_SESSION['id'];?>">
			    	</input>
				    <li class="list-group-item"><strong>Tên:</strong>
				    	<span id='name'><?php echo $row['name'];?>	</span>
				    </li>
				    <li class="list-group-item" ><strong>Giới tính:</strong>
				    	<span id='sex'><?php echo $row['sex'];?></span>	
				    </li>
				    <li class="list-group-item"><strong>Ngày sinh:</strong>
				    	<span id='date_of_birth'><?php echo $row['date_of_birth'];?></span>
				    </li>
				    <li class="list-group-item"><strong>Địa chỉ:</strong>
				    	<span id='location'><?php echo $row['location'];?></span>
				    </li>
				    <li class="list-group-item"><strong>Điện thoại:</strong>
				    	<span id='phone'><?php echo $row['phone'];?></span>
				    </li>
				    <li class="list-group-item"><strong>Email:</strong>
				    	<span id='email'><?php echo $row['email'];?></span>
				    </li>
				    <br>
				    <button class='btn btn-info' id='button_edit_profile'>Sửa thông tin</button>
			    </ul>

		    </div>
		    
		</div>
	</div>
</div>

<?php include('footer.php');?>