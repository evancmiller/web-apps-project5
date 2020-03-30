function openProject(){
    var selection = document.getElementById("projectSelection");
    var button = document.getElementById("toggleProject");
    selection.classList.remove("error");
    
    if(selection.value == ""){
        selection.classList.add("error");
    } else{
    	$.ajax({
	    type: "POST",
	    url: "project5admin_editProject.php",
	    data: {id: selection.value, open: true},                   
	    success: function(response) {
		alert("Updated Project");
	    }
	});
    }
}

function closeProject(){
    var selection = document.getElementById("projectSelection");
    var button = document.getElementById("toggleProject");
    selection.classList.remove("error");
    
    if(selection.value == ""){
        selection.classList.add("error");
    } else{
    	$.ajax({
	    type: "POST",
	    url: "project5admin_editProject.php",
	    data: {id: selection.value, close: true},                   
	    success: function(response) {
		alert("Updated Project");
	    }
	});
    }
}

function addUser(course_id){
    var name = document.getElementById("newUser");
    var checkbox = document.getElementById("isAdmin");
    name.classList.remove("error");
    
    if(name.value == ""){
        name.classList.add("error");
    } else{
	var userRole = 'user';
	if(checkbox.checked){
	    userRole = 'admin';	
	}
	$.ajax({
	    type: "POST",
	    url: "project5admin_editUser.php",
	    data: {add: true, name: name.value, role: userRole, course_id: course_id},                   
	    success: function(response) {
		alert("Added User");
		location.reload();
	    }
	});
    }
}

function removeUser(){
    var selection = document.getElementById("userSelection");
    selection.classList.remove("error");
    
    if(selection.value == ""){
        selection.classList.add("error");
    } else{
	$.ajax({
	    type: "POST",
	    url: "project5admin_editUser.php",
	    data: {remove: true, id: selection.value},                   
	    success: function(response) {
		alert("Removed User");
		location.reload();
	    }
	});
    }
}

function resetPassword(){
    var selection = document.getElementById("userSelection");
    selection.classList.remove("error");
    
    if(selection.value == ""){
        selection.classList.add("error");
    } else{
	$.ajax({
	    type: "POST",
	    url: "project5admin_editUser.php",
	    data: {resetPassword: true, id: selection.value},                   
	    success: function(response) {
		alert("Reset Password");
	    }
	});
    }
}

function goHome(){
    window.location.href = "project5home.php";
}

function adminPage(course_id){
    window.location.href = "project5admin.php?course="+course_id;
}

function teamPage(course_id){
    window.location.href = "project5teams.php?course="+course_id;
}

function loadTeamInfo(){
 var project_id = document.getElementById("projectSelection").value;

	$.ajax({
	    type: "GET",
	    url: "project5teams_loadTeams.php",
	    data: {project_id: project_id},                   
	    cache: true,
	    success: function(response) {
		$( "#teamContainer" ).html(response);
	    }
	});
}

function addUserToTeam(){
    var selection_User = document.getElementById("userSelection");
    var selection_Team = document.getElementById("teamSelection");
    selection_User.classList.remove("error");
    selection_Team.classList.remove("error");
    let valid = true;
    if(selection_User.value == ""){
        selection_User.classList.add("error");
	valid = false;
    }	
    if(selection_Team.value == ""){
        selection_Team.classList.add("error");
	valid = false;
    }
    if(valid) {
	var userId = selection_User.value;
	var teamId = selection_Team.value;
	$.ajax({
	    type: "POST",
	    url: "project5teams_editTeam.php",
	    data: {add: true, team_id: teamId, user_id: userId},                   
	    success: function(response) {
		loadTeamInfo();
	    }
	});
   }
}

function removeUser(teamId, userId){
	$.ajax({
	    type: "POST",
	    url: "project5teams_editTeam.php",
	    data: {remove: true, team_id: teamId, user_id: userId},                   
	    success: function(response) {
		loadTeamInfo();
	    }
	});
}
