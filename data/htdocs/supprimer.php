<?php

session_start();
include './utils/bdd.php';

if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $req=$bdd->prepare("DELETE FROM rdv where id= ? ");
    $req->execute(array($id));
    if($req)
    {
        header("location:recap.php");
    }

}






$cssacceuil="";
$jscarousel="";
$jspopup="";
$csscoordonnees="";
$cssrdv="";
$cssheader_footer="./style/header-footer.css";
$csscommon="./style/common.css";
$cssrecap="";

include './view/header.php';
include './view/footer.php';
?>