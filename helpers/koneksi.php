<?php
$host = "localhost"; // nama host database
$username = "root"; // username database
$password = ""; // password database
$database = "ofbsphp"; // nama database

// membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

//mengecek koneksi
if(mysqli_connect_errno()){
	echo "koneksi database gagal: ". mysqli_connect_error();
}
?>