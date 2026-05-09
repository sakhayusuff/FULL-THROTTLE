<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_gokart"
);

if(!$conn){
    die("Koneksi gagal");
}

?>