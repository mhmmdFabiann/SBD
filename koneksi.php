<?php
    $host = 'localhost';
    $username ='root' ;
    $password = '';
    $db_name ='e_learning_update'; // nama database
    $conn = new mysqli( $host, $username, $password, $db_name );
    if (!$conn){
        die('Koneksi Gagal'.mysqli_error($conn));
    }
?>