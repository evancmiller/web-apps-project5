<?php
    session_start();
    
    // Unset all of the session variables
    unset($_SESSION["userId"]);
    unset($_SESSION["user"]);
    unset($_SESSION["role"]);
    unset($_SESSION["projectId"]);
    unset($_SESSION["projectName"]);
?>