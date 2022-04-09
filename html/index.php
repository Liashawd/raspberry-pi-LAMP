<?php
    session_start(); //for user variables
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raspberry Pi Server</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="https://kit.fontawesome.com/5e39196fc3.js" crossorigin="anonymous"></script>

    <!--async js f�r att "like:a"-->
    <script>
    function likeComment(num){
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("LikesOnComment_"+num).innerHTML = this.responseText;
            }
        };
    xmlHttp.open("GET", "like.php?num="+num, true)
    xmlHttp.send();
    }
</script>
</head>
<body>
    <div id="everything">
        <div class="flex">
            
        <?php include "nav.html" ?>

        <div id="wrapper">
            <header>
                <h1>RASPBERRY PI SERVER</h1>
                <hr>
            </header>
            <main>

                <form method="post" id="commentForm"
                action="submitToServer.php">
                    <h2>Post a comment</h2>
                    <div>

                        <?php
                        if($_SESSION['valid'])
                            echo("<input type=\"text\" name=\"name\" value=\"$_SESSION[username]\" required readonly>");
                        else
                            echo("<input type=\"text\" name=\"name\" placeholder=\"Name\" required>");
                        ?>

                        <br>

                        <textarea id="commentText" required placeholder="Enter Comment"
                        name="msg" form="commentForm"
                        oninput=
                        '
                            this.style.height = "200px";
                            this.style.height = this.scrollHeight + "px";
                        ' 
                        ></textarea>
                    </div>
                    
                    <!--btn-->
                    <div class="buttonContainer">
                        <input id="ServerSubmission" class="hoverExpand" type="submit" value="Post">
                    </div>
                </form>

                

                <h2>Comments <span style="color:#8c8c8c; font-size:12px;">Behave</span></h2>

                <?php
                    //all scripts should be in script/
                    if(set_include_path("script")==false)
                        die("missing script");

                    //load comments, etc. from separate handling file
                    include 'include.php'; //returns $comments from getComments (TODO: MAKE RETURN VAR FROM FUNCTION INSTEAD)
                    
                    //parse returning table, getComments() from getComments.php
                    //skriv ut alla rows
                    //escape quote in quote w \"hello\", or <<<
                    if($comments->num_rows > 0){ //res from each row

                        echo("<div class=\"comments\">"); //element start tag

                        while($row = $comments->fetch_assoc()){

			                //!!LAST RESORT PREVENT XSS!!
                            $safeName = str_replace('<', '&lt;', $row['name']);
                            $safeMessage = str_replace('<', '&lt;', $row['message']);

                            echo("
                            <ul class=\"comment\">
                                
                                <li class=\"commentName".(empty($row['username'])? "" : " coolerName")."\"><h3>$safeName</h3></li>
                                <li class=\"commentMessage\"><p>$safeMessage<p></li>
                                <li class=\"commentLikes\"> 
                                <form>
                                    <p> 

                                        <button type=\"button\" onclick=\"likeComment($row[num])\" class=\"fa-regular fa-heart hoverExpand\"></button>
                                        
                                        <span id=\"LikesOnComment_" . $row['num'] ."\">
                                        $row[likes]
                                        </span>

                                    </p>
                                    
                                </form>
                                </li>

                                <li class=\"commentDeets\">
                                <p style=\"color:lightgray;\">#$row[num]</p>
                                <img class=\"commentPfp\" src=\"". (empty($row['picture']) ? "img/defaultpfp.png" : $row['picture'])."\" title=\"". ($row['username'] == null ? "anonymous" : $row['username']) ."\" alt=\"$row[username]'s profile picture\">
                                </li>
                                
                            </ul>
                            ");
                        }

                        echo("</div>"); //close tag
                    }
                    else{
                        echo("<p>none found</p>");
                    }
                    $conn->close();
                    
                    ?>
            </main>
        </div> 
    </div>

	<footer id="footer">
            <div id="footContainer" style="text-align: center; color:white;">
                <small>
                    Elias Huldberg, Some Rights Reserved(?)
                </small>
            </div>
        </footer>
    </div>

    <script src="script/generic.js">
</script>

</body>
</html>
