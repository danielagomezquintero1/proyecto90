 <?php
 session_start();

 if (isset($_POST['idpersonau']) && isset($_POST['nombreu']) && $_POST['nombreu']) {
 	$id = $_POST['idpersonau'];
 	$user = $_POST['nombreu'];



 	$servername = "localhost";
 	$username = "root";
 	$password = "";
 	$dbname = "photogram";

	// Create connection
 	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}

	$sql = "UPDATE users SET username='$user' WHERE id='$id'";
	$result = $conn->query($sql);


 	if ($result) {
 		sleep(3);

 		echo json_encode(array('success' => 1));

 	} else {
 		echo json_encode(array('success' => 0));
 	}
 	$conn->close();

 } 
 else {
 	echo json_encode(array('success' => 0));
 }


 ?> 
