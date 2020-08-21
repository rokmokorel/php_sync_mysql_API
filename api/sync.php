<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Tabela_glavna.php';
include_once '../models/Tabela_sub.php';

$database = new Database();
$db = $database->connect();

$main_tabela = new Tabela_glavna($db);
$sub_tabela_si = new Tabela_sub($db, 'custom_prices_si');
$sub_tabela_hr = new Tabela_sub($db, 'custom_prices_hr');

// preverjamo vrednost poslano z GET requestom
if ($_GET["sync-custom-prices"] == "all") {
  // pobrisemo vsebimo podpornih tabel
  $sub_tabela_si->brisi();
  $sub_tabela_hr->brisi();

  // poizvedba podatkov iz glavne tabele
  $stmt = $main_tabela->beri();
  $num = $stmt->rowCount();

  // v podporne tabele vpisujemo le, če glavna tabela 
  // vsebuje podatke
  if ($num > 0) {
    // vsebuje podatke z glavne tabele
    $podatki_tabela = array();

    while ($vrstica = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($vrstica);

      $artikel = array(
        "id" => $id,
        "main_skus" => $main_skus,
        "related_skus" => $related_skus,
        "regular_price_si" => $regular_price_si,
        "sale_price_si" => $sale_price_si,
        "regular_price_hr" => $regular_price_hr,
        "sale_price_hr" => $sale_price_hr
      );
      // shranjeno podatke iz glavne tabele 
      // potisnemo v spremenljivko
      array_push($podatki_tabela, $artikel);
    }
  
    // zbrane vrednosti vnesemo v podporni tabeli
    $sub_tabela_si->vpisi_podatke($podatki_tabela);
    $sub_tabela_hr->vpisi_podatke($podatki_tabela);
  }
}
