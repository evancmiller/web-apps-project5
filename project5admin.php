<!DOCTYPE HTML>
<?php
    session_start();
?>
<html lang="en">
    <head>
        <title>CS3220 - Alec Mathisen & Evan Miller Project 5 Admin Page</title>
        <link rel="stylesheet" type="text/css" href="css/project5.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script lang="javascript" src="js/project5admin.js" defer></script>
    </head>
    <body>
        <div class="row">
            <div class="col-11">
		   <?php
			$invalid = false;

			if(!isset($_SESSION["user"])){
                            $invalid = true;
                        }
			if(!isset($_SESSION["role"])){
                            $invalid = true;
                        }
			if(isset($_SESSION["role"]) && $_SESSION["role"] !='admin'){
                            $invalid = true;
                        }
			if(!isset($_GET["course"])){
                            $invalid = true;
                        }
			if(!$invalid){
				//TODO Grab course_id from user
				$course_id = $_GET["course"];
				$db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

		                $query = $db->prepare("SELECT name 
		                                       FROM ae_Course_P5 
		                                       WHERE id = ?");
				$query->bind_param("i", $course_id);
		                $query->execute();
		                $query->bind_result($courseName);
		                $query->fetch();
				$query->close();
				print "<h1>$courseName Admin Page</h1>";
			}else{
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
                    <h2>Edit Project</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
		     <select name="projectSelection" id="projectSelection" value="">
                        <option value=""></option>
                        <?php
				$query = $db->prepare("SELECT name, id 
		                                       FROM ae_Project 
		                                       WHERE course_id = ?");
				$query->bind_param("i", $course_id);
		                $query->execute();
		                $query->bind_result($projectName, $projectId);
		                while($query->fetch()){
				   print "<option value='$projectId'>$projectName</option>";
		                }
		                $query->close();
	                ?>
                    </select>
                </div>
                <div class="col-1">
                	<input type="button" id="openProject" class="h-align-center" value="Open" onclick="openProject();">
            	</div>
		<div class="col-1">
                	<input type="button" id="closeProject" class="h-align-center" value="Close" onclick="closeProject();">
            	</div>
            </div>
	    <div class="row">
                <div class="col-2">
			<?php		    
			   print "<input type='button' value='Edit Teams' onclick='teamPage($course_id);'>"
			?>
		</div>
	    </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-12">
                    <h2>Edit Users</h2>
                    <hr>
                </div>
            </div>
	    <div class="row v-align-center">
                <div class="col-2">
		     <label for="userSelection">Select User</label><br>
                    <select name="userSelection" id="userSelection" value="">
                        <option value=""></option>
                        <?php
				$query = $db->prepare("SELECT name, id 
		                                       FROM ae_User_P5 
		                                       WHERE course_id = ?");
				$query->bind_param("i", $course_id);
		                $query->execute();
		                $query->bind_result($userName, $userId);
		                while($query->fetch()){
				   print "<option value='$userId'>$userName</option>";
		                }
		                $query->close();
	                ?>
                    </select>
		     
                </div>
		<div class="col-2">
                	<input type="button" class="h-align-center" value="Reset Password" onclick="resetPassword();">
            	</div>
		<div class="col-1">
                	<input type="button" class="h-align-center" value="Remove" onclick="removeUser();">
            	</div>
            </div>
            <div class="row v-align-center">
                <div class="col-2">
                    <label for="newUser">New User</label><br>
                    <input type="text" name="newUser" id="newUser" value="">
                </div>
		<div class="col-1">
                    <input type="checkbox" id="isAdmin" value="Admin">Admin</input>
            	</div>
		<div class="col-2">
			<?php                	
			   print "<input type='button' value='Add' onclick='addUser($course_id);'>"
			?>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-5"></div>
            <div class="col-2">
                <input type="button" class="h-align-center" value="Back" onclick="goHome();">
            </div>
            <div class="col-5"></div>
        </div>
    </body>
</html>
