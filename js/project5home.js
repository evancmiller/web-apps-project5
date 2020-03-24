function changeCourse(){
    setCourse(courseInput.value);
}

function logOut(){
    $.post("project5logOut.php");
    $("#currentUser").html("Guest<div id='guest' hidden></div>");
    $("#logOut").toggle(false);
    $("#vote").toggle(false);
    $("#adminOnly").toggle(false);
    $("#login").toggle(true);
    voteProjectInput.value = "";
    user = null;
}

function setCourse(id){
    $.getJSON("project5setCourse.php",
    {
        courseId: id
    },
    function(data){
        // List the open projects as options to vote on and the closed projects as options to view
        let viewHtml = "<option value=''></option>";
        let voteHtml = "<option value=''></option>";
        $.each(data.projects, function(idx, val){
            if(val.status == "open"){
                voteHtml += "<option value='" + val.id + "'>" + val.name + "</option>";
            }
            else if(val.status == "closed"){
                viewHtml += "<option value='" + val.id + "'>" + val.name + "</option>";
            }
        });
        $("#viewProject").html(viewHtml);
        $("#voteProject").html(voteHtml);

        // List the users and their medals
        let html = "";
        $.each(data.users, function(idx, val){
            // List the user's name
            html += "<div class='row section'><div class='col-3'><h3>" + val.name + "</h3></div><div class='col-3'>";

            // List the user's gold medals
            $.each(val.golds, function(idx, gold){
                html += "<h3 class='gold'>" + gold + "</h3>";
            });

            html += "</div><div class='col-3'>";

            // List the user's silver medals
            $.each(val.silvers, function(idx, silver){
                html += "<h3 class='silver'>" + silver + "</h3>";
            });

            html += "</div><div class='col-3'>";

            // List the user's bronze medals
            $.each(val.bronzes, function(idx, bronze){
                html += "<h3 class='bronze'>" + bronze + "</h3>";
            });

            html += "</div></div>";
        });
        $("#students").html(html);
    });
}

function validateForm(){
    let valid = true;
    userInput.classList.remove("error");
    passInput.classList.remove("error");
    
    if(userInput.value == ""){
        valid = false;
        userInput.classList.add("error");
    }
    if(passInput.value == ""){
        valid = false;
        passInput.classList.add("error");
    }
    return valid;
}

function validateLogin(){
    if(validateForm()){
        $.getJSON("project5login.php",
        {
            userId: userInput.value,
            pass: passInput.value
        },
        function(data){
            if(data.role == ""){
                passInput.classList.add("error");
                alert("Incorrect password");
            }
            else{
                $("#login").toggle(false);
                $("#logOut").toggle(true);
                userInput.value = "";
                passInput.value = "";
                user = data.id;

                let html = data.name;
                if(data.role == "user"){
                    $("#vote").toggle(true);
                }
                else if(data.role == "admin"){
                    $("#adminOnly").toggle(true);
                    html += "<div id='admin' hidden></div>";
                }
                $("#currentUser").html(html);
            }
        });
    }
}

function viewProject(){
    if(viewProjectInput.value == ""){
        viewProjectInput.classList.add("error");
    }
    else{
        // Redirect to view page and send the selected project id
    }
}

function voteProject(){
    // Check if user has selected a project
    if(voteProjectInput.value == ""){
        voteProjectInput.classList.add("error");
    }
    // Check if user has already voted for the selected project
    else{
        $.post("project5hasVoted.php",
        {
            userId: user,
            projectId: voteProjectInput.value
        },
        function(data){
            if(data == 1){
                alert("You have already voted for this project");
            }
            else if(data == 0){
                window.location.href = "project5vote.php";
            }
        });
    }
}

// If an element with id='guest' exists, then no one is logged in
if($("#guest").length){
    $("#logOut").toggle(false);
    $("#vote").toggle(false);
    $("#adminOnly").toggle(false);
}
// Otherwise, the user is logged in
else{
    $("#login").toggle(false);

    // If an element with id='admin' exists, then the user is logged in as an admin
    if($("#admin").length){
        $("#vote").toggle(false);
    }
    else{
        $("#adminOnly").toggle(false);
    }
}

var userInput = document.getElementById("username");
var passInput = document.getElementById("password");
var viewProjectInput = document.getElementById("viewProject");
var voteProjectInput = document.getElementById("voteProject");
var courseInput = document.getElementById("course");
var user = null;

setCourse(1);