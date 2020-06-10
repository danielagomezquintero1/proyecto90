 <?php
 session_start();

 if (isset($_POST['username1']) && $_POST['username1'] && isset($_POST['password1']) && $_POST['password1']) {

 	$user = $_POST['username1'];
 	$pass = $_POST['password1'];
 	$name = $_POST['lastname'];
 	$email = $_POST['email'];
 	$ip = $_SERVER['REMOTE_ADDR'];

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

 	$consultausuario = "SELECT username FROM users WHERE username='$user'";
 	$consultaemail = "SELECT username FROM users WHERE email='$email'";

 	if($resultadousuario = $conn->query($consultausuario));
 	$numerousuario = $resultadousuario->num_rows;

 	if($resultadoemail = $conn->query($consultaemail));
 	$numeroemail = $resultadoemail->num_rows;
 	if($numeroemail >0){
 		echo"Este correo ya esta registrado, intente con otro";
 	}
 	elseif($numerousuario>0){
 		echo"Este usuario ya existe";
 	}
 	else{
 		$sql = "INSERT INTO users (email, name, username, password,signup_date,last_ip) VALUES ('$email','$name','$user','".md5($pass)."',now(),'$ip')";
 		$result = $conn->query($sql);

 		if ($result) {
 						$sql1 =$conn->query("SELECT * FROM users WHERE username='$user'");
 	$result1=$sql1->fetch_array();
 			$_SESSION['user'] = $user;
 			$_SESSION['id'] = $result1["id"]; 
 			$_SESSION['nombreusuario'] = $result1["username"]; 
 			echo json_encode(array('success' => 1));

 		} else {
 			echo json_encode(array('success' => 0));
 		}
 	}

 	$conn->close();

 } 
 else {
 	echo json_encode(array('success' => 0));
 }


 ?> 