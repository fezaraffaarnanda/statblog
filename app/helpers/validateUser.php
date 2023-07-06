<?php

/*
 * Fungsi validateUser($user) digunakan untuk memvalidasi data pengguna sebelum disimpan atau digunakan untuk login.
 * Fungsi ini mengembalikan array berisi pesan kesalahan jika ada kesalahan validasi.
 */

function validateUser($user)
{
    $errors = array();

    if (empty($user['username'])) {
        array_push($errors, 'Masukkan username');
    }

    if (empty($user['email'])) {
        array_push($errors, 'Masukkan email');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Masukkan password');
    }

    if ($user['passwordConf'] !== $user['password']) {
        array_push($errors, 'Password tidak sama!');
    }

    // $existingUser = selectOne('users', ['email' => $user['email']]);
    // if ($existingUser) {
    //     array_push($errors, 'Email already exists');
    // }

    $existingUser = selectOne('users', ['email' => $user['email']]);
    if ($existingUser) {
        if (isset($user['update-user']) && $existingUser['id'] != $user['id']) {
            array_push($errors, 'Email sudah ada!');
        }

        if (isset($user['create-admin'])) {
            array_push($errors, 'Email sudah ada!');
        }
    }

    return $errors;
}


/*
 * Fungsi validateLogin($user) digunakan untuk memvalidasi data pengguna saat login.
 * Fungsi ini mengembalikan array berisi pesan kesalahan jika ada kesalahan validasi.
 */

function validateLogin($user)
{
    $errors = array();

    if (empty($user['username'])) {
        array_push($errors, 'Masukkan username');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Masukkan username');
    }

    return $errors;
}