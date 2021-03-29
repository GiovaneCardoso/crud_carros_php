<?php

$host = "localhost:3307";
$user = "root";
$pwd = "";
$db = "automoveis";

$conn = new mysqli($host, $user, $pwd, $db);

$error = mysqli_connect_errno();
if($error){
    echo "Erro ao tentar se conectar com o banco de dados $error";
    exit();
}
