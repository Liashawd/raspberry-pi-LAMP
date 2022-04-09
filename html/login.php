<?php
    // session start buffer
    ob_start();
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "Admin";
    $dbName = "MyDB";

    //connect & get sql user table
    $conn = new mysqli($servername, $username, $password, $dbName, 80);
    if($conn->connect_error)
        die($conn->connect_errno);

    $getUsers = "SELECT * FROM users";
    $GLOBALS['users'] = $conn->query($getUsers); //will be used as global var
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<?php

//triggered when form submits *in the same document!? what!?=?*
    
    //signup

    if(isset($_GET['login'], $_POST['username'], $_POST['password']) && hash_equals($_GET['login'], 'signup')){
        $username = $_POST['username'];
        //hash encode passw for minimal safety
        $password = hash("sha256", $_POST['password']);
    


        //CREDIT: https://makitweb.com/upload-and-store-an-image-in-the-database-with-php/

        if(isset($_FILES['picture']['name'])){
            echo("<script>console.log('trying to sign up with pic')</script>");
            SignUp($username, $password, true); //attempt a signup w image
            
        }
        else //----red?
        {
            echo("<script>console.log('no pic')</script>");
            SignUp($username, $password, false); //attempt a signup w/o image
        }
    }

    //login

    if(isset($_GET['login'], $_POST['username'], $_POST['password']) && hash_equals($_GET['login'], 'attempt')){
        $username = $_POST['username'];
        //hash encode passw for minimal safety
        $password = hash("sha256", $_POST['password']);
        SubmitLogin($username, $password); //attempt a login
    }
    //
    
?>

<body>
    
    <?php
        function SubmitLogin(string $username, string $password) {
            
            //AND! ENSURE THAT USERNAMES CAN'T BE THE SAME; UNIQUE CONSTRAINT IN SQL & SCRIPT TO PREVENT MULTIPLE ACC-NAME CREATIONS
            while($row = $GLOBALS['users']->fetch_assoc()){
                
                //hash_equals = attack safe strcompare
                if((hash_equals($row['username'], $username))){

                    //check password if username matches
                    if(hash_equals($row['password'], $password)){
                        Login($row['username'], $row['id'], $row['picture']); //perform login, setting variables
                    }
                }
            }
            //
            echo("incorrect username/password");
            die;
        }

        function Login(string $user, int $userid, ?string $picture)
        {
            //clear session vars & start new session
            session_destroy();
            session_start();

            //set session variables, can be named whatever
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $user;
            $_SESSION['userid'] = $userid;
            $_SESSION['picture'] = $picture;

            echo("<script>alert('Login successful!');window.location.replace(\"index.php\");</script>");
            die();
        }

    //with picture
    function SignUp(string $username, string $password, bool $withPicture)
        {
            $servername = "localhost";
            $serverUsername = "root";
            $serverPassword = "Admin";
            $dbName = "MyDB";

            $conn = new mysqli($servername, $serverUsername, $serverPassword, $dbName, 80);
            if($conn->connect_error){
                die($conn->connect_errno);
            }

            echo("<script>console.log('connected')</script>");

            $users = $conn->query("SELECT * FROM users");

            //check if username's taken
            while($row = $users->fetch_assoc()){

                if(hash_equals($row['username'], $username)==false)
                {
                    continue;
                }
                else{
                    echo("username $username taken");
                    return;
                }
            }
            //query insert
            //ADD USER + occassional picture <30kb?
            echo("<script>console.log('firstq ok')</script>");

            $conn->query("INSERT INTO users(username, password) VALUES(\"$username\", \"$password\");");

            //UPDATE ROW TO INSERT IMAGE
            if($withPicture)
            {
            echo("<script>console.log('read pic boolean')</script>");

    //////-------------------------[UPLOAD IMAGE]--------------------------
                $target_dir = "/mnt/data/symlink/html/img/users/";
                $rel_dir = "img/users/";
                $target_file = $target_dir . basename($_FILES["picture"]["name"]);
                //will be used in move uploaded file
                //file name will correspond to userid
                //username is unique.
                $newFileName = $conn->query("SELECT id FROM users WHERE username = \"$username\";")->fetch_assoc()['id'];

                echo("<script>console.log('new filename read')</script>");

                // Select file type
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Valid file extensions
                $extensions_arr = array("jpg","jpeg","png","gif");
                // Check extension
                if( in_array($imageFileType,$extensions_arr) ){
                // Upload file

                if(move_uploaded_file($_FILES['picture']['tmp_name'],$target_dir . $newFileName . "." . $imageFileType))
                        echo("<script>console.log('uploaded image to server')</script>");

                }
                else{
                    die("bad file");
                }

//////

            echo("<script>console.log('upload ok')</script>");

                if($conn->query("UPDATE users SET picture = \"".$rel_dir.$newFileName.".".$imageFileType."\"
                WHERE username =\"$username\";")==false)
                echo("<script>console.log('sql update failed')</script>");
                

            echo("<script>console.log('2ndq ok')</script>");
            }   
                

            $conn->close();
            Login($username, $newFileName, $rel_dir.$newFileName.".".$imageFileType); //newfilename erhåller id lol

            //VVV 100% red
            die();
        }
    ?>


    <h1>IMPORTANT:</h1>
    <p>Don't use actual sensitive information. While the passwords are hashed, meaning I can't see them, there isn't enough guaranteed security on this website! For starters, there is no SSL/TLS layer as of now...</p>
    <p><b>Also:</b> don't submit any picture over 2MB as it should exceed the default max size</p>
    <img src="img/passwords.png" alt="passwords">


    <form action="?login=attempt" method="POST">
        <fieldset>
            <legend>Login</legend>
            <input name="username" type="text" placeholder="username" required>
            <!--autocomplete safe passw-->
            <input name="password" type="password" autocomplete="false" readonly required onfocus="this.removeAttribute('readonly');">
            <input type="submit" value="login">
        </fieldset>
        
    </form>
    <br>
    <form action="?login=signup" method="POST" enctype="multipart/form-data"> <!--for file submission-->
        <fieldset>
            <legend>Sign up</legend>
            <input name="username" type="text" placeholder="username" required>
            <!--autocomplete safe passw-->
            <input name="password" type="password" autocomplete="false" readonly required onfocus="this.removeAttribute('readonly');">
            <input name="picture" type="file"> <!--safety precautions needed here-->
            <input type="submit" value="sign up">
        </fieldset>
    </form>
</body>
</html>