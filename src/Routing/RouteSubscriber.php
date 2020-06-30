<?php

namespace Drupal\commerce_more_tools\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Altering some routes to set more granular permission.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Let's alter access check to "/admin/commerce/orders/{commerce_order}/payments".
    if ($route = $collection->get('entity.commerce_payment.collection')) {
      $route->setRequirements([
        '_custom_access' => 'Drupal\commerce_more_tools\Access\CommercePaymentCollectionAccessCheck::access',
      ]);
    }
    // Let's alter access check to "/admin/commerce/orders/{commerce_order}/payments/add".
    if ($route = $collection->get('entity.commerce_payment.add_form')) {
      $route->setRequirements([
        '_custom_access' => 'Drupal\commerce_more_tools\Access\CommercePaymentCreateAccessCheck::access',
      ]);
    }
    // Let's alter access check to "/admin/commerce/orders/{commerce_order}/reassign".
    if ($route = $collection->get('entity.commerce_order.reassign_form')) {
      $route->setRequirements([
        '_custom_access' => 'Drupal\commerce_more_tools\Access\CommerceOrderReassignAccessCheck::access',
      ]);
    }
  }

}
