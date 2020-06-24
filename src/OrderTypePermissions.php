<?php

namespace Drupal\commerce_more_tools;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\commerce_order\Entity\OrderType;

/**
 * Provides dynamic permissions for order types.
 */
class OrderTypePermissions {

  use StringTranslationTrait;

  /**
   * Returns an array of order type permissions.
   */
  public function orderTypePermissions() {
    $perms = [];
    foreach (OrderType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of product order type permissions.
   *
   * @param \Drupal\commerce_order\Entity\OrderType $type
   *   The commerce order type.
   */
  protected function buildPermissions(OrderType $type) {
    $type_id = $type->id();
    $type_params = ['%type_name' => $type->label()];

    return [
      "own store view order type $type_id" => [
        'title' => $this->t('[Own commerce store] %type_name: View commerce order', $type_params),
      ],
      "own store edit order type $type_id" => [
        'title' => $this->t('[Own commerce store] %type_name: Edit commerce order', $type_params),
      ],
      "own store delete order type $type_id" => [
        'title' => $this->t('[Own commerce store] %type_name: Delete commerce order', $type_params),
      ],
    ];
  }

}
