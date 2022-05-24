<?php
/********** CONNECT TO THE DATABASE **********/
date_default_timezone_set('America/New_York'); 
$servername="localhost";
$username="root";
$password= "root";
$connect=mysqli_connect($servername,$username,$password);
if(!$connect)  die("Error"); //else echo "connected";
/********** CREATE QUERY **********/
$sql_1 = "SELECT * FROM laundry_schedule.tenant   WHERE ApartmentNumber = '".$_REQUEST['ApartmentNumber']."' AND Password = '".$_REQUEST['Password']."' ";
$result_1 = mysqli_query($connect, $sql_1); 	// Send the query to the database
if (mysqli_num_rows($result_1) > 0) 			// If there are rows present
{		
		echo (new DateTime)->format(DATE_COOKIE);
		echo "<br>";
		$mydate = getdate(date("U"));
		//var_dump($mydate);
		$db_Reset1 = "SELECT * FROM laundry_schedule.schedule_reset ";
		$db_Reset2 = mysqli_query($connect, $db_Reset1); 
		$db_reset_val = mysqli_fetch_assoc($db_Reset2);
		//var_dump($db_reset_val);
		// only triggers when a user logs in so need multiple conditions
		if ($mydate["weekday"] == 'Monday')
		{
			// if its midnight exactly, reset the database
			if ($mydate["hours"] == 0 && $mydate["minutes"] == 0) 
			{
				// sql statement to reset "Day" and "TimeSlot" data from schedule table, make NULL
				$reset1 = "SELECT * FROM laundry_schedule.schedule ";
				$reset2 = mysqli_query($connect, $reset1); 
				$reset3 ="UPDATE laundry_schedule.schedule SET Day = NULL, TimeSlot = NULL ";
				$sendReset = mysqli_query($connect, $reset3);
				// sql to change false to true in laundry_schedule.schedule_reset table
				$db_Reset1 = "SELECT * FROM laundry_schedule.schedule_reset ";
				$db_Reset2 = mysqli_query($connect, $db_Reset1); 
				$db_Reset3 = "UPDATE laundry_schedule.schedule_reset SET Schedule_Reset = 1";
				$send_DB_Reset = mysqli_query($connect, $db_Reset3);
			}
			/*
			if user logs in in after midnight meaning past midnight by hours or minutes
			meaning above condition not true
			then reset the database only if it has not been reset yet
			*/
			else 
			{
				if ($db_reset_val ["Schedule_Reset"] == '0')
				{
					// sql statement to reset "Day" and "TimeSlot" data from schedule table, make NULL
					$reset1 = "SELECT * FROM laundry_schedule.schedule ";
					$reset2 = mysqli_query($connect, $reset1); 
					$reset3 ="UPDATE laundry_schedule.schedule SET Day = NULL, TimeSlot = NULL ";
					$sendReset = mysqli_query($connect, $reset3);
					// sql to change false to true in laundry_schedule.schedule_reset table
					$db_Reset1 = "SELECT * FROM laundry_schedule.schedule_reset ";
					$db_Reset2 = mysqli_query($connect, $db_Reset1); 
					$db_Reset3 = "UPDATE laundry_schedule.schedule_reset SET Schedule_Reset = 1";
					$send_DB_Reset = mysqli_query($connect, $db_Reset3);	
				}
	
			}
		}
		elseif ($mydate["weekday"] == 'Tuesday' || $mydate["weekday"] == 'Wednesday' || $mydate["weekday"] == 'Thursday' || $mydate["weekday"] == 'Friday' || $mydate["weekday"] == 'Saturday') // reset extra days incase no user logs in by Tuesday, Wednesday etc..
		{
			// in case no one logged in on Monday to reset the database
			if ($db_reset_val ["Schedule_Reset"] == '0')
			{
				// sql statement to reset "Day" and "TimeSlot" data from schedule table, make NULL
				$reset1 = "SELECT * FROM laundry_schedule.schedule ";
				$reset2 = mysqli_query($connect, $reset1); 
				$reset3 ="UPDATE laundry_schedule.schedule SET Day = NULL, TimeSlot = NULL ";
				$sendReset = mysqli_query($connect, $reset3);
				// sql to change false to true in laundry_schedule.schedule_reset table
				$db_Reset1 = "SELECT * FROM laundry_schedule.schedule_reset ";
				$db_Reset2 = mysqli_query($connect, $db_Reset1); 
				$db_Reset3 = "UPDATE laundry_schedule.schedule_reset SET Schedule_Reset = 1";
				$send_DB_Reset = mysqli_query($connect, $db_Reset3);	
			}
		}
		
		//if ($mydate["weekday"] == 'Sunday') // Assumes someone has logged in already and resetted the database by Sunday, resets to get ready for Monday
		else
		{
			// sql to change  to false in laundry_schedule.schedule_reset table
			$db_Reset1 = "SELECT * FROM laundry_schedule.schedule_reset ";
			$db_Reset2 = mysqli_query($connect, $db_Reset1); 
			$db_Reset3 = "UPDATE laundry_schedule.schedule_reset SET Schedule_Reset = 0";
			$send_DB_Reset = mysqli_query($connect, $db_Reset3);
		}
				
		
		$check = "SELECT Day FROM laundry_schedule.schedule
		WHERE ApartmentNumber = '". $_REQUEST['ApartmentNumber']."'";
		$check_result = mysqli_query($connect, $check); 
		$Day = mysqli_fetch_assoc($check_result);
		
		if ($Day ["Day"] == 'Sunday' || $Day ["Day"] == 'Monday' || $Day ["Day"] == 'Tuesday' || $Day ["Day"] == 'Wednesday' || $Day ["Day"] == 'Thursday' || $Day ["Day"] == 'Friday' || $Day ["Day"] == 'Saturday')
		{
			echo "<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><h1 style= 'color:red;font-size:50px;text-align:center;'>Welcome to your profile</h1>
			<table border='1' style='margin-left: auto;margin-right: auto;'>
			<caption style='text-align:left;font-size:25px;'> Your personal details</caption>
			<tr style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'>
			<th style='padding: 8px;text-align: center;'>First Name</th>
			<th style='padding: 8px;text-align: center;'>Last Name</th>
			<th style='padding: 8px;text-align: center;'>Apartment Number</th>
			<th style='padding: 8px;text-align: center;'>Email</th>
			<th style='padding: 8px;text-align: center;'>Password</th>
			</tr>";
			while($row = mysqli_fetch_assoc($result_1)) 									// fetch next row
			{ 																			// display the data
				echo "<tr style='text-align:left;padding:8px;'>
				<td style='padding: 8px;text-align: center;'>".$row["FirstName"]." </td>
				<td style='padding: 8px;text-align: center;'>".$row["LastName"]." </td>
				<td style='padding: 8px;text-align: center;'>". $row["ApartmentNumber"]."</td>
				<td style='padding: 8px;text-align: center;'>". $row["Email"]."</td>
				<td style='padding: 8px;text-align: center;'>". $row["Password"]."</td>
				</tr>"; // output data of that row
			}
			echo "</table>";
			
			$sql_2 = "SELECT * FROM laundry_schedule.schedule   WHERE ApartmentNumber = '".$_REQUEST['ApartmentNumber']."'  ";
			$result_2 = mysqli_query($connect, $sql_2); 	// Send the query to the database
			if (mysqli_num_rows($result_2) > 0) 			// If there are rows present
			{
					echo "<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
					<table border='1'  style='margin-left: auto;margin-right: auto;'>
					<caption style='text-align:left;font-size:25px;'> Your reservation status</caption>
					<tr style='padding: 8px;text-align: center;background-color:coral;'>
					<td style='padding: 8px;text-align: center;'>Apartment Number</td>
					<td style='padding: 8px;text-align: center;'>Day</td>
					<td style='padding: 8px;text-align: center;'>Time Slot</td>
					</tr>";
					while($row = mysqli_fetch_assoc($result_2)) 									// fetch next row
					{ 																			// display the data
						echo "<tr style='padding: 8px;text-align: left;'>
						<td style='padding: 8px;text-align: center;'>". $row["ApartmentNumber"]."</td>
						<td style='padding: 8px;text-align: center;'>". $row["Day"]."</td>
						<td style='padding: 8px;text-align: center;'>". $row["TimeSlot"]."</td>
						</tr>"; // output data of that row
					}
					echo "</table>";
			}
		}
		else
		{
			echo "<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><h1 style= 'color:red;font-size:50px;text-align:center;'>Welcome to your profile</h1>
			<table border='1' style='margin-left: auto;margin-right: auto;'>
			<caption style='text-align:left;font-size:25px;'> Your personal details</caption>
			<tr style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'>
			<th style='padding: 8px;text-align: center;'>First Name</th>
			<th style='padding: 8px;text-align: center;'>Last Name</th>
			<th style='padding: 8px;text-align: center;'>Apartment Number</th>
			<th style='padding: 8px;text-align: center;'>Email</th>
			<th style='padding: 8px;text-align: center;'>Password</th>
			</tr>";
			while($row = mysqli_fetch_assoc($result_1)) 									// fetch next row
			{ 																			// display the data
				echo "<tr style='text-align:left;padding:8px;'>
				<td style='padding: 8px;text-align: center;'>".$row["FirstName"]." </td>
				<td style='padding: 8px;text-align: center;'>".$row["LastName"]." </td>
				<td style='padding: 8px;text-align: center;'>". $row["ApartmentNumber"]."</td>
				<td style='padding: 8px;text-align: center;'>". $row["Email"]."</td>
				<td style='padding: 8px;text-align: center;'>". $row["Password"]."</td>
				</tr>"; // output data of that row
			}
			echo "</table>";
			
			$sql_2 = "SELECT * FROM laundry_schedule.schedule   WHERE ApartmentNumber = '".$_REQUEST['ApartmentNumber']."'  ";
			$result_2 = mysqli_query($connect, $sql_2); 	// Send the query to the database
			if (mysqli_num_rows($result_2) > 0) 			// If there are rows present
			{
					echo "<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
					<table border='1'  style='margin-left: auto;margin-right: auto;'>
					<caption style='text-align:left;font-size:25px;'> Your reservation status</caption>
					<tr style='padding: 8px;text-align: center;background-color:coral;'>
					<td style='padding: 8px;text-align: center;'>Apartment Number</td>
					<td style='padding: 8px;text-align: center;'>Day</td>
					<td style='padding: 8px;text-align: center;'>Time Slot</td>
					</tr>";
					while($row = mysqli_fetch_assoc($result_2)) 									// fetch next row
					{ 																			// display the data
						echo "<tr style='padding: 8px;text-align: left;'>
						<td style='padding: 8px;text-align: center;'>". $row["ApartmentNumber"]."</td>
						<td style='padding: 8px;text-align: center;'>". $row["Day"]."</td>
						<td style='padding: 8px;text-align: center;'>". $row["TimeSlot"]."</td>
						</tr>"; // output data of that row
					}
					echo "</table>";
			}
			session_start();
			$_SESSION["ApartmentNumber"] = $_REQUEST['ApartmentNumber'];
			echo
				"<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
				<table border='1'  style='margin-left: auto;margin-right: auto;'>
				
					<form action='Schedule.php' method ='post'>
				<tr><th colspan='2'>Do you want to set a schedule?</th></tr>
				<tr><td> Yes,I would love to. </td><td><input type='submit' value='Schedule'</td></tr>
				<tr><td> No,I am good for this week. </td><td> Have a good day!</td></tr>
				</form></table>";
			
		}
		
}
else 
	echo "<p style='text-align:center;'>Invalid Apartment entered or Wrong Password!</p><br>
            <a href=index.html> back to login</a>";

	
?>