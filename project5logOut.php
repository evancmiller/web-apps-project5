<?php
    session_start();
    
    unset($_SESSION["userId"]);
    unset($_SESSION["user"]);
    unset($_SESSION["role"]);
    unset($_SESSION["projectId"]);
    unset($_SESSION["projectName"]);
?>