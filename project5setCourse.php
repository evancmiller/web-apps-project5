<?php
    class Combined{
        public $projects;
        public $users;

        public function __construct(){
            $this->projects = array();
            $this->users = array();
        }
    }

    class Project{
        public $id;
        public $name;
        public $status;
    }

    class User{
        public $id;
        public $name;
        public $golds;
        public $silvers;
        public $bronzes;

        public function __construct(){
            $this->golds = array();
            $this->silvers = array();
            $this->bronzes = array();
        }
    }

    session_start();
    $db = mysqli_connect("james", "cs3220", "", "cs3220_Sp20");
    $combined = new Combined();

    // Retrieve the course's projects from the database and put them in an array
    $query = $db->prepare("SELECT id, name, status
                           FROM ae_Project
                           WHERE course_id = ?");
    $query->bind_param("i", $_GET["courseId"]);
    $query->execute();
    $query->bind_result($projectId, $projectName, $projectStatus);
    while($query->fetch()){
        $project = new Project();
        $project->id = $projectId;
        $project->name = $projectName;
        $project->status = $projectStatus;
        array_push($combined->projects, $project);
    }
    $query->close();

    // Retrieve the course's users from the database and put them in an array
    $query = $db->prepare("SELECT id, name
                           FROM ae_User_P5 
                           WHERE course_id = ? AND role = 'user'");
    $query->bind_param("i", $_GET["courseId"]);
    $query->execute();
    $query->bind_result($userId, $userName);
    while($query->fetch()){
        $user = new User();
        $user->id = $userId;
        $user->name = $userName;
        array_push($combined->users, $user);
    }
    $query->close();

    // Retrieve each user's gold/silver/bronze awards from the database
    // and put them in their respective arrays
    foreach($combined->users as $user){
        $query = $db->prepare("SELECT p.name, pt.result
                               FROM ae_Project_Team_User AS ptu 
                               INNER JOIN 
                               ae_Project_Team AS pt 
                               ON ptu.project_team_id = pt.id 
                               INNER JOIN
                               ae_Project AS p 
                               ON p.id = pt.project_id 
                               WHERE p.course_id = ? AND ptu.user_id = ? AND pt.result != 'none'");
        $query->bind_param("ii", $_GET["courseId"], $user->id);
        $query->execute();
        $query->bind_result($projectName, $result);
        while($query->fetch()){
            if($result == "gold"){
                array_push($user->golds, $projectName);
            }
            elseif($result == "silver"){
                array_push($user->silvers, $projectName);
            }
            elseif($result == "bronze"){
                array_push($user->bronzes, $projectName);
            }
        }
        $query->close();
    }

    $db->close();
    echo json_encode($combined);
?>