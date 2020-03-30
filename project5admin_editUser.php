<?php
   
   session_start();
   $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
   $db->autocommit(FALSE);

   if(isset($_POST['add'])){
   	if($_POST['add']){
	   $query = $db->prepare("INSERT INTO ae_User_P5 (name, password, role, course_id)
                           VALUES (?, 'password', ?, ?)");
	   $query->bind_param("ssi", $_POST['name'], $_POST['role'], $_POST['course_id']);
	   $query->execute();
	   $query->close();
	}
   }  
   if(isset($_POST['resetPassword'])){
   	if($_POST['resetPassword']){
	   $query = $db->prepare("UPDATE ae_User_P5 
                           	  SET password = password
                           	  WHERE id = ?");
	   $query->bind_param("i", $_POST['id']);
	   $query->execute();
	   $query->close();
	}
   }  
   if(isset($_POST['remove'])){
   	if($_POST['remove']){
	   $query = $db->prepare("DELETE FROM ae_User_P5
                           WHERE id = ?");
	   $query->bind_param("i", $_POST['id']);
	   $query->execute();
	   $query->close();
	}
   }  

   $db->commit();
   $db->close();
?>
