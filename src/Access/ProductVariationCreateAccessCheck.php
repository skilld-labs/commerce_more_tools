<?php

namespace Drupal\commerce_more_tools\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Drupal\commerce_product\Access\ProductVariationCreateAccessCheck as ProductVariationCreateAccessCheckBase;

/**
 * Defines an access checker for own product variation creation.
 */
class ProductVariationCreateAccessCheck extends ProductVariationCreateAccessCheckBase {

  /**
   * {@inheritdoc}
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $route_match->getParameter('commerce_product');
    if ($product && $product->getOwnerId() == $account->id()) {
      $product_type_storage = $this->entityTypeManager->getStorage('commerce_product_type');
      /** @var \Drupal\commerce_product\Entity\ProductTypeInterface $product_type */
      $product_type = $product_type_storage->load($product->bundle());
      $variation_type_id = $product_type->getVariationTypeId();
      return parent::access($route, $route_match, $account)->orIf(AccessResult::allowedIfHasPermission($account, "own product create $variation_type_id product_variation"));
    }
    return parent::access($route, $route_match, $account);
  }

}
