<?php

class Products {
  private static $limit = 20;
  private static $category;
  private static $categories = array('men', 'women', 'jewelry', 'electronics');
  private static $errors = array();

  /*****************************
   * Main method:
   * - Look for queries / errors
   * - Render errors or product data
  ****************************** */
  public static function Main($products) {
    self::getLimit();
    self::getCategory();
    if (self::$errors) self::renderData(self::$errors);
    else self::renderData(self::prepareProductsArray($products));
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
   * Get value from querystring
  ****************************** */
  private static function getQuery($key) {
    if (isset($_GET[$key])) return htmlspecialchars($_GET[$key]);
  }

  /*****************************
   * Get limit and validate
  ****************************** */
  private static function getLimit() {
    $limit = self::getQuery('limit');
    if (( $limit || $limit === '0' ) && ( !$limit || $limit > 20 || $limit < 1 )) {
      $error = array('Error' => 'Limit needs to be set to a number between 1 and 20');
      array_push(self::$errors, $error);
    } else if ($limit) {
      self::setLimit($limit);
    }
  }

  /******************************
   * Get category and validate
  ****************************** */
  private static function getCategory() {
    $category = strtolower(self::getQuery('category'));
    if (($category || $category ==='0') && !in_array($category, self::$categories)) {
      $error = array('Error' => 'Valid categories are: ' . join(', ', self::$categories));
      array_push(self::$errors, $error);
    } else {
      self::setCategory($category);
    }
  }

  /**********************************************
   * Filter products array by queried category
  ********************************************** */
  private static function filterArray($products) {
    $filtered = array_filter($products, function($product) {
      return $product['category'] === self::$category;
    });
    return $filtered;
  }

  /****************************************
   * Prepare products array for rendering:
   * - shuffle - filter - slice
  ***************************************** */
  private static function prepareProductsArray($products) {
    shuffle($products);
    if (self::$category) $products = self::filterArray($products);
    return array_slice($products, 0, self::$limit);
  }

  /****************************************
   * Render data in json format
  ***************************************** */
  private static function renderData($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
  }
}