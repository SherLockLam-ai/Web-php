<?php 
include('config.php');
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$date_of_birth = $_POST['date_of_birth'];
$location = $_POST['location'];
$phone = $_POST['phone'];
$email = $_POST['email'];

if($user_id && $name && $sex && $date_of_birth && $location && $phone && $email){
	$stmt = $conn->prepare("update customer set name=?, sex=?, date_of_birth=?, location=?, phone=?,
	email=? where user_id=?");
	$stmt->bindParam(1, $name);
	$stmt->bindParam(2, $sex);
	$stmt->bindParam(3, $date_of_birth);
	$stmt->bindParam(4, $location);
	$stmt->bindParam(5, $phone);
	$stmt->bindParam(6, $email);
	$stmt->bindParam(7, $user_id);
	if($stmt->execute()){
		echo "valid";
	}
}else 
	echo "invalid";
?>