function init(user) {
  userID = user;
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
      var util = xmlDoc.getElementById(userID);
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







function modifier_formations(userID) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {

    // Request finished and response
    // is ready and Status is "OK"
    if (this.readyState == 4 && this.status == 200) {
      var xmlDoc = this.responseXML;
      var table =
        `<form id='formformation' action="" method="post">
          <table class="table table-striped">
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
                    <th><button type='button' class='btn btn-primary' onclick='addformations()'>+</button></th>
                </tr>
            </tbody>
            <tbody>`;
      var util = xmlDoc.getElementById(userID);
      var x = util.getElementsByTagName("formation");

      // Start to fetch the data by using TagName
      for (let i = 0; i < x.length; i++) {
        table +=
          "<tr><td><input type='text' name='intitule[]' value='" +
          (x[i].getElementsByTagName("intitulé")[0].childNodes.length ?
            x[i].getElementsByTagName("intitulé")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='duree[]' value='" +
          (x[i].getElementsByTagName("durée")[0].childNodes.length ?
            x[i].getElementsByTagName("durée")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='competence[]' value='" +
          (x[i].getElementsByTagName("compétence")[0].childNodes.length ?
            x[i].getElementsByTagName("compétence")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='date[]' value='" +
          (x[i].getElementsByTagName("date")[0].childNodes.length ?
            x[i].getElementsByTagName("date")[0].childNodes[0].nodeValue : "")
          + "'></td><td><button type='button' class='btn btn-primary' onclick='this.parentElement.parentElement.remove()'>Supprimer</button></td></tr>";
      }

      table += "</tbody></table><button type='submit' class='btn btn-primary'>Appliquer</button></form>";
      document.getElementById("formations").innerHTML = table;
      document.getElementById("formations").scrollIntoView();

      const form = document.getElementById("formformation");

      form.addEventListener("submit", (event) => {
        event.preventDefault();

        var xhttp = new XMLHttpRequest();
        var FD = new FormData(form);
        let intitule = FD.getAll("intitule[]");
        let duree = FD.getAll("duree[]");
        let competence = FD.getAll("competence[]");
        let date = FD.getAll("date[]");
        xmlDoc.getElementById(userID).getElementsByTagName("formations")[0].innerHTML = null;
        for (let i = 0; i < intitule.length; i++) {
          let intituleNode = document.createElement("intitulé");
          intituleNode.appendChild(document.createTextNode(intitule[i]));
          let dureeNode = document.createElement("durée");
          dureeNode.appendChild(document.createTextNode(duree[i]));
          let competenceNode = document.createElement("compétence");
          competenceNode.appendChild(document.createTextNode(competence[i]));
          let dateNode = document.createElement("date");
          dateNode.appendChild(document.createTextNode(date[i]));

          let formation = document.createElement("formation");
          formation.appendChild(intituleNode);
          formation.appendChild(dureeNode);
          formation.appendChild(competenceNode);
          formation.appendChild(dateNode);
          xmlDoc.getElementById(userID).getElementsByTagName("formations")[0].appendChild(formation);
        }
        FD = new FormData();
        FD.append("xml", new XMLSerializer().serializeToString(xmlDoc.documentElement).replace(/xmlns=\"(.*?)\"/g, ''))

        xhttp.addEventListener("load", (event) => {
          if (event.target.responseText)
            alert(event.target.responseText);
          location.reload();
        });

        xhttp.addEventListener("error", (event) => {
          alert('Une erreur est survenue.');
        });

        xhttp.open("POST", "modif_xml.php");
        xhttp.send(FD);
      }, {
        once: false
      });
    }
  };
  // etudiants.xml is the external xml file
  xmlhttp.open("GET", "profils.xml", true);
  xmlhttp.send();
}

function addformations() {
  select = document.getElementById("formations").getElementsByTagName("tbody")[1];
  clone = select.children[0].cloneNode(true);
  clone.children[0].required = 0;
  for (let i = 0; i < clone.children.length - 1; i++) {
    clone.children[i].children[0].value = "";
  }
  select.appendChild(clone);
}








function modifier_projets(userID) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {

    // Request finished and response
    // is ready and Status is "OK"
    if (this.readyState == 4 && this.status == 200) {
      var xmlDoc = this.responseXML;
      var table =
        `<form id='formprojet' action="" method="post">
          <table class="table table-striped">
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
                  <th><button type='button' class='btn btn-primary' onclick='addprojets()'>+</button></th>
              </tr>
          </tbody>
          <tbody>`;
      var util = xmlDoc.getElementById(userID);
      var x = util.getElementsByTagName("projet");

      // Start to fetch the data by using TagName
      for (let i = 0; i < x.length; i++) {
        table +=
          "<tr><td><input type='text' name='intitule[]' value='" +
          (x[i].getElementsByTagName("intitulé")[0].childNodes.length ?
            x[i].getElementsByTagName("intitulé")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='duree[]' value='" +
          (x[i].getElementsByTagName("durée")[0].childNodes.length ?
            x[i].getElementsByTagName("durée")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='fonction[]' value='" +
          (x[i].getElementsByTagName("fonction")[0].childNodes.length ?
            x[i].getElementsByTagName("fonction")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='lien[]' value='" +
          (x[i].getElementsByTagName("lien")[0].childNodes.length ?
            x[i].getElementsByTagName("lien")[0].childNodes[0].nodeValue : "")
          + "'></td><td><input type='text' name='description[]' value='" +
          (x[i].getElementsByTagName("description")[0].childNodes.length ?
            x[i].getElementsByTagName("description")[0].childNodes[0].nodeValue : "")
          + "'></td><td><button type='button' class='btn btn-primary' onclick='this.parentElement.parentElement.remove()'>Supprimer</button></td></tr>";
      }

      table += "</tbody></table><button type='submit' class='btn btn-primary'>Appliquer</button></form>";
      document.getElementById("projets").innerHTML = table;
      document.getElementById("projets").scrollIntoView();

      const form = document.getElementById("formprojet");

      form.addEventListener("submit", (event) => {
        event.preventDefault();

        var xhttp = new XMLHttpRequest();
        var FD = new FormData(form);
        let intitule = FD.getAll("intitule[]");
        let duree = FD.getAll("duree[]");
        let fonction = FD.getAll("fonction[]");
        let lien = FD.getAll("lien[]");
        let description = FD.getAll("description[]");
        xmlDoc.getElementById(userID).getElementsByTagName("projets")[0].innerHTML = null;
        for (let i = 0; i < intitule.length; i++) {
          let intituleNode = document.createElement("intitulé");
          intituleNode.appendChild(document.createTextNode(intitule[i]));
          let dureeNode = document.createElement("durée");
          dureeNode.appendChild(document.createTextNode(duree[i]));
          let fonctioneNode = document.createElement("fonction");
          fonctioneNode.appendChild(document.createTextNode(fonction[i]));
          let lienNode = document.createElement("lien");
          lienNode.appendChild(document.createTextNode(lien[i]));
          let descriptionNode = document.createElement("description");
          descriptionNode.appendChild(document.createTextNode(description[i]));

          let projet = document.createElement("projet");
          projet.appendChild(intituleNode);
          projet.appendChild(dureeNode);
          projet.appendChild(fonctioneNode);
          projet.appendChild(lienNode);
          projet.appendChild(descriptionNode);
          xmlDoc.getElementById(userID).getElementsByTagName("projets")[0].appendChild(projet);
        }
        FD = new FormData();
        FD.append("xml", new XMLSerializer().serializeToString(xmlDoc.documentElement).replace(/xmlns=\"(.*?)\"/g, ''))

        xhttp.addEventListener("load", (event) => {
          if (event.target.responseText)
            alert(event.target.responseText);
          location.reload();
        });

        xhttp.addEventListener("error", (event) => {
          alert('Une erreur est survenue.');
        });

        xhttp.open("POST", "modif_xml.php");
        xhttp.send(FD);
      }, {
        once: false
      });
    }
  };
  // etudiants.xml is the external xml file
  xmlhttp.open("GET", "profils.xml", true);
  xmlhttp.send();
}

function addprojets() {
  select = document.getElementById("projets").getElementsByTagName("tbody")[1];
  clone = select.children[0].cloneNode(true);
  clone.children[0].required = 0;
  for (let i = 0; i < clone.children.length - 1; i++) {
    clone.children[i].children[0].value = "";
  }
  select.appendChild(clone);
}








function modifier_photo() {
  document.getElementById("modif_photo").style.display = "block";
}
function modifier_banniere() {
  document.getElementById("modif_banniere").style.display = "block";
}