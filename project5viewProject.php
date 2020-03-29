<!DOCTYPE HTML>
<?php
    session_start();
?>
<html lang="en">
    <head>
        <title>CS3220 - Alec Mathisen & Evan Miller Project 5 View Project</title>
        <link rel="stylesheet" type="text/css" href="css/project5.css"/>
        <link rel="stylesheet" type="text/css" href="css/project5_viewProject.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-11">
                <?php
                    if(isset($_GET["id"])){
		    	$project_id = $_GET["id"];
			$db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

	                $query = $db->prepare("SELECT name, course_id 
	                                       FROM ae_Project 
	                                       WHERE id = ?");
	                $query->bind_param("i", $project_id);
	                $query->execute();
	                $query->bind_result($_SESSION["projectName"], $courseId);
	                $query->fetch();
	                $query->close();
	                print "<h1>{$_SESSION['projectName']}</h1>";
		   }
		   else{
                        header("Location: project5home.php");
                   }
                ?>

		<select id="projects">
		  <?php
                    	$query = $db->prepare("SELECT name, id 
	                                       FROM ae_Project 
	                                       WHERE course_id = ?");
	                $query->bind_param("i", $courseId);
	                $query->execute();
	                $query->bind_result($select_project_name, $select_project_id);
	                $query->fetch();
			while($query->fetch()){
			   if($project_id == $select_project_id){
			   	print "<option value='$select_project_id' selected=\"selected\">".$select_project_name."</option>";
			   }
			   else print "<option value='$select_project_id'>".$select_project_name."</option>";			
			}
	                $query->close();
	                
                ?>
		</select>
            </div>
            <div class="col-1">
                <img src="img/cedarvilleLogo.png" alt="Cedarville University Logo" height="48" width="48" class="h-align-right"/>
            </div>
        </div>
        <hr>
        <div id="vote_section" class="section">
            <div class="row">
                <div class="col-12">
		     <h2>Votes</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div id="vote_counter" class="col-4">
                </div>
            </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-12">
                    <h2>Write-Ins</h2>
                    <hr>
                </div>
            </div>
            <div class="row v-align-center">
                <div id="write_in_container" class="col-4">
                    <script>

			function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
				vars[key] = value;
			    });
			    return vars;
			}
			project_id = getUrlVars()["id"];

			$( "#projects" ).change(function() {			  
				var p = $( this ).val()
				window.location.replace( 'project5viewProject.php?id='+p); 
			});
			function goHome(){
				window.location.replace( 'project5home.php'); 
			}
			function grabVotes() { 
			    $.ajax({
				    type: "GET",
				    url: "project5viewProject_writeIns.php",
				    data: {id: this.project_id},                   
				    cache: true,
				    success: function(response) {
					$( "#write_in_container" ).html(response);
				    }
				});
				$.ajax({
				    type: "GET",
				    url: "project5viewProject_votes.php",
				    data: {id: this.project_id},                   
				    cache: true,
				    success: function(response) {
					$( "#vote_counter" ).html(response);
				    }
				});
			}
			//Double function to allow auto refresh
			grabVotes();
			setInterval(function(){
				grabVotes();
			}, 5000);
			
		    </script>
                </div>
            </div>
        </div>
            <input id="back" type="button" class="h-align-center" value="Back" onclick="goHome()">
    </body>
</html>
