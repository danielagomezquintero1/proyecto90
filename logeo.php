 <?php
 session_start();

 if (isset($_POST['username']) && $_POST['username'] && isset($_POST['password']) && $_POST['password']) {

 	$user = $_POST['username'];
 	$pass = $_POST['password'];

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
//mysql_real_escape_string ( string $unescaped_string [, resource $link_identifier = NULL ] ) : string

 	$sql = "SELECT * FROM users WHERE username='$user' AND password='".md5($pass)."'";
 	$result = $conn->query($sql);


 	//conn->query y no MSQLI query
 	$sql1 =$conn->query("SELECT * FROM users WHERE username='$user'");
 	$result1=$sql1->fetch_array();
 	if ($result->num_rows > 0) {
 		$_SESSION['user'] = $user; 
 		//Creamos variables de sesion
 		$_SESSION['id'] = $result1["id"]; 
 		$_SESSION['verified'] = $result1["verified"]; 
 		$_SESSION['nombreusuario'] = $result1["username"]; 
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
