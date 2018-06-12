<?php

session_start();

    if (isset($_GET['size'])){
        $_SESSION['limit']=$_GET['size'];
        }
 
 header("Location: full_search.php");
