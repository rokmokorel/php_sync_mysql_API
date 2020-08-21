<?php

class Tabela_sub
{
  private $conn;
  private $name;

  public function __construct($db, $name)
  { 
    $this->conn = $db;
    $this->name = $name;
  }

  public function brisi()
  {

    $query = "TRUNCATE TABLE " . $this->name;
    $statement = $this->conn->prepare($query);

    if ($statement->execute()) {
      echo "brisanje uspelo\n";
    } else {
      echo "brisanje neuspelo\n";
    };
  }

  public function vpisi_podatke($data_arr){
    for ($iter = 0; $iter < count($data_arr); $iter++) {
      $query = "INSERT INTO " . $this->name . "
      (id, main_skus , related_skus , 
      regular_price , 
      sale_price ) 
      VALUES 
      (NULL, :main_skus, :related_skus , 
      :regular_price , :sale_price );";
      
      
      $statement = $this->conn->prepare($query);
      
      $drzava = explode("_",$this->name)[2];
      $statement->bindParam(":main_skus", $data_arr[$iter]["main_skus"]);
      $statement->bindParam(":related_skus", $data_arr[$iter]["related_skus"]);
      $statement->bindParam(
        ":regular_price",
        $data_arr[$iter]["regular_price_" . $drzava]
      );
      $statement->bindParam(
        ':sale_price',
        $data_arr[$iter]["sale_price_" . $drzava]
      );

      if ($statement->execute()) {
        echo "pisanje uspelo" . "\n";
      } else {
        echo "pisanje baze neuspelo" . "\n";
      }
    }
  }
}
