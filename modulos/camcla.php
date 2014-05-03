<?php
session_start();
include("bd.php");
$NueCla = $_POST["NueCla"];
$result = $link->query("UPDATE usuarios SET Clave = '".$NueCla."' WHERE NRegistro = ".$_SESSION["CodUsuAct"]);