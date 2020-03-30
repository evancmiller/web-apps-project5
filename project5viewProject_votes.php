<?php
			class TeamInfo{
			    public $name;
			    public $gold;
			    public $silver;
			    public $bronze;
			}
			$project_id = intval($_GET['id']);
			$teams = array();
			$db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
			$query = $db->prepare("SELECT u.id, u.name, pt.id, pt.gold_votes, pt.silver_votes, pt.bronze_votes
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
		            $query->bind_result($userId, $userName, $projectTeamId, $projectTeam_gold, $projectTeam_silver, $projectTeam_bronze);
		            while($query->fetch()){
		                if(isset($teams[$projectTeamId])){
		                    $teams[$projectTeamId]->name = $teams[$projectTeamId]->name.", ".$userName;
		                }
		                // If the team hasn't been created, assign the team member's name to it
		                else{
		                    $teams[$projectTeamId] = new TeamInfo();
				    $teams[$projectTeamId]->name = $userName;
				    $teams[$projectTeamId]->gold = $projectTeam_gold;
				    $teams[$projectTeamId]->silver = $projectTeam_silver;
				    $teams[$projectTeamId]->bronze = $projectTeam_bronze;
		                }
		            }
		            $query->close();
			    
		            $teamOptions = "";
		            $teamOptions = $teamOptions."<table id=\"vote_table\">
						<tr>
							<th>Team</th>
							<th class=\"gold\">Gold</th>
							<th class=\"silver\">Silver</th>
							<th class=\"bronze\">Bronze</th>
						</tr>";
		            foreach($teams as $id => $team){
				$teamOptions = $teamOptions."<tr>";

		                $teamOptions = $teamOptions."<td>".$team->name."</td>";
		                $teamOptions = $teamOptions."<td>".$team->gold."</td>";
		                $teamOptions = $teamOptions."<td>".$team->silver."</td>";
		                $teamOptions = $teamOptions."<td>".$team->bronze."</td>";

				$teamOptions = $teamOptions."</tr>";
		            }

			    $teamOptions = $teamOptions."</table>";
		            print $teamOptions;
		    ?>
