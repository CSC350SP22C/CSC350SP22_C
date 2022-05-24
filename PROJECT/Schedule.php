<?php
/********** CONNECT TO THE DATABASE **********/
$servername="localhost";
$username="root";
$password= "root";
$connect=mysqli_connect($servername,$username,$password);
if(!$connect)  die("Error"); //else echo "connected";
/********** CREATE QUERY **********/

session_start();

$sql_1 = "SELECT Day,TimeSlot FROM laundry_schedule.schedule ";
$result_1 = mysqli_query($connect, $sql_1); 	// Send the query to the database
if (mysqli_num_rows($result_1) > 0) 			// If there are rows present
{
		echo "<h3 style='text-align:center;'>Slots that are already taken</h3>
		<table border='1' style='margin-left: auto;margin-right: auto;'>
		<tr style='background-color:brown;color:white;'>
		<th style=' padding: 8px;text-align: left;border-bottom: 1px solid #ddd;'>Day</th>
		<th  padding: 8px;text-align: left;border-bottom: 1px solid #ddd;'>Time Slot</th>
		</tr>";
		while($row = mysqli_fetch_assoc($result_1)) 									// fetch next row
		{ 																			// display the data
			echo "<tr> 
			      <td style=' padding: 8px;text-align: left;border-bottom: 1px solid #ddd;'>". $row["Day"]."</td>
				  <td style=' padding: 8px;text-align: left;border-bottom: 1px solid #ddd;'>". $row["TimeSlot"]."</td>
				  </tr>"; // output data of that row
		}
		echo "</table>";
}
/********** CREATE QUERY **********/
// $sql_2 = "SELECT * FROM laundry_schedule.schedule   WHERE ApartmentNumber = '".$_REQUEST['ApartmentNumber']."'  ";
//$result_2 = mysqli_query($connect, $sql_2); 	// Send the query to the database
//if (mysqli_num_rows($result_2) > 0) 			// If there are rows present
//{
//session_start();
	//$_SESSION["ApartmentNumber"] = $_REQUEST['ApartmentNumber'];
    //$row = mysqli_fetch_assoc($result_2);
	echo
	"<hr><div>&nbsp;</div><div>&nbsp;</div><h3 style='font-size:35px;text-align:center;'>Confirm your reservation</h3>
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
   <td style='text-align:center;padding:8px;background-color:#04AA6D;color:white;'> <label for='TimeSlot'>Choose the time range you want to do your laundry: </label>
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
//}
//else
//{ 
 //echo "Invalid Email/Password" ;
//}	
?>