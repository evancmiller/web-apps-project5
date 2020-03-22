<?php
    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");

    $query = $db->prepare("SELECT id, name, password, role FROM ae_User_P5 WHERE id = ?");
    $query->bind_param("i", $_POST["userId"]);
    $query->execute();
    $query->bind_result($userId, $user, $pass, $role);

    if($query->fetch() && $_POST["pass"] == $pass){
        $_SESSION["userId"] = $userId;
        $_SESSION["user"] = $user;
        $_SESSION["role"] = $role;
        $query->close();
        $db->close();
        echo $user;
    }
    else{
        $query->close();
        $db->close();
        echo "";
    }
?>