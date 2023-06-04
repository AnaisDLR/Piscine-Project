function init(user) {
    amiID = user;
  }
  
  
  function loadXMLDoc() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
  
      // Request finished and response
      // is ready and Status is "OK"
      if (this.readyState == 4 && this.status == 200) {
        var xmlDoc = this.responseXML;
        var table =
          `<table class="table table-striped">
            <thead>
                <tr>
                    <h3>Formations</h3>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Intitulé</th>
                    <th>Durée</th>
                    <th>Compétences acquises</th>
                    <th>Date</th>
                </tr>
            </tbody>
            <tbody>`;
        var util = xmlDoc.getElementById(amiID);
        var x = util.getElementsByTagName("formation");
  
        var ok = [];
        var min = "";
        var imin;
        // Start to fetch the data by using TagName
        for (let i = 0; i < x.length; i++) {
          min = "0"
          for (var j = 0; j < x.length; j++) {
            if ((min == "0" || (x[j].getElementsByTagName("date")[0].childNodes.length ?
              x[j].getElementsByTagName("date")[0].childNodes[0].nodeValue : "") < min) && !ok.includes(j)) {
              min = (x[j].getElementsByTagName("date")[0].childNodes.length ?
                x[j].getElementsByTagName("date")[0].childNodes[0].nodeValue : "");
              imin = j;
            }
          }
          ok.push(imin);
          table +=
            "<tr><td>" +
            (x[imin].getElementsByTagName("intitulé")[0].childNodes.length ?
              x[imin].getElementsByTagName("intitulé")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[imin].getElementsByTagName("durée")[0].childNodes.length ?
              x[imin].getElementsByTagName("durée")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[imin].getElementsByTagName("compétence")[0].childNodes.length ?
              x[imin].getElementsByTagName("compétence")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[imin].getElementsByTagName("date")[0].childNodes.length ?
              x[imin].getElementsByTagName("date")[0].childNodes[0].nodeValue : "")
            + "</td></tr>";
        }
        table += "</tbody></table>";
  
        document.getElementById("formations").innerHTML = table;
  
  
  
        table =
          `<table class="table table-striped">
            <thead>
                <tr>
                    <h3>Projets</h3>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Intitulé</th>
                    <th>Durée</th>
                    <th>Fonction</th>
                    <th>Lien du projet</th>
                    <th>Description</th>
                </tr>
            </tbody>
            <tbody>`;
        x = util.getElementsByTagName("projet");
  
        // Start to fetch the data by using TagName
        for (let i = 0; i < x.length; i++) {
          table +=
            "<tr><td>" +
            (x[i].getElementsByTagName("intitulé")[0].childNodes.length ?
              x[i].getElementsByTagName("intitulé")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[i].getElementsByTagName("durée")[0].childNodes.length ?
              x[i].getElementsByTagName("durée")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[i].getElementsByTagName("fonction")[0].childNodes.length ?
              x[i].getElementsByTagName("fonction")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[i].getElementsByTagName("lien")[0].childNodes.length ?
              x[i].getElementsByTagName("lien")[0].childNodes[0].nodeValue : "")
            + "</td><td>" +
            (x[i].getElementsByTagName("description")[0].childNodes.length ?
              x[i].getElementsByTagName("description")[0].childNodes[0].nodeValue : "")
            + "</td></tr>";
        }
  
        table += "</tbody></table>";
        document.getElementById("projets").innerHTML = table;
      }
    };
    // etudiants.xml is the external xml file
    xmlhttp.open("GET", "profils.xml", true);
    xmlhttp.send();
}