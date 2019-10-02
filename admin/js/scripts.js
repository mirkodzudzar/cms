////JQUERY
$(document).ready(function () {
//CKEDITOR
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(error => {
            console.error(error);
        }); 
    
//CHECKING ALL CHECKBOXES
    $('#selectAllBoxes').click(function (event) {    
        if(this.checked) {       
            $('.checkBoxes').each(function () {
               this.checked = true; 
            });
        }
        else{
            $('.checkBoxes').each(function () {
               this.checked = false; 
            });
        }
    });
    
//REST OF THE CODE
    
});

//LOADER SETTINGS
    var myVar;

    function myFunction() {
      myVar = setTimeout(showPage, 2000);
    }

    function showPage() {
      document.getElementById("loader").style.display = "none";
      document.getElementById("wrapper").style.display = "block";
    }

//REFRESHING PAGE TO SHOW ONLINE USERS NUMBER - AJAX

function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function (data) {
        $(".usersonline").text(data);
    });
}

setInterval(function () {
    loadUsersOnline();
}, 500);