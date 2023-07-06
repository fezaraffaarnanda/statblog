<?php
/*
 * Tujuan: Mendefinisikan konstanta ROOT_PATH dan BASE_URL.
 *
 * File ini digunakan untuk mendefinisikan konstanta yang diperlukan dalam aplikasi.
 * Konstanta ROOT_PATH adalah path absolut ke direktori root aplikasi.
 * Konstanta BASE_URL adalah URL dasar aplikasi.
 * Konstanta-konstanta ini akan digunakan dalam file-file lain untuk memudahkan akses file dan URL.
 */
define("ROOT_PATH", realpath(dirname(__FILE__)));
define("BASE_URL", "http://localhost/StatBlog"); // untuk kemudahan dalam akses file nantinya, baik pas sudah deploy ke hostingan maupun nanti pas coba-coba
