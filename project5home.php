<!DOCTYPE HTML>
<?php
    session_start();
?>
<html lang="en">
    <head>
        <title>CS3220 - Alec Mathisen & Evan Miller Project 5 Home</title>
        <link rel="stylesheet" type="text/css" href="css/project5.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script lang="javascript" src="js/project5home.js" defer></script>
    </head>
    <body>
        <div class="row">
            <div class="col-11">
                <h1>People's Choice Awards Home</h1>
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
        <div class="row align-bottom">
            <div class="col-2">
                <label for="username">Username</label><br>
                <select name="username" id="username" value="" onchange="this.classList.remove('error');"></select>
            </div>
            <div class="col-2">
                <label for="password">Password</label><br>
                <input type="password" class="login" name="password" id="password" value="" onchange="this.classList.remove('error');">
            </div>
            <div class="col-1">
                <input type="button" value="Login" onclick="validateLogin();">
            </div>
            <div class="col-4"></div>
            <div class="col-2">
                <label for="viewProject">View Project</label><br>
                <select name="viewProject" id="viewProject" value="" onchange="this.classList.remove('error');"></select>
            </div>
            <div class="col-1">
                <input type="button" value="Go" onclick="viewProject();">
            </div>
        </div>
        <div class="row">
            <div class="col-3"><h2>Student</h2></div>
            <div class="col-3"><h2 class="gold">Gold Medals</h2></div>
            <div class="col-3"><h2 class="silver">Silver Medals</h2></div>
            <div class="col-3"><h2 class="bronze">Bronze Medals</h2></div>
        </div>
        <div class="row section">
            <div class="col-3"><h3>Student 1</h3></div>
            <div class="col-3">
                <h3 class="gold">Project 2</h3>
            </div>
            <div class="col-3"></div>
            <div class="col-3">
                <h3 class="bronze">Project 3</h3><br>
                <h3 class="bronze">Project 4</h3>
            </div>
        </div>
        <div class="row section">
            <div class="col-3"><h3>Student 2</h3>
            </div>
            <div class="col-3">
                <h3 class="gold">Project 3</h3>
            </div>
            <div class="col-3">
                <h3 class="silver">Project 1</h3><br>
                <h3 class="silver">Project 2</h3>
            </div>
            <div class="col-3"></div>
        </div>
    </body>
</html>