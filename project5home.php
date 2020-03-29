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
                <img src="img/cedarvilleLogo.png" alt="Cedarville University Logo" height="48" width="48" class="h-align-right"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                Logged in as: 
                <span id="currentUser">
                    <?php
                        // If the user is logged in, print their name
                        if(isset($_SESSION["user"])){
                            print $_SESSION["user"];
                        }
                        // Otherwise, print "Guest" and add a hidden guest element
                        else{
                            print "Guest<div id='guest' hidden></div>";
                        }

                        // Add hidden admin element if the user is an admin
                        if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"){
                            print "<div id='admin' hidden></div>";
                        }
                    ?>
                </span>
            </div>
        </div>
        <div class="row v-align-bottom">
            <div class="col-5">
                <div id="login" class="row v-align-bottom">
                    <div class="col-4 no-padding">
                        <label for="username">Username</label><br>
                        <select name="username" id="username" value="" onchange="this.classList.remove('error');">
                            <option value=""></option>
                            <?php
                                $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

                                // Retrieve the list of users from the database
                                $query = $db->prepare("SELECT id, name, course_id
                                                       FROM ae_User_P5");
                                $query->execute();
                                $query->bind_result($userId, $user, $courseId);
                            
                                // List the usernames as options
                                while($query->fetch()){
                                    print "<option value='$userId' data-courseId='$courseId'>$user</option>";
                                }
                                $query->close();
                                $db->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-1 no-padding"></div>
                    <div class="col-4 no-padding">
                        <label for="password">Password</label><br>
                        <input type="password" class="login" name="password" id="password" value="" onchange="this.classList.remove('error');">
                    </div>
                    <div class="col-1 no-padding"></div>
                    <div class="col-2 no-padding">
                        <input type="button" value="Login" onclick="validateLogin();">
                    </div>
                </div>
                <div id="logOut" class="row v-align-bottom">
                    <div class="col-2 no-padding">
                        <input type="button" value="Log Out" onclick="logOut();">
                    </div>
                    <div class="col-10 no-padding"></div>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-2">
                <label for="course">Select Course</label><br>
                <select name="course" id="course" value="1">
                    <?php
                        $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

                        // Retrieve the list of courses from the database
                        $query = $db->prepare("SELECT id, name
                                               FROM ae_Course_P5");
                        $query->execute();
                        $query->bind_result($courseId, $course);
                    
                        // List the courses as options
                        while($query->fetch()){
                            print "<option value='$courseId'>$course</option>";
                        }
                        $query->close();
                        $db->close();
                    ?>
                </select>
            </div>
            <div class="col-1">
                <input type="button" value="Select" onclick="changeCourse();">
            </div>
            <div class="col-2">
                <label for="viewProject">View Project</label><br>
                <select name="viewProject" id="viewProject" value="" onchange="this.classList.remove('error');"></select>
            </div>
            <div class="col-1">
                <input type="button" value="View" onclick="viewProject();">
            </div>
        </div>
        <div id="vote" class="row v-align-bottom">
            <div class="col-9"></div>
            <div class="col-2">
                <label for="voteProject">Vote for Project</label><br>
                <select name="voteProject" id="voteProject" value="" onchange="this.classList.remove('error');"></select>
            </div>
            <div class="col-1">
                <input type="button" value="Vote" onclick="voteProject();">
            </div>
        </div>
        <div id="adminOnly" class="row">
            <div class="col-2">
                <input type="button" value="Admin Page" onclick="window.location.href = 'project5admin.php'">
            </div>
            <div class="col-10"></div>
        </div>
        <div class="row">
            <div class="col-3"><h2>Student</h2></div>
            <div class="col-3"><h2 class="gold">Gold Medals</h2></div>
            <div class="col-3"><h2 class="silver">Silver Medals</h2></div>
            <div class="col-3"><h2 class="bronze">Bronze Medals</h2></div>
        </div>
        <div id="students"></div>
    </body>
</html>