
<html>
<head>
    
          
<style type="text/css">
    body {
    background-color: rgb(205,236,250);
    }
    .boxLabel{ /* used for Updated Settings Message*/
    color: RGB(0,32,96);
    font-size: 34px;
    border:1px solid #000;
    background: RGB(213,244,255);
    margin: auto;
    padding: 2px 1px 1px 2px;
    margin: 5px;
    width: 600px;
    box-shadow: 10px 8px 10px 5px rgba(0, 32, 96, 0.8);
    border-radius: 15px;
    padding: 10px 5px 10px 5px; /*top padding ,right padding, bottom padding , and a left padding*/
    text-align: center;
    
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

    .mytextSub{ /* Specific Text for Form Submit*/
    color: RGB(0,32,96);
    font-size: 24px;
    font-weight: bold;
    background: rgba(255,255,255,0.1);
    border-radius: 3px;
    }
</style>

<meta charset="utf-8">
<title>Setting Form Update</title>
</head>	
<body>
  


<?php
// 4.1 For each POST variable recieved assign it to a php variable ($)
$cht_temp = $_POST['cht_temp'];
$bed_door = $_POST['bed_door'];
$bed_knob = $_POST['bed_knob'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//4.2 Define the “text” SQL Statement to run to get latest SettingTable Values
$sql1 = "Select * from SettingTable where SettingTable.id = 1;";

// 4.3 Run SQL and and assign the query results to php variables. The variables will be the same name plus an “O” in front (e.g: $OSettingA) to denote “current setting”.
if ($conn->query($sql1) === TRUE) {
} else {
}
// Get Current Setting Values and assign the query results to php variables
if ($result = $conn->query($sql1)) {
    while ($row = $result->fetch_assoc()) {
		$Ocht_temp = $row["cht_temp"];
		$Obed_door = $row["bed_door"];
		$Obed_knob = $row["bed_knob"];
    }
    $result->free();
}
if ($conn->query($sql1) === TRUE) {
} 


// 4.4 Apply logic test to each Setting variable to determine the value that will be loaded back into the table
    // TYPE A1 - Binary variables - replace  "Same" and "Other" with the appropriate values
    if ($bed_door == "Same") {$bed_door = $Obed_door;} else { if ($Obed_door == "Open") {$bed_door = "Closed";} else {$bed_door = "Open";} } ;
    
    // TYPE B1 - Non Binary variables - Non Array option
    if ($cht_temp == "Same") {$cht_temp = $Ocht_temp;};

    // TYPE B2 - Non Binary Variables - Array Option
	    // Define the options available and load into Array list
	    if ($bed_knob == "Same") {$bed_knob = $Obed_knob;} else 

		{$Array_bed_knob = array("0","1","2","3","4","5","6"); // 7 Possible Options
		// Find the Array Index for the current Settings for bed_knob
		$Index = array_search($Obed_knob, $Array_bed_knob); 
		// Remove the  option from Array
		unset($Array_bed_knob[$Index]);
		// Re-index the array elements into New Array - This will be the array that will be used
		$Array_bed_knobF = array_values($Array_bed_knob);
		$bed_knob = $Array_bed_knobF[intval($bed_knob)];};



// 4.5 Define the “text” SQL Statement to run to UPDATE records in the SettingsTable. The SQL statement includes the Settings ($) variables
$sql = "UPDATE SettingTable SET cht_temp ='" . $cht_temp . "', bed_knob='" . $bed_knob . "',bed_door='" . $bed_door . "' where id='1';"; 

if ($conn->query($sql) === TRUE) {
  echo "<br>";  
  echo "<p class='boxLabel'> Settings successfully Updated!!</p>";
  echo "<br>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  echo "<br>";
}


echo "<br>";
//echo "<br>";
$conn->close();

?>


</body>
<body>
  <br>
  <div class="mytextSub">&nbspIf u want to return to Settings page please (Click) "Submit":</div>
	<br>
	<br>
  <form method="POST" action="SettingFormPage_Input.php">
    <input type="submit" class="sub" >
  </form>

      <br>

</body>
</html>
