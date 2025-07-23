<?php

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'barang':
        require 'views/barang.php';
        break;
    case 'bahan_baku':
        require 'views/bahan_baku.php';
        break;
    default:
        require 'views/index.php';
        break;
}