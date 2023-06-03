function init(user) {
  userID = user;
}

function newpost() {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //messages
      document.getElementById("newpostform").innerHTML = this.response;
    }
  };

  xhttp.open("GET", "accueil_post-form.php?userID=" + userID, true);
  xhttp.send();
}