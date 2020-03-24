<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    $query = $db->prepare("SELECT hasVoted 
                           FROM ae_hasVoted 
                           WHERE user_id = ? AND project_id = ?");
    $query->bind_param("ii", $_POST["userId"], $_POST["projectId"]);
    $query->execute();
    $query->bind_result($hasVoted);
    $query->fetch();
    $query->close();
    $db->close();

    if($hasVoted == 0){
        $_SESSION["projectId"] = $_POST["projectId"];
    }

    echo $hasVoted;
?>