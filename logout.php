<?php
$message = "Anda Berhasil Logout";
session_start();
session_unset();
header("Location: index.php");