<?php

/*
 * Fungsi validatePost($post) digunakan untuk memvalidasi data postingan sebelum disimpan.
 * Fungsi ini mengembalikan array berisi pesan kesalahan jika ada kesalahan validasi.
 */

function validatePost($post)
{
    $errors = array();

    // Validasi judul
    if (empty($post['title'])) {
        array_push($errors, 'Masukkan judul');
    }

     // Validasi konten
    if (empty($post['body'])) {
        array_push($errors, 'Masukkan konten');
    }

     // Validasi topik
    if (empty($post['topic_id'])) {
        array_push($errors, 'Pilih topik');
    }

    // Validasi judul unik
    $existingPost = selectOne('posts', ['title' => $post['title']]);
    if ($existingPost) {
        if (isset($post['update-post']) && $existingPost['id'] != $post['id']) {
            array_push($errors, 'Postingan dengan judul itu sudah ada.');
        }

        if (isset($post['add-post'])) {
            array_push($errors, 'Postingan dengan judul itu sudah ada.');
        }
    }

    return $errors;
}