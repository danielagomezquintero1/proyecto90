 <?php
 session_start();


 
 	$user = $_SESSION['user'];
 	$servername = "localhost";
 	$username = "root";
 	$password = "";
 	$dbname = "mybd";

	// Create connection
 	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
 	if ($conn->connect_error) {
 		die("Connection failed: " . $conn->connect_error);
 	}

 	$sql = "SELECT * FROM chat";
 	$result = $conn->query($sql);

 	if ($result->num_rows > 0) {
 		while($row = $result->fetch_assoc()) {
 			echo "<fieldset style='text-align:left;'class='border p-2 pl-4'><span style='color:blue'><small>".$row["nombre"]. "</small></span> <br>" . $row["texto"]."<br>
 			<img style='width:3%;margin-right:1%;'src='https://cdn.iconscout.com/icon/free/png-256/like-670-894768.png'><small>0 </small>
 			<img style='width:3%;margin-left:1%' src='https://icons.iconarchive.com/icons/graphicloads/flat-finance/256/dislike-icon.png'><small> 0 </small>
 			

 			</fieldset><br>";
 			
 		}	
 } else {
 	
 		echo "0 results";
 }


 ?> 
