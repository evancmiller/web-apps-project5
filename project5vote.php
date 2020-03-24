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
                <?php
                    if(isset($_SESSION["projectId"])){
                        $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

                        $query = $db->prepare("SELECT name 
                                               FROM ae_Project 
                                               WHERE id = ?");
                        $query->bind_param("i", $_SESSION["projectId"]);
                        $query->execute();
                        $query->bind_result($_SESSION["projectName"]);
                        $query->fetch();
                        $query->close();

                        print "<h1>{$_SESSION['projectName']} Voting</h1>"; 
                    }
                    else{
                        header("Location: project5home.php");
                    }
                ?>
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
                            header("Location: project5home.php");
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
                    <label for="first" class="gold">1st Place</label><br>
                    <select name="first" id="first" value="" onchange="firstChange();">
                        <option value=""></option>
                        <?php
                            $teams = array();
                            $userTeamId = null;

                            $query = $db->prepare("SELECT u.id, u.name, pt.id
                                                   FROM ae_User_P5 AS u
                                                   INNER JOIN
                                                   ae_Project_Team_User AS ptu
                                                   ON u.id = ptu.user_id
                                                   INNER JOIN
                                                   ae_Project_Team AS pt
                                                   ON pt.id = ptu.project_team_id
                                                   WHERE pt.project_id = ? AND u.role = 'user'");
                            $query->bind_param("i", $_SESSION["projectId"]);
                            $query->execute();
                            $query->bind_result($userId, $userName, $projectTeamId);
                            while($query->fetch()){
                                // Do not include the user's team
                                if($userId == $_SESSION["userId"] || $projectTeamId == $userTeamId){
                                    $userTeamId = $projectTeamId;
                                    unset($teams[$projectTeamId]);
                                }
                                // If the team has already been created, concatenate the team member's name
                                else if(isset($teams[$projectTeamId])){
                                    $teams[$projectTeamId] = $teams[$projectTeamId].", ".$userName;
                                }
                                // If the team hasn't been created, assign the team member's name to it
                                else{
                                    $teams[$projectTeamId] = $userName;
                                }
                            }
                            $query->close();

                            $teamOptions = "";
                            foreach($teams as $id => $team){
                                $teamOptions = $teamOptions."<option value=$id>$team</option>";
                            }

                            print $teamOptions;
                        ?>
                    </select>
                </div>
                <div class="col-4">
                    <label for="second" class="silver">2nd Place</label><br>
                    <select name="second" id="second" value="" onchange="secondChange();">
                    <option value=""></option>
                    <?php
                        print $teamOptions;
                    ?>
                    </select>
                </div>
                <div class="col-4">
                    <label for="third" class="bronze">3rd Place</label><br>
                    <select name="third" id="third" value="" onchange="thirdChange();">
                    <option value=""></option>
                    <?php
                        print $teamOptions;
                    ?>
                    </select>
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
                    <select name="writeInTeam" id="writeInTeam" value="" onchange="this.classList.remove('error');">
                    <option value=""></option>
                    <?php
                        print $teamOptions;
                    ?>
                    </select>
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
                <input type="button" class="h-align-center" value="Submit Vote" onclick="submit();">
            </div>
            <div class="col-5"></div>
        </div>
    </body>
</html>