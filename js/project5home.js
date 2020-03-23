function changeCourse(){
    setCourse(courseInput.value);
}

function logOut(){
    $.post("project5logOut.php");
    $("#currentUser").html("Guest");
    $("#logOut").toggle(false);
    $("#vote").toggle(false);
    $("#login").toggle(true);
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
        $.post("project5login.php",
        {
            userId: userInput.value,
            pass: passInput.value
        },
        function(data){
            if(data == ""){
                passInput.classList.add("error");
                alert("Incorrect password");
            }
            else{
                $("#currentUser").html(data);
                $("#login").toggle(false);
                $("#logOut").toggle(true);
                $("#vote").toggle(true);
                userInput.value = "";
                passInput.value = "";
                // TODO: Have the PHP return the user's role. If they're an admin, display a link to admin page and hide voting option.
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
    if(voteProjectInput.value == ""){
        voteProjectInput.classList.add("error");
    }
    else{
        // Check if user has already voted for the selected project
        // If not, redirect to vote page and send the selected project id
    }
}

if($("#currentUser").html().trim() == "Guest"){
    $("#logOut").toggle(false);
    $("#vote").toggle(false);
}
else{
    $("#login").toggle(false);
}

var userInput = document.getElementById("username");
var passInput = document.getElementById("password");
var viewProjectInput = document.getElementById("viewProject");
var voteProjectInput = document.getElementById("voteProject");
var courseInput = document.getElementById("course");

setCourse(1);