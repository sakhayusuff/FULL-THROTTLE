<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "racing_db"
);

if(!$conn){
    die("Koneksi gagal");
}

?>