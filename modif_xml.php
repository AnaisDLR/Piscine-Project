<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $correct = 1;
  if (!isset($_POST["xml"]) || empty($_POST["xml"])) {
    echo "Erreur xml\n";
    $correct = 0;
  }

  if ($correct) {
    $fp = fopen("profils.xml", "w");
    fwrite($fp, "<?xml version='1.0' encoding='UTF-8'?>" . $_POST["xml"]);
  }
}