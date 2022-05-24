<?php
	$servername="localhost";
	$username="root";
	$password= "root";
	$connect=mysqli_connect($servername,$username,$password);
	if(!$connect)  die("Error"); //else echo "connected";
		
		$search1 = "SELECT Day,TimeSlot FROM laundry_schedule.schedule 
		WHERE Day = '". $_REQUEST['Day']."' AND TimeSlot = '".$_REQUEST['TimeSlot']."'";
		$searchResults = mysqli_query($connect, $search1);
		if (mysqli_num_rows($searchResults) > 0) 			// If there are rows present
		{
			
			echo
			"<p style='text-align:center;font-size:25px;color:red;'>Sorry that timeslot is already taken that day.</p><br>
			<p style='text-align:center;font-size:20px;color:red;'> Please choose a different time that is not taken.</p> <br>";
			$sql_1 = "SELECT Day,TimeSlot FROM laundry_schedule.schedule ";
			$result_1 = mysqli_query($connect, $sql_1); 	// Send the query to the database
			if (mysqli_num_rows($result_1) > 0) 			// If there are rows present
			{
					echo "<h3>Slots that are already taken</h3><table border='1'><tr><td>Day</td><td>Time Slot</td></tr>";
					while($row = mysqli_fetch_assoc($result_1)) 									// fetch next row
					{ 																			// display the data
						echo "<tr> <td>". $row["Day"]."</td><td>". $row["TimeSlot"]."</td></tr>"; // output data of that row
					}
					echo "</table>";
			}
			echo
			"<div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
			<h3 style='font-size:35px;text-align:center;'>Confirm your reservation</h3>
			<table border='1' style='margin-left: auto;margin-right: auto;'><form action='Confirmation.php' method ='post'>
			<caption style='text-align:center;font-size:25px;'>Select your weekly slot</caption>
			
			 <tr style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'>
			 <td style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'> <label for='Day'>Choose the day you want to do your laundry: </label>
				<select name='Day' id='Day'>
					<option value='Sunday'>Sunday</option>
					<option value='Monday'>Monday</option>
					<option value='Tuesday'>Tuesday</option>
					<option value='Wednesday'>Wednesday</option>
					<option value='Thursday'>Thursday</option>
					<option value='Friday'>Friday</option>
					<option value='Saturday'>Saturday</option>
				</select>
			</td></tr>
			<tr style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'>
			<td style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'> 
			<label for='TimeSlot'>Choose the time range you want to do your laundry: </label>
				<select name='TimeSlot' id='TimeSlot'>
					<option value='12am-3am'>12am-3am</option>
					<option value='3am-6am'>3am-6am</option>
					<option value='6am-9am'>6am-9am</option>
					<option value='9am-12pm'>9am-12pm</option>
					<option value='12pm-3-pm'>12pm-3pm</option>
					<option value='3pm-6pm'>3pm-6pm</option>
					<option value='6pm-9pm'>6pm-9pm</option>
					<option value='9pm-12am'>9pm-12am</option>
				</select>
		  </td></tr>
		  <tr colspan='2'><td style='text-align:center;'><input type='submit' value='Confirm my reservation'></td></tr>
		  </table>";
		}
		else
		{
			session_start();
			
			$sql = 
			"UPDATE laundry_schedule.schedule SET
			Day = '".$_REQUEST['Day']."',
			TimeSlot = '".$_REQUEST['TimeSlot']."'
			WHERE ApartmentNumber = '".$_SESSION ['ApartmentNumber']."' ";
			/* "INSERT INTO laundry_schedule.schedule (Day, TimeSlot) 
			VALUES ('".$_REQUEST['Day']."','".$_REQUEST['TimeSlot']."')"; */
			$result = mysqli_query($connect, $sql); 	// Send the query to the database

			if($result)
				echo "TENANT INSERTED ";
			else
				//echo "TENANT NOT INSERTED";
				echo "TENANT NOT INSERTED:".mysqli_error($connect);
		}
		
			
			
?>