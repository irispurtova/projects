<?php
$connect = mysqli_connect(
    'localhost',
    'root',
    '',
    'projects');

if (!$connect) {
    echo 'Error!';
}
?>