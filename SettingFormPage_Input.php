<!DOCTYPE html>
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
		$cht_temp = $row["cht_temp"];
		$bed_knob = $row["bed_knob"];
    }
    $result->free();
}

// 1.3 For Binary variables (settings) use logic to assign the other value to a second php variable (e.g.: if the Table current setting for $SettingA == “Yes” then $SettingA2 = “No”) 

	if ($bed_door == "Open") {$bed_door2 = "Closed";} else {$bed_door2 = "Open";}

// 1.4 For variables (settings) that have a number of options: Could use Array list approach to define options and then exclude from the list the current setting
	// 1.4.1 Define the options available and load into Array list
	$Array_bed_knob = array("0","1","2","3","4","5","6"); // 7 Possible Options

	// 1.4.2 Find the Array Index for the current Settings for bed_knob
	$Index = array_search($bed_knob, $Array_bed_knob); 
	// 1.4.3 Remove the  option from Array
	unset($Array_bed_knob[$Index]);
	// 1.4.4 Re-index the array elements into New Array - This will be the array that will be used
	$Array_bed_knobF = array_values($Array_bed_knob);
	// If you want to display array on screen: var_dump($Array_bed_knobF);


?>

<script type="text/javascript">
    // 2.1 Assign JavaScript variables to all the php ($) Setting variables including any Arrays ($)
    // Since in this case all variables are text, need to use json_encode() as part of the code 
    var cht_temp = <?php echo json_encode($cht_temp); ?>; 
    var bed_knob = <?php echo json_encode($bed_knob); ?>; 
    var bed_door = <?php echo json_encode($bed_door); ?>; 
    var bed_door2 = <?php echo json_encode($bed_door2); ?>; 
    var Array_bed_knobF = <?php echo json_encode($Array_bed_knobF); ?>;
    // Note for Number Variables we dont  need to use json enconde, e.g.: var NumVar = <?php echo json_encode($NumVar); ?>;
    
</script>



<div class="container">

<!-- 3.1 Assign the php page “name” where the Form will be submitted to (e.g.: “SettingFormPage_Sub.php”) -->
<form action="SettingFormPage_Sub.php" method="post"> 

<!-- 3.2 Write code for each Setting and its option - The "name" is the POST variable that will be used to  comunicate with Sub page --> 
	Bedroom Door: <select name="bed_door" class="dropdoor" style="margin-left: 149px">
			  <option value="Same"><script>document.write(bed_door)</script></option>
			  <option value="Other"><script>document.write(bed_door2)</script></option>
			  </Select><br>
	Central Heating Temp Set: <select name="cht_temp" class="droptemp" style="margin-left: 57px"> 
			  <option value="Same"><script>document.write(cht_temp)</script></option>
			  <option value="23.0">23.0</option>
			  <option value="22.5">22.5</option>
			  <option value="22.0">22.0</option>
			  <option value="21.5">21.5</option>
			  <option value="21.0">21.0</option>
			  <option value="20.5">20.5</option>
			  <option value="20.0">20.0</option>
			  <option value="19.5">19.5</option>
			  <option value="19.0">19.0</option>
			  <option value="18.5">18.5</option>
			  </Select><br>
	Bedroom Radiator Knob: <select name="bed_knob" class="dropknob" style="margin-left: 87px">
			  <option value="Same"><script>document.write(bed_knob)</script></option>
			  <option value="0"><script>document.write(Array_bed_knobF[0])</script></option>
			  <option value="1"><script>document.write(Array_bed_knobF[1])</script></option>
			  <option value="2"><script>document.write(Array_bed_knobF[2])</script></option>
			  <option value="3"><script>document.write(Array_bed_knobF[3])</script></option>
			  <option value="4"><script>document.write(Array_bed_knobF[4])</script></option>
			  <option value="5"><script>document.write(Array_bed_knobF[5])</script></option>
			  </Select><br>
			  <br>
<input type ="submit" class="sub">
</form>

</body>
</html>
		  
		  
		  
		  	
