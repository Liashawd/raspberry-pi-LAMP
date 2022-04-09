<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="https://kit.fontawesome.com/5e39196fc3.js" crossorigin="anonymous"></script>

    

</head>
<body>
    <div id="everything">
        <div class="flex">

            <?php include "nav.html" ?>
    
            <div id="wrapper">
                <main>
                    <div class="splitGrid readableLineHeight smallScreenPadding">
                        <div class="left">
                            <h2 class="centerText">So Like,</h2>
                            <p>
                                Why does this even exist? Surely there must be a reason... There is a reason, isn't there?</p>
                        </div>
                        <div class="right">
                            <h2 class="centerText">Well,</h2>
                            <p>This is merely a test site that i mess around with, trying to do good practice in web development.</p>
                        </div>
                    </div>
                    <!---->
                    <svg class="svgbr">
                        <circle cx="1em" cy="50%" r="5"/>
                        <circle cx="2em" cy="50%" r="5"/>
                        <circle cx="3em" cy="50%" r="5"/>
                    </svg>
                    <!---->
                    <h3>How it's done:</h3>
                    <p>Running i.e. debian <i>(this server's distro)</i>, entering</p>
                    <code>
                        sudo apt-get install apache2
                    </code>
                    <p class="newLine">gives you a simple web server, neatly prepared and featuring a template index file.

                    All there is to do next, is to replace the template file with your own, style it, implement some code and connect it to a database.
                    
                    Since you're gonna be hosting everything on your own machine, everything's gonna be free except for: 
                    </p>
                    <ol>
                        <li>the electricity bill</li>
                        <li>disk/drive replacements when they die</li>
                        <li>the occassional need of an ups</li>
                        <li>a cooler domain name than whatever's in the url right now</li>
                        <li>etc</li>
                    </ol>
                </main>
            </div>  
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
</body>

<script src="script/generic.js">
</script>

</html>