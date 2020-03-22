<!DOCTYPE HTML>
<?php
    session_start();
?>
<html lang="en">
    <head>
        <title>CS3220 - Alec Mathisen & Evan Miller Project 5 Voting</title>
        <link rel="stylesheet" type="text/css" href="css/project5.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script lang="javascript" src="js/project5vote.js" defer></script>
    </head>
    <body>
        <div class="row">
            <div class="col-11">
                <h1>People's Choice Awards Voting</h1>
            </div>
            <div class="col-1">
                <img src="img/cedarvilleLogo.png" alt="Cedarville University Logo" height="48" width="48" class="align-right"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                Logged in as: <span id="currentUser">Guest</span>
            </div>
        </div>
    </body>
</html>