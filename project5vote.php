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
                <img src="img/cedarvilleLogo.png" alt="Cedarville University Logo" height="48" width="48" class="h-align-right"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                Logged in as: 
                <span id="currentUser">
                    <?php
                        if(isset($_SESSION["user"])){
                            print $_SESSION["user"];
                        }
                        else{
                            print "Guest";
                        }
                    ?>
                </span>
            </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-12">
                    <h2>Top 3 Teams</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="firstPlace" class="gold">1st Place</label><br>
                    <select name="firstPlace" id="firstPlace" value="" onchange="this.classList.remove('error');"></select>
                </div>
                <div class="col-4">
                    <label for="secondPlace" class="silver">2nd Place</label><br>
                    <select name="secondPlace" id="secondPlace" value="" onchange="this.classList.remove('error');"></select>
                </div>
                <div class="col-4">
                    <label for="thirdPlace" class="bronze">3rd Place</label><br>
                    <select name="thirdPlace" id="thirdPlace" value="" onchange="this.classList.remove('error');"></select>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-12">
                    <h2>Write-In</h2>
                    <hr>
                </div>
            </div>
            <div class="row v-align-center">
                <div class="col-4">
                    <label for="writeInTeam">Team</label><br>
                    <select name="writeInTeam" id="writeInTeam" value="" onchange="this.classList.remove('error');"></select>
                </div>
                <div class="col-8">
                    <label for="writeInText">Description</label><br>
                    <input type="text" name="writeInText" id="writeInText" value="" onchange="this.classList.remove('error');">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-5"></div>
            <div class="col-2">
                <input type="button" class="h-align-center" value="Submit Vote" onclick="submitVote();">
            </div>
            <div class="col-5"></div>
        </div>
    </body>
</html>