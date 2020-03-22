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
            }
        });
    }
}

function viewProject(){
    if(projectInput.value == ""){
        projectInput.classList.add("error");
    }
    else{
        // Redirect to view page and send the selected project id
    }
}

var userInput = document.getElementById("username");
var passInput = document.getElementById("password");
var projectInput = document.getElementById("viewProject");