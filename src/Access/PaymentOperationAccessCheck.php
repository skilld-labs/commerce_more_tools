<?php

namespace Drupal\commerce_more_tools\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\commerce_payment\Access\PaymentOperationAccessCheck as PaymentOperationAccessCheckBase;

/**
 * Provides an extended checker for payment operations.
 */
class PaymentOperationAccessCheck extends PaymentOperationAccessCheckBase {

  /**
   * {@inheritdoc}
   */
  public function access(RouteMatchInterface $route_match, AccountInterface $account) {
    $commerce_payment = $route_match->getParameter('commerce_payment');
    if ($commerce_payment && $commerce_payment->getOrder()->getStore()->getOwner()->id() == $account->id()) {
      return AccessResult::allowedIfHasPermission($account, 'own store manage payments');
    }
    return parent::access($route_match, $account);
  }

}
