<?php

namespace Drupal\commerce_more_tools\Plugin\EntityReferenceSelection;

use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;

/**
 * Provides specific access control for the commerce_store entity type.
 *
 * @EntityReferenceSelection(
 *   id = "default:commerce_store",
 *   label = @Translation("Store selection"),
 *   entity_types = {"commerce_store"},
 *   group = "default",
 *   weight = 1
 * )
 */
class StoreSelection extends DefaultSelection {

  /**
   * {@inheritdoc}
   */
  protected function buildEntityQuery($match = NULL, $match_operator = 'CONTAINS') {
    $query = parent::buildEntityQuery($match, $match_operator);
    $target_type = $this->configuration['target_type'];
    $entity_type = $this->entityManager->getDefinition($target_type);
    // Do not alter access if user has admin permission or is allowed to view any store.
    if ($this->currentUser->hasPermission($entity_type->getAdminPermission()) || $this->currentUser->hasPermission('view commerce_store')) {
      return $query;
    }
    if (!$this->currentUser->hasPermission('reference any store')) {
      $query->condition('uid', $this->currentUser->id());
    }

    return $query;
  }

}
