<!DOCTYPE html>
<!-- Document Name: SettingFormPage_Inpput1.php -->
<html>
 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">  
	
<style type="text/css">
body {
background-color: rgb(205,236,250);
}

.container{ /* Used for Displaying Setting Form*/
	background-color: white;
	font-size: 25px;
	box-shadow: 5px 5px 10px 5px grey;
	padding: 50px 8px 20px 38px;
	width: 45%;
	height: 250px;
	margin-left: 15%;
	border-radius: 20px; 	
}
.droptemp{ /* Drop Down for the Temperature */

	background-color: RGB(253,253,190);
	width: 100%
	height: 5%
	font-size: 25px;
	border: 1px solid black;
	border-radius: 05px;
	padding: 6px 12px 6px 12px;
	margin: 2px 0px 4px 0px;
}
.dropknob{ /* Drop Down for the Knob */
	background-color: RGB(213,244,255);
	width: 100%
	height: 5%
	font-size: 25px;
	border: 1px solid black;
	border-radius: 05px;
	padding: 6px 12px 6px 12px;
	margin: 2px 0px 4px 0px;
}
.dropwin{ /* Drop Down for the Window */
	background-color: RGB(248, 200, 220);
	width: 100%
	height: 5%
	font-size: 25px;
	border: 1px solid black;
	border-radius: 05px;
	padding: 6px 12px 6px 12px;
	margin: 2px 0px 4px 0px;
}
.dropdoor{ /* Drop Down for the window */
	background-color: RGB(139,0,139);
	color: rgb(255,255,255);
	width: 100%
	height: 5%
	font-size: 25px;
	border: 1px solid black;
	border-radius: 05px;
	padding: 6px 12px 6px 12px;
	margin: 2px 0px 4px 0px;
}
.sub{ /*Used for the submit button in the Form Setting*/
	background-color: RGB(166,231,153);
	width: 100px;
	height: 45px;
	font-size: 20px;
	font-weight: bold;
	border: 2px solid black;
	border-radius: 12px;
	padding: 8px 12px 8px 12px;
	box-shadow: 5px 5px 5px rgba(0, 32, 96, 0.6);
	margin: 2px 0px 4px 0px;
	cursor: pointer;
	position: relative;
	top: 0;
	left: 0;
	transition: top ease 0.25s;
}
.sub:hover {
 	background-color: RGB(116,231,113);
	box-shadow: 6px 6px 6px rgba(0, 32, 96, 0.6);
	width: 101px;
	height: 51px;
	top: 2px;
	left: 5px;
  
}

.Title{
	 color: RGB(0,32,96);  
	 font-weight: bold;
	 position: relative;
	 background-color: white;
	 font-size: 42px;
	 line-height: 1.5;  
	 margin: 10;
	 text-align: center;
	 box-shadow: 10px 12px 12px rgba(0, 32, 96, 0.4);
} 


</style>

<title>Maguz Tech: Example of Form Retrieve settings</title>

</head>	
<body>

  
<br style="float:none">

  <div class="Title">Maguz Tech: Example of Form Retrieve settings</div>
  <br>
  <br>
  

<?php

// MySQL database connection parameters - YOU NEED TO CHANGE THIS VALUES AS APPROPRIATE
$servername = "localhost";
$dbname = "esp_data"; // Replace with your MySQL database name 
$username = "root";
$password = "";

// Create connection to MySQL Database
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// 1.1 Define the “text” SQL Statement to run to get latest SettingTable Values
$sql1 = "Select * from SettingTable where SettingTable.id = 1;";

// 1.2 Run SQL and and assign the query results to php variables (e.g: $SettingA) 
// Get Settings Row result and allocate to php variables - You can use CTR+H to search and replace the setting variable names I have used for other names
if ($conn->query($sql1) === TRUE) {
} else {
}
if ($result = $conn->query($sql1)) {
    while ($row = $result->fetch_assoc()) {
		$bed_door = $row["bed_door"];
    }
    $result->free();
}
$conn->close();
// 1.3 For Binary variables (settings) use logic to assign the other value to a second php variable (e.g.: if the Table current setting for $SettingA == “Yes” then $SettingA2 = “No”) 

	if ($bed_door == "Open") {$bed_door2 = "Closed";} else {$bed_door2 = "Open";}

?>

<script type="text/javascript">
    // 2.1 Assign JavaScript variables to all the php ($) Setting variables including any Arrays ($)
    // Since in this case all variables are text, need to use json_encode() as part of the code 
    var bed_door = <?php echo json_encode($bed_door); ?>; 
    var bed_door2 = <?php echo json_encode($bed_door2); ?>; 
    // Note for Number Variables we dont  need to use json enconde, e.g.: var NumVar = <?php echo json_encode($NumVar); ?>;
    
</script>



<div class="container">

<!-- 3.1 Assign the php page “name” where the Form will be submitted to (e.g.: “SettingFormPage_Sub.php”) -->
<form action="SettingFormPage_Sub1.php" method="post"> 

<!-- 3.2 Write code for each Setting and its option - The "name" is the POST variable that will be used to  comunicate with Sub page --> 
	Bedroom Door: <select name="bed_door" class="dropdoor" style="margin-left: 149px">
			  <option value="Same"><script>document.write(bed_door)</script></option> 
			  <option value="Other"><script>document.write(bed_door2)</script></option>
			  </Select>
			  <br>
			  <br>
<input type ="submit" class="sub">
</form>
 </div>

</body>
</html>
		  
		  
		  
		  	
