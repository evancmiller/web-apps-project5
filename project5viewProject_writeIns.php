 <?php
	class WriteIn{
	    public $team;
	    public $text;
	}

	$project_id = intval($_GET['id']);
	//Build team names
	$teams = array();
	$db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
	$query = $db->prepare("SELECT u.id, u.name, pt.id
	                           FROM ae_User_P5 AS u
	                           INNER JOIN
	                           ae_Project_Team_User AS ptu
	                           ON u.id = ptu.user_id
	                           INNER JOIN
	                           ae_Project_Team AS pt
	                           ON pt.id = ptu.project_team_id
	                           WHERE pt.project_id = ? AND u.role = 'user'");
	    $query->bind_param("i", $project_id);
	    $query->execute();
	    $query->bind_result($userId, $userName, $projectTeamId);
	    while($query->fetch()){
		if(isset($teams[$projectTeamId])){
		    $teams[$projectTeamId] = $teams[$projectTeamId].", ".$userName;
		}
		// If the team hasn't been created, assign the team member's name to it
		else{
		    $teams[$projectTeamId] = $userName;
		}
	    }
	    $query->close();

	$write_ins = array();
	$query = $db->prepare("SELECT pt.id, wi.id, wi.description
	                           FROM ae_Project_Team AS pt
	                           INNER JOIN
	                           ae_Write_In AS wi
	                           ON wi.project_team_id = pt.id
	                           WHERE pt.project_id = ?");
	    $query->bind_param("i", $project_id);
	    $query->execute();
	    $query->bind_result($projectTeamId, $writeInId, $description);
	    while($query->fetch()){
		 $write_ins[$writeInId] = new WriteIn();
	    	 $write_ins[$writeInId]->team = $teams[$projectTeamId];
		 $write_ins[$writeInId]->text = $description;
	    }
	    $query->close();
	    
	    $teamOptions = "<div id=\"write_in_messages\">";
	    foreach($write_ins as $id => $write_in){
		$teamOptions = $teamOptions."<div>";

		$teamOptions = $teamOptions."".$write_in->team.": ".$write_in->text;

		$teamOptions = $teamOptions."</div>";
	    }

	    $teamOptions = $teamOptions."</div>";
	    echo $teamOptions;
?>
