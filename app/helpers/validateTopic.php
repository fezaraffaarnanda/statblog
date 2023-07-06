<?php
/*
 * Fungsi validatePost($post) digunakan untuk memvalidasi data postingan sebelum disimpan.
 * Fungsi ini mengembalikan array berisi pesan kesalahan jika ada kesalahan validasi.
 */

function validateTopic($topic)
{
    $errors = array();

    if (empty($topic['name'])) {
        array_push($errors, 'Masukkan nama');
    }

     // Validasi nama unik
    $existingTopic = selectOne('topics', ['name' => $post['name']]);
    if ($existingTopic) {
        if (isset($post['update-topic']) && $existingTopic['id'] != $post['id']) {
            array_push($errors, 'Nama sudah ada');
        }

        if (isset($post['add-topic'])) {
            array_push($errors, 'Nama sudah ada');
        }
    }

    return $errors;
}
