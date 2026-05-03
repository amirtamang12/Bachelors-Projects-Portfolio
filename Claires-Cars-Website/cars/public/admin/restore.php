<?php 
$conn = mysqli_connect('localhost','root','','cars');
$id = $_GET['id'];
$query = "UPDATE cars set archive = 0 WHERE id = '$id' ";
$result = mysqli_query($conn,$query);
if($result){
    header('location:cars.php');
}



?>