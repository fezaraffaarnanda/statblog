<?php
/*
 * Tujuan: Menampilkan pesan error jika terdapat error dalam array $errors.
 *
 * Jika terdapat error dalam array $errors, kode ini akan menampilkan pesan error dengan menggunakan class CSS "msg error".
 * Setiap pesan error akan ditampilkan dalam elemen <li>.
 *
 */
if(count($errors) > 0): ?>
    <div class="msg error">
    <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
    <?php endforeach; ?>
    </div>
<?php endif; ?>