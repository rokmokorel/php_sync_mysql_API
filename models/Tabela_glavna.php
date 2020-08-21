<?php

class Tabela_glavna
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // brisanje vsebine tabele
  public function brisi()
  {
    $query = "TRUNCATE TABLE custom_prices_general";
    $statement = $this->conn->prepare($query);

    if ($statement->execute()) {
      echo "brisanje uspelo\n";
    } else {
      echo "brisanje neuspelo\n";
    };
  }

  // poizvedba podatkov tabele
  public function beri()
  {
    $query = "SELECT
          id, main_skus, related_skus, regular_price_si, 
          sale_price_si, regular_price_hr, sale_price_hr
        FROM custom_prices_general ";

    $statement = $this->conn->prepare($query);
    $statement->execute();

    return $statement;
  }

  // vpisovanje podatkov iz json v tabelo
  public function vpisi()
  {
    $string = file_get_contents("http://localhost/kupihitro/artikli.json");
    $data_arr = json_decode($string, true);

    for ($iter = 0; $iter < count($data_arr); $iter++) {
      $query = "INSERT INTO custom_prices_general 
        (id, main_skus, related_skus, 
        regular_price_si, sale_price_si, 
        regular_price_hr, sale_price_hr) 
      VALUES 
        (NULL, :main_skus, :related_skus , :regular_price_si, 
        :sale_price_si, :regular_price_hr, :sale_price_hr);";


      $statement = $this->conn->prepare($query);

      $statement->bindParam(":main_skus", $data_arr[$iter]["main_skus"]);
      $statement->bindParam(":related_skus", $data_arr[$iter]["related_skus"]);
      $statement->bindParam(
        ":regular_price_si",
        $data_arr[$iter]["regular_price_si"]
      );
      $statement->bindParam(
        ':sale_price_si',
        $data_arr[$iter]["sale_price_si"]
      );
      $statement->bindParam(
        ':regular_price_hr',
        $data_arr[$iter]["regular_price_hr"]
      );
      $statement->bindParam(
        ':sale_price_hr',
        $data_arr[$iter]["sale_price_hr"]
      );

      if ($statement->execute()) {
        echo "pisanje uspelo" . "\n";
      } else {
        echo "pisanje baze neuspelo" . "\n";
      }
    }
  }
}
