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
class CommercePaymentCollectionAccessCheck implements AccessInterface {

  /**
   * {@inheritdoc}
   */
  public function access(Route $route, RouteMatchInterface $route_match, AccountInterface $account) {
    /** @var \Drupal\commerce_order\Entity\Order $order */
    $order = $route_match->getParameter('commerce_order');
    if ($order) {
      if ($order->getStore()->getOwner()->id() == $account->id()) {
        return AccessResult::allowedIfHasPermission($account, 'own store manage payments');
      }
      return AccessResult::allowedIfHasPermission($account, 'administer commerce_payment');
    }
    return AccessResult::forbidden();
  }

}
