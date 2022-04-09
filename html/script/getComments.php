<?php

//https://tryphp.w3schools.com/showphpfile.php?filename=demo_db_select_oo_table


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
        //-> motsvarar .
    }

    //sql q below
    $sql = "SELECT comments.name, comments.message, comments.likes, comments.num,
    users.username, users.picture
        FROM comments 
        LEFT JOIN users ON comments.userid=users.id /*joina username vid korrekt userid, kommer vara null om kommentaren inte har user.*/
        ORDER BY num DESC";

    //skriv automatiskt den query som annars skrivs in manuellt i mySQL
    $comments = $conn->query($sql);
?>