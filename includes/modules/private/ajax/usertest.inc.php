<?php

if(!isset($_REQUEST['username']) || trim($_REQUEST['username']) == "")
    {
	echo "gefunden";
	exit;
    }

$con = AppDBO::getInstance();

$selectquery = "SELECT U_Id FROM Benutzer WHERE benutzername = :user AND valid = 1";

if(!($stm = $con->prepare($selectquery)))
    {
	echo "gefunden";
	exit;
    }

$stm->bindValue(":user", $_REQUEST['username']);
if(!($stm->execute()))
    {
	echo "gefunden";
	exit;
    }
if(!$stm->fetch())
    {
	echo "namen gibts nicht";
	exit;
    }
echo "gefunden";
exit;


?>