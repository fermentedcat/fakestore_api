<?php

class Products {
  private static $limit;
  private static $category;
  private static $categories = array('men', 'women', 'jewelry', 'electronics');
  private static $errors = array();

  
  public static function Main($products) {
    $limit = self::getLimit();
    $category = self::getCategory();
    if ($limit) self::setLimit($limit);
    if ($category) self::setLimit($category);
    if (self::$errors) self::renderData(self::$errors);
    else self::renderData($products);

  }
  /*****************************
   * Get value from querystring
  ****************************** */
  private static function getQuery($key) {
    if (isset($_GET[$key])) return htmlspecialchars($_GET[$key]);
  }
  /*****************************
   * Set limit
  ****************************** */
  private static function setLimit($limit) {
    self::$limit = $limit;
  }
  /*****************************
   * Set category
  ****************************** */
  private static function setCategory($category) {
    self::$category = $category;
  }

  /*****************************
   * Get limit and validate
  ****************************** */
  private static function getLimit() {
    $limit = self::getQuery('limit');
    if ($limit && (!is_numeric($limit) || ( $limit > 20 || $limit < 1 ))) {
      $error = array('Error' => 'Limit needs to be set to a number between 1 and 20');
      array_push(self::$errors, $error);
    } else {
      self::setLimit($limit);
    }
  }

  /******************************
   * Get category and validate
  ****************************** */
  private static function getCategory() {
    $category = self::getQuery('category');
    if ($category && (!in_array($category, self::$categories))) {
      $error = array('Error' => 'Valid categories are: ' . join(', ', self::$categories));
      array_push(self::$errors, $error);
    } else {
      self::setCategory($category);
    }
  }

  /****************************************
   * Render products array in json format
  ***************************************** */
  public static function renderData($array) {
    $products = $array;
    echo json_encode($products, JSON_UNESCAPED_UNICODE);
  }
}