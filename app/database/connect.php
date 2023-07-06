<?php
/*
 * Tujuan: Membuat koneksi ke database MySQL menggunakan objek MySQLi.
 */
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'statblog_2';

$conn = new MySQLi($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Ada error: ' . $conn->connect_error);
}
