function init(user) {
  userID = user;
}

function newpost(id) {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //messages
      document.getElementById("newpostform").innerHTML = this.response;
    }
  };

  xhttp.open("GET", "accueil_post-form.php?id=" + id, true);
  xhttp.send();
}


function liker(button) {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      button.parentElement.children[0].innerHTML = Number(button.parentElement.children[0].innerHTML) + 1;
      button.parentElement.children[1].remove();
    }
  };

  xhttp.open("GET", "liker.php?id=" + button.parentElement.parentElement.id, true);
  xhttp.send();
}
function commenter(button) {
  newpost(button.parentElement.parentElement.id);
}
function republier(button) {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.response)
        alert(this.response);
      location.reload();
    }
  };

  xhttp.open("GET", "republier.php?id=" + button.parentElement.parentElement.id, true);
  xhttp.send();
}