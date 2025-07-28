<?php
function conectar(){
    $host="localhost";
    $user="root";
    $pass="";
    $bd="especiales"; // Asegúrate de que este sea el nombre correcto de tu base de datos

    $con = mysqli_connect($host, $user, $pass, $bd);

    if (mysqli_connect_errno()) {
        echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
        exit();
    }
    return $con;
}
?>