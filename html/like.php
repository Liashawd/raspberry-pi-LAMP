<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
    <?php
        /*ensure security with global var, protect from xss attack by using intval()
        ... smh shoulda gone explicit data types */
        $num = intval($_GET['num']);
	if($num == null){
	echo("bad request");
	return;}

        /*connect*/
        $servername = "localhost";
                    $username = "root";
                    $password = "Admin";

                    //aka Schema? inte samma sak som db...
                    $dbName = "MyDB";

                    //connect, specify port 80
                    $conn = new mysqli($servername, $username, $password, $dbName, 80);
                    //check conn
                    if($conn->connect_error){
                        die("Connection failed: 
                        $conn->connect_error");
                    }
        
        $con = mysqli_connect($servername, $username, $password, $dbName);
        
        mysqli_query($con, "UPDATE comments SET likes = likes + 1 WHERE num = $num");

        $result = mysqli_query($con, "SELECT likes FROM comments WHERE num = $num");

        echo($result->fetch_assoc()['likes']);
        $con->close();
    ?>
</body>
</html>