// These first 3 functions ensure that each team can only be selected once
function firstChange(){
    $("#first").removeClass('error');

    $("#second > option[value='" + first + "']").toggle(true);
    $("#third > option[value='" + first + "']").toggle(true);

    first = $("#first").val();

    if(first != ""){
        $("#second > option[value='" + first + "']").toggle(false);
        $("#third > option[value='" + first + "']").toggle(false);
    }
}

function secondChange(){
    $("#second").removeClass('error');

    $("#first > option[value='" + second + "']").toggle(true);
    $("#third > option[value='" + second + "']").toggle(true);

    second = $("#second").val();

    if(second != ""){
        $("#first > option[value='" + second + "']").toggle(false);
        $("#third > option[value='" + second + "']").toggle(false);
    }
}

function thirdChange(){
    $("#third").removeClass('error');

    $("#first > option[value='" + third + "']").toggle(true);
    $("#second > option[value='" + third + "']").toggle(true);

    third = $("#third").val();

    if(third != ""){
        $("#first > option[value='" + third + "']").toggle(false);
        $("#second > option[value='" + third + "']").toggle(false);
    }
}

// Ensure that all fields have been filled out
function submit(){
    let error = "";
    
    if(first == ""){
        error += "- You must vote for 1st Place";
        $("#first").addClass("error");
    }
    if(second == ""){
        if(error != ""){
            error += "\n";
        }

        error += "- You must vote for 2nd Place";
        $("#second").addClass("error");
    }
    if(third == ""){
        if(error != ""){
            error += "\n";
        }

        error += "- You must vote for 3rd Place";
        $("#third").addClass("error");
    }
    if($("#writeInTeam").val() == ""){
        if(error != ""){
            error += "\n";
        }

        error += "- You must select a team to make a write-in vote for";
        $("#writeInTeam").addClass("error");
    }
    if($("#writeInText").val() == ""){
        if(error != ""){
            error += "\n";
        }

        error += "- You must enter a description of your write-in vote";
        $("#writeInText").addClass("error");
    }

    // If one or more fields are blank, notify the user
    if(error != ""){
        alert(error);
    }
    // Otherwise, submit the user's votes and redirect to homepage
    else{
        $.post("project5submit.php",
        {
            firstId: first,
            secondId: second,
            thirdId: third,
            writeInId: $("#writeInTeam").val(),
            writeInText: $("#writeInText").val()
        });

        window.location.href = "project5home.php";
    }
}

var first = "";
var second = "";
var third = "";