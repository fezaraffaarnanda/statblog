<?php

/*
 * Tujuan: Memproses input dan mengatur akses berdasarkan peran pengguna.
 *
 * File ini digunakan untuk mengatur logika dan alur aplikasi terkait manajemen postingan.
 * Beberapa hal yang dilakukan antara lain:
 * - Memuat file-file yang diperlukan seperti database, middleware, dan validator.
 * - Menginisialisasi variabel dan array yang akan digunakan.
 * - Memeriksa tindakan yang dilakukan oleh pengguna (seperti menambahkan, menghapus, atau memperbarui postingan).
 * - Melakukan validasi input pengguna menggunakan fungsi validatePost().
 * - Mengarahkan pengguna ke halaman yang sesuai dan menampilkan pesan kesalahan atau keberhasilan.
 * - Menerapkan batasan akses berdasarkan peran pengguna menggunakan fungsi adminOnly().
 *
 */


include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");

$table = 'posts';

$topics = selectAll('topics');
$posts = selectAll($table);


$errors = array();
$id = "";
$title = "";
$body = "";
$topic_id = "";
$published = "";

if (isset($_GET['id'])) {
    $post = selectOne($table, ['id' => $_GET['id']]);

    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
}

if (isset($_GET['delete_id'])) {
    adminOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Konten dihapus!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php"); 
    exit();
}

if (isset($_GET['published']) && isset($_GET['p_id'])) {
    adminOnly();
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['published' => $published]);
    $_SESSION['message'] = "Berhasil dipublikasi";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php"); 
    exit();
}

if (isset($_POST['add-post'])) {
    adminOnly();
    $errors = validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
           $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Gagal upload gambar");
        }
    } else {
       array_push($errors, "Upload Gambar!");
    }
    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
    
        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Konten berhasil dibuat";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php"); 
        exit();    
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
}


if (isset($_POST['update-post'])) {
    adminOnly();
    $errors = validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
           $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Gagal upload gambar!");
        }
    } else {
       array_push($errors, "Upload gambar!");
    }

    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
    
        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = "Konten diupdate!";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php");       
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
    }

}