<?php
   $status = 'open';
   if(isset($_POST['close'])){
   	if($_POST['close']){
	    $status = 'closed';
	}
   }
   session_start();
   $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
   $db->autocommit(FALSE);
   $query = $db->prepare("UPDATE ae_Project
                           SET status = ?
                           WHERE id = ?");
   $query->bind_param("si", $status, $_POST['id']);
   $query->execute();
   $query->close();

   $db->commit();
   $db->close();
?>
