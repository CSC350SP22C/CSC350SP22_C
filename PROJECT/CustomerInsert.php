<?php
	$servername="localhost";
	$username="root";
	$password= "root";
	$connect=mysqli_connect($servername,$username,$password);
	if(!$connect)  die("Error"); //else echo "connected";
		
		$sql_1 = 
		"INSERT INTO laundry_schedule.tenant (ApartmentNumber, FirstName, LastName, Email, Password) 
		VALUES ('".$_REQUEST['ApartmentNumber']."','".$_REQUEST['FirstName']."','".$_REQUEST['LastName']."','".$_REQUEST['Email']."','".$_REQUEST['Password']."')";
		$result_1 = mysqli_query($connect, $sql_1); 	// Send the query to the database

		/*
		if($result_1)
			echo "TENANT INSERTED AND ";
		else
			//echo "TENANT NOT INSERTED";
			echo "TENANT NOT INSERTED:".mysqli_error($connect);
		*/	
		$sql_2 = 
		"INSERT INTO laundry_schedule.schedule (ApartmentNumber) 
		VALUES ('".$_REQUEST['ApartmentNumber']."')";
		$result_2 = mysqli_query($connect, $sql_2); 	// Send the query to the database

		if($result_2)
			echo "<p style='text-align:center;'>Registration Successful</p><br>
            <a href=index.html> back to login</a>";
		else
			//echo "TENANT NOT INSERTED";
			//echo "APTNUM NOT INSERTED:".mysqli_error($connect);
			echo "<p style='text-align:center;'>Apartment number is already registered</p><br>
            <a href=index.html> back to login</a>";
?>
