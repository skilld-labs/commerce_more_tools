<?php

namespace Drupal\commerce_more_tools;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\commerce_store\Entity\StoreType;

/**
 * Provides dynamic permissions for stores.
 */
class StoreTypePermissions {

  use StringTranslationTrait;

  /**
   * Returns an array of store type permissions.
   */
  public function storeTypePermissions() {
    $perms = [];
    foreach (StoreType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of store type permissions.
   *
   * @param \Drupal\commerce_store\Entity\StoreType $type
   *   The commerce store type.
   */
  protected function buildPermissions(StoreType $type) {
    $type_id = $type->id();
    $type_params = ['%type_name' => $type->label()];

    return [
      "own store $type_id change owner" => [
        'title' => $this->t('[Own commerce store] %type_name: Change store owner', $type_params),
      ],
    ];
  }

}
