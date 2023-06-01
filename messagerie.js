function init(user) {
  actconv = null;
  userID = user;

  intervalId = setInterval(chargeConv, 1000);


  const form = document.getElementById("formessage");

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    var xhttp = new XMLHttpRequest();
    var FD = new FormData(form);
    FD.append('conv', actconv);
    FD.append('userID', userID);

    xhttp.addEventListener("load", (event) => {
      if (event.target.responseText)
        alert(event.target.responseText);
      document.getElementById("conv_footer").innerHTML += "";
      document.getElementsByName('photo')[0].style.display = "none";
    });

    xhttp.addEventListener("error", (event) => {
      alert('Une erreur est survenue.');
    });

    xhttp.open("POST", "envoyer_message.php");
    xhttp.send(FD);
  });

}



function changeConv(conv) {
  document.getElementById("conv_body").innerHTML = "";

  //suppr discussion actuel
  if (document.getElementsByClassName("conv_act")[0])
    document.getElementsByClassName("conv_act")[0].classList.remove("conv_act");

  if (conv > 0) {
    actconv = conv;

    //discussion actuel
    document.getElementById(conv).classList.add("conv_act");

    header = document.getElementById(conv).children[0].innerHTML;
    header += "<span style='margin-left:5%; font-size: 2em'>" + document.getElementById(conv).children[1].innerHTML + "</span>";
    document.getElementById("conv_header").innerHTML = header;
    chargeConv();
  } else if (conv == -1) {
    clearInterval(intervalId);

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //messages
        document.getElementById("conv_body").innerHTML = this.response;

        header = "<span style='margin-left:5%; font-size: 2em'>Nouvelle discussion</span>";
        document.getElementById("conv_header").innerHTML = header;
      }
    };

    xhttp.open("GET", "messagerie_conv-form.php?userID=" + userID, true);
    xhttp.send();
  }
}
function addmembre() {
  select = document.getElementById("selectmembre");
  clone = select.children[0].cloneNode(true);
  clone.children[0].required = 0;

  var btn = document.createElement("button");
  btn.setAttribute('type', 'button');
  btn.appendChild(document.createTextNode("-"));
  btn.setAttribute('onclick', "supmembre(this.parentElement.remove())");;
  clone.appendChild(btn);
  select.appendChild(clone);


}



function chargeConv() {
  //on charge la conversation seulement si il est en bas
  if ((document.getElementById("conv_body").scrollTop + document.getElementById("conv_body").clientHeight - document.getElementById("conv_body").scrollHeight) == 0) {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //messages
        document.getElementById("conv_body").innerHTML = this.responseText;

        document.getElementById("conv_body").scrollTo(0, document.getElementById("conv_body").scrollHeight);
      }
    };

    xhttp.open("GET", "charger_message.php?idconv=" + actconv + "&id=" + userID, true);
    xhttp.send();

  }
}