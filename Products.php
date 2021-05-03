<?php

class Products {
  private static $limit;
  private static $category;
  
  public static function Main($products) {
    self::renderData($products);
  }

  public static function renderData($array) {
    $products = $array;
    echo json_encode($products, JSON_UNESCAPED_UNICODE);
  }
}