<?php

namespace Drupal\commerce_more_tools\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\Routing\Route;
use Drupal\commerce_product\Access\ProductVariationCollectionAccessCheck as ProductVariationCollectionAccessCheckBase;

/**
 * Defines a custom access checker for the product variation collection route.
 *
 * We'll validate a new permission "access own commerce_product overview" permission.
 */
class ProductVariationCollectionAccessCheck extends ProductVariationCollectionAccessCheckBase {

  /**
   * {@inheritdoc}
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $product = $route_match->getParameter('commerce_product');
    if ($product && $product->getOwnerId() == $account->id()) {
      return parent::access($route, $route_match, $account)->orIf(AccessResult::allowedIfHasPermission($account, 'access own commerce_product overview'));
    }
    return parent::access($route, $route_match, $account);
  }

}
