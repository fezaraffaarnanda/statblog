<?php

/*
 * Tujuan: Memproses input dan mengatur akses berdasarkan peran pengguna.
 *
 * File ini digunakan untuk mengatur logika dan alur aplikasi terkait manajemen topik.
 * Beberapa hal yang dilakukan antara lain:
 * - Memuat file-file yang diperlukan seperti database, middleware, dan validator.
 * - Menginisialisasi variabel dan array yang akan digunakan.
 * - Memeriksa tindakan yang dilakukan oleh pengguna (seperti menambahkan, menghapus, atau memperbarui topik).
 * - Melakukan validasi input pengguna menggunakan fungsi validateTopic().
 * - Mengarahkan pengguna ke halaman yang sesuai dan menampilkan pesan kesalahan atau keberhasilan.
 * - Menerapkan batasan akses berdasarkan peran pengguna menggunakan fungsi adminOnly().
 */


include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");

$table = 'topics';

$errors = array();
$id = '';
$name = '';
$description = '';

$topics = selectAll($table);


if (isset($_POST['add-topic'])) {
    adminOnly();
    $errors = validateTopic($_POST);

    if (count($errors) === 0) {
        unset($_POST['add-topic']);
        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Topik berhasil dibuat';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit(); 
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectOne($table, ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}

if (isset($_GET['del_id'])) {
    adminOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    $_SESSION['message'] = 'Topik berhasil dihapus';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
}


if (isset($_POST['update-topic'])) {
    adminOnly();
    $errors = validateTopic($_POST);

    if (count($errors) === 0) { 
        $id = $_POST['id'];
        unset($_POST['update-topic'], $_POST['id']);
        $topic_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Topik berhasil diupdate';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }

}
