<?php
	$servername="localhost";
	$username="root";
	$password= "root";
	$connect=mysqli_connect($servername,$username,$password);
	if(!$connect)  die("Error"); //else echo "connected";
		$sql = 
		"INSERT INTO classproject.Animal(Animaltype, Habitat) 
		VALUES ('".$_REQUEST['type']."','".$_REQUEST['habitats']."')";
		$result = mysqli_query($connect, $sql); 	// Send the query to the database
		if($result)
			echo "ANIMAL INSERTED";
		else
			echo "ANIMAL NOT INSERTED";
?>
