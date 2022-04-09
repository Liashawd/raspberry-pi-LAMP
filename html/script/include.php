<?php
   switch($_SERVER['SCRIPT_FILENAME'])
   {
      //if caller is index.php, give comments
      case '/mnt/data/symlink/html/index.php':
         require_once('getComments.php');
         break;
      case '/mnt/data/symlink/html/login.php':
         require_once('uploadImage.php');
         break;
      default:
         echo('error when trying to include script, check include list');
         break;
   }
?>