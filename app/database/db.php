<?php
/*
 * Tujuan: Membuat file db.php yang berisi fungsi-fungsi reusable untuk berinteraksi dengan database.
 *
 * Fungsi-fungsi ini memudahkan penggunaan query ke database dengan memanfaatkan objek koneksi $conn yang telah dibuat pada file connect.php.
 * Beberapa fungsi yang ada antara lain:
 * - dd($value): Menampilkan value dengan tata letak yang terstruktur dan menghentikan eksekusi program.
 * - executeQuery($sql, $data): Menjalankan query dengan parameter yang sudah di-bind menggunakan metode prepared statement.
 * - selectAll($table, $conditions): Mengambil semua baris data dari tabel yang ditentukan dengan kondisi yang diberikan.
 * - selectOne($table, $conditions): Mengambil satu baris data dari tabel yang ditentukan berdasarkan kondisi yang diberikan.
 * - create($table, $data): Membuat data baru (insert data) ke dalam tabel yang ditentukan.
 * - update($table, $id, $data): Mengupdate data dalam tabel yang ditentukan berdasarkan ID yang diberikan.
 * - delete($table, $id): Menghapus data dalam tabel yang ditentukan berdasarkan ID yang diberikan.
 * - getPublishedPosts(): Mengambil semua posting yang telah dipublikasikan beserta informasi pengguna yang berhubungan.
 * - getPostsByTopicId($topic_id): Mengambil semua posting yang telah dipublikasikan dan terkait dengan topik yang ditentukan.
 * - searchPosts($term): Mencari posting yang telah dipublikasikan berdasarkan kata kunci yang cocok dengan judul atau isi posting.
 * 
 */

session_start();
require('connect.php');



function dd($value) 
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

function executeQuery($sql, $data)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}

function selectAll($table, $conditions = [])
{
    global $conn;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
        
        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}


function selectOne($table, $conditions) // memiliki tugas untuk mengambil satu baris data dari tabel yang ditentukan berdasarkan kondisi yang diberikan.
{
    global $conn;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_assoc();
    return $records;
}


function create($table, $data) // function buat create data (insert data)
{
    global $conn;
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}



function update($table, $id, $data) // update data
{
    global $conn;
    $sql = "UPDATE $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}



function delete($table, $id)  // deletee
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";

    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
}


function getPublishedPosts()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=?";

    $stmt = executeQuery($sql, ['published' => 1]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


function getPostsByTopicId($topic_id)
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=?";

    $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}



function searchPosts($term)
{
    $match = '%' . $term . '%';
    global $conn;
    $sql = "SELECT 
                p.*, u.username 
            FROM posts AS p 
            JOIN users AS u 
            ON p.user_id=u.id 
            WHERE p.published=?
            AND p.title LIKE ? OR p.body LIKE ?";


    $stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}