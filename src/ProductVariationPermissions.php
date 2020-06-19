<?php

namespace Drupal\commerce_more_tools;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\commerce_product\Entity\ProductVariationType;

/**
 * Provides dynamic permissions for product variation types.
 */
class ProductVariationPermissions {

  use StringTranslationTrait;

  /**
   * Returns an array of product variation type permissions.
   */
  public function productVariationTypePermissions() {
    $perms = [];
    foreach (ProductVariationType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of product variation permissions for a given type.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationType $type
   *   The commerce product variation type.
   */
  protected function buildPermissions(ProductVariationType $type) {
    $type_id = $type->id();
    $type_params = ['%type_name' => $type->label()];

    return [
      "own product create $type_id product_variation" => [
        'title' => $this->t('[Own commerce product] %type_name: Create new product variation', $type_params),
      ],
      "own product edit own $type_id product_variation" => [
        'title' => $this->t('[Own commerce product] %type_name: Edit own product variation', $type_params),
      ],
      "own product edit any $type_id product_variation" => [
        'title' => $this->t('[Own commerce product] %type_name: Edit any product variation', $type_params),
      ],
      "own product delete own $type_id product_variation" => [
        'title' => $this->t('[Own commerce product] %type_name: Delete own product variation', $type_params),
      ],
      "own product delete any $type_id product_variation" => [
        'title' => $this->t('[Own commerce product] %type_name: Delete any product variation', $type_params),
      ],
      "own product duplicate $type_id product_variation" => [
        'title' => $this->t('[Own commerce product] %type_name: Duplicate product variation', $type_params),
      ],
    ];
  }

}
