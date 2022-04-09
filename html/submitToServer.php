<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body> 
    <?php //this file needs to serve hard xss protection.

    //-----------------------------------------------------------
    //
    //-----------------------------------------------------------
	//om v�rdena inte existerar, returnera
        if((isset($_POST["name"]) && isset($_POST["msg"]))==false){
            die("error, name or msg faulty");
        }

        $name = $_POST["name"];
        $msg = $_POST["msg"];

        //make safe from xss
        $safeName = htmlspecialchars($name);
        $safeMessage = htmlspecialchars($msg);


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
            //-> motsvarar . Xdddddd
        }
       
        //specify cols to change to apply default value on likes & primary key (num)
        //param behöver quotes runt variablerna.
        //om valid session, lägg till userid
        if($_SESSION['valid'])
            $sql = "INSERT INTO comments(name,message,userid) VALUES(\"$safeName\", \"$safeMessage\", \"$_SESSION[userid]\");";
        else
            $sql = "INSERT INTO comments(name,message) VALUES(\"$safeName\", \"$safeMessage\");";
        //skriv query
        $conn->query($sql);

        $conn->close();

        //*dont use $_SERVER[HTTP_REFERER] för att gå tillbaka.
    ?>
    <!--använd jscript för att återvända till förra sidan-->
    <script>
        window.location.replace("index.php")
    </script>
</body>
</html>