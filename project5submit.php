<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
    $db->autocommit(FALSE);

    // Record the user's 1st place vote
    $query = $db->prepare("UPDATE ae_Project_Team
                           SET gold_votes = gold_votes + 1
                           WHERE id = ?");
    $query->bind_param("i", $_POST["firstId"]);
    $query->execute();
    $query->close();

    // Record the user's 2nd place vote
    $query = $db->prepare("UPDATE ae_Project_Team
                           SET silver_votes = silver_votes + 1
                           WHERE id = ?");
    $query->bind_param("i", $_POST["secondId"]);
    $query->execute();
    $query->close();

    // Record the user's 3rd place vote
    $query = $db->prepare("UPDATE ae_Project_Team
                           SET bronze_votes = bronze_votes + 1
                           WHERE id = ?");
    $query->bind_param("i", $_POST["thirdId"]);
    $query->execute();
    $query->close();

    // Record the user's write-in vote
    $query = $db->prepare("INSERT INTO ae_Write_In (project_team_id, description)
                           VALUES (?, ?)";
    $query->bind_param("is", $_POST["writeInId"], $_POST["writeInText"]);
    $query->execute();
    $query->close();

    // Record that the user has voted
    $query = $db->prepare("UPDATE ae_hasVoted
                           SET hasVoted = 1 
                           WHERE user_id = ? AND project_id = ?");
    $query->bind_param("ii", $_SESSION["userId"], $_SESSION["projectId"]);
    $query->execute();
    $query->close();

    $db->commit();
    $db->close();
?>