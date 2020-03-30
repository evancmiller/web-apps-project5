<?php
class TeamInfo{
    public $users;
    public function __construct(){
	$users = array();
    }
}
class User {
   public $id;
   public $name;			
}
session_start();
$db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
$teams = array();
$query = $db->prepare("SELECT u.id, u.name, pt.id
                           FROM ae_User_P5 AS u
                           INNER JOIN
                           ae_Project_Team_User AS ptu
                           ON u.id = ptu.user_id
                           INNER JOIN
                           ae_Project_Team AS pt
                           ON pt.id = ptu.project_team_id
                           WHERE pt.project_id = ? AND u.role = 'user'");
    $query->bind_param("i", $_GET['project_id']);
    $query->execute();
    $query->bind_result($userId, $userName, $projectTeamId);
    while($query->fetch()){
        if(isset($teams[$projectTeamId])){
            $teams[$projectTeamId]->users[$userId] = new User();
	    $teams[$projectTeamId]->users[$userId]->id = $userId;
	    $teams[$projectTeamId]->users[$userId]->name = $userName;
        }
        else{
            $teams[$projectTeamId] = new TeamInfo();
            $teams[$projectTeamId]->users[$userId] = new User();
	    $teams[$projectTeamId]->users[$userId]->id = $userId;
	    $teams[$projectTeamId]->users[$userId]->name = $userName;
        }
    }
    $query->close();
    
    $teamOptions = "";
    $teamNumber = 1;
    foreach($teams as $id => $team){
	$team_id = $id;
	$teamOptions = $teamOptions."<div id='team_$id' class='col-4' class='team'>";
	$teamOptions = $teamOptions."<div>Team $teamNumber</div>";
	$teamOptions = $teamOptions."<hr>";
	foreach($team->users as $id => $user){
            $teamOptions = $teamOptions."<div class='username'>".$user->name;
	    $teamOptions = $teamOptions."<input type='button' value='X' onclick='removeUser($team_id, {$user->id});'>";
	    $teamOptions = $teamOptions."</div>";
	}

	$teamOptions = $teamOptions."</div>";
	$teamNumber = $teamNumber+1;
    }
    print $teamOptions;
?>
