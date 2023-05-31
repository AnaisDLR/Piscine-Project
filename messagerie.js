function init() {
  actconv = null;
}

function changeConv(conv) {
  actconv = conv;

  header = document.getElementById(conv).children[0].innerHTML;
  header += "<span style='margin-left:5%; font-size: 2em'>" + document.getElementById(conv).children[1].innerHTML + "</span>";
  document.getElementById("conv_header").innerHTML = header;


  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("conv_body").innerHTML = this.responseText;
      if (document.getElementsByClassName("conv_act")[0])
        document.getElementsByClassName("conv_act")[0].classList.remove("conv_act");
      document.getElementById(conv).classList.add("conv_act");
    }
  };

  xhttp.open("GET", "charger_message.php?idd=" + conv, true);
  xhttp.send();

}