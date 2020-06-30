<?php

namespace Drupal\commerce_more_tools;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommerceMoreToolsServiceProvider.
 *
 * @package Drupal\commerce_more_tools
 */
class CommerceMoreToolsServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Alter access check to /product/{commerce_product}/variations page.
    if ($definition = $container->getDefinition('access_check.product_variation_collection')) {
      $definition->setClass('Drupal\commerce_more_tools\Access\ProductVariationCollectionAccessCheck');
      $definition->setArguments([
        new Reference('entity_type.manager'),
      ]);
    }
    // Alter access check to /product/{commerce_product}/variations/add page.
    if ($definition = $container->getDefinition('access_check.product_variation_create')) {
      $definition->setClass('Drupal\commerce_more_tools\Access\ProductVariationCreateAccessCheck');
      $definition->setArguments([
        new Reference('entity_type.manager'),
      ]);
    }
    // Alter access check to /admin/commerce/orders/{commerce_order}/payments/{commerce_payment}/operation/{operation} page.
    if ($definition = $container->getDefinition('access_check.commerce_payment.operation')) {
      $definition->setClass('Drupal\commerce_more_tools\Access\PaymentOperationAccessCheck');
    }
  }

} 
