<?php
//establish a connect with the databade
$conn = mysqli_connect('localhost','klinsheet_training','certification123','klinsheet_training');


$query = "select * from registration";
$result = mysqli_query($conn,$query);

$total = mysqli_num_rows($result);

echo '<h1>Total Registered Candidates: '.$total.'</h1>';


for($i=0; $i<$total; $i++)
{
	$row = mysqli_fetch_array($result);
	echo 'Firstname: '.$row['firstname'].'<br>';
	echo 'Lastname: '.$row['lastname'].'<br>';
	echo 'Email: '.$row['email'].'<br>';
	echo 'Phone: '.$row['phone'].'<br>';
	echo 'Message: '.$row['message'].'<br>';
	echo '<hr>';
}

?>
