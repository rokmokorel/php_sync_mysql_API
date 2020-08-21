<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: plain/text; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Tabela_glavna.php';
include_once '../models/Tabela_sub.php';

$database = new Database();
$db = $database->connect();

$main_tabela = new Tabela_glavna($db);
$main_tabela->vpisi();
