<?php

namespace Drupal\commerce_more_tools\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\Routing\Route;

/**
 * Defines a custom access checker for the payment collection route.
 */
class CommerceOrderReassignAccessCheck implements AccessInterface {

  /**
   * {@inheritdoc}
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    /** @var \Drupal\commerce_order\Entity\Order $order */
    $order = $route_match->getParameter('commerce_order');
    if ($order) {
      $order_type = $order->bundle();
      if ($order->getStore()->getOwner()->id() == $account->id()) {
        return AccessResult::allowedIfHasPermission($account, "own store reassign order type $order_type");
      }
      return AccessResult::allowedIfHasPermission($account, 'administer commerce_order');
    }
    return AccessResult::forbidden();
  }

}
