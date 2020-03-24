<?php
    class User{
        public $id;
        public $name;
        public $role;
    }

    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
    $user = new User();

    $query = $db->prepare("SELECT id, name, password, role FROM ae_User_P5 WHERE id = ?");
    $query->bind_param("i", $_GET["userId"]);
    $query->execute();
    $query->bind_result($user->id, $user->name, $pass, $user->role);

    if($query->fetch() && $_GET["pass"] == $pass){
        $_SESSION["userId"] = $user->id;
        $_SESSION["user"] = $user->name;
        $_SESSION["role"] = $user->role;
    }
    else{
        $user->id = "";
        $user->name = "";
        $user->role = "";
    }

    $query->close();
    $db->close();
    echo json_encode($user);
?>