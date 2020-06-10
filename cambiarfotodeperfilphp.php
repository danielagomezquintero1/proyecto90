 <?php
 session_start();



	$imagen = $_FILES['file-input']['tmp_name'];
	$ruta = $_FILES['file-input']['name'];
	move_uploaded_file($imagen,$ruta);
	
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



	$sql = "UPDATE users SET avatar = '$ruta' WHERE id= '".$_SESSION['id']."'";
	$result = $conn->query($sql);

	if ($result) {
		
	    echo json_encode(array('success' => 1));
	    
	} else {
	    echo json_encode(array('success' => 0));
	}
        $conn->close();
   



?> 
