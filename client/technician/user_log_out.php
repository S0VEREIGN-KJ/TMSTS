<?php
session_start();


if(isset($_SESSION['id_number']))
{
    unset($_SESSION['id_number']);
}
 header("Location: ../index.php");
 die;
?>