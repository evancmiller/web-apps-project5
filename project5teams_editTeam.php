<?php   
   session_start();
   $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
   $db->autocommit(FALSE);

   if(isset($_POST['add'])){
   	if($_POST['add']){
	   $query = $db->prepare("INSERT INTO ae_Project_Team_User (project_team_id , user_id)
                           VALUES (?, ?)");
	   $query->bind_param("ii", $_POST['team_id'], $_POST['user_id']);
	   $query->execute();
	   $query->close();
	}
   }  
   if(isset($_POST['remove'])){
   	if($_POST['remove']){
	   $query = $db->prepare("DELETE FROM ae_Project_Team_User
                           WHERE project_team_id = ? AND user_id = ?");
	   $query->bind_param("ii", $_POST['team_id'], $_POST['user_id']);
	   $query->execute();
	   $query->close();
	}
   }  

   $db->commit();
   $db->close();
?>
