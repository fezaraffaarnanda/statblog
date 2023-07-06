<?php
/*
 * Tujuan: Membuat fungsi-fungsi untuk membatasi akses berdasarkan peran pengguna.
 *
 * Fungsi-fungsi ini digunakan untuk memeriksa peran pengguna dan mengarahkan pengguna ke halaman yang sesuai jika ada pembatasan akses.
 *
 * Fungsi-fungsi yang ada antara lain:
 * - usersOnly($redirect = '/index.php'): Memeriksa apakah pengguna telah login. Jika belum, akan mengarahkan pengguna ke halaman login dengan pesan error.
 * - adminOnly($redirect = '/index.php'): Memeriksa apakah pengguna memiliki peran sebagai admin. Jika tidak, akan mengarahkan pengguna ke halaman utama dengan pesan error.
 * - guestsOnly($redirect = '/index.php'): Memeriksa apakah pengguna masih dalam keadaan "guest" atau belum login. Jika sudah login, akan mengarahkan pengguna ke halaman utama.
 *
 */

function usersOnly($redirect = '/index.php')
{
    if (empty($_SESSION['id'])) {
        $_SESSION['message'] = 'Login dulu!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function adminOnly($redirect = '/index.php')
{
    if (empty($_SESSION['id']) || empty($_SESSION['admin'])) {
        $_SESSION['message'] = 'Tidak ada izin!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}

function guestsOnly($redirect = '/index.php')
{
    if (isset($_SESSION['id'])) {
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }    
}