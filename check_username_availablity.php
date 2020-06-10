<?php

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
sleep(1);
if (isset($_POST)) {
    $username = (string)$_POST['username1'];
 
    $result = $conn->query(
        'SELECT * FROM users WHERE username = "'.strtolower($username).'"'
    );
 
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger"><strong>Oh no!</strong> Nombre de usuario no disponible.</div>';
    } else {
        echo '';
    }
}