<?php

namespace Drupal\commerce_more_tools\Plugin\Commerce\Condition;

use Drupal\commerce\Plugin\Commerce\Condition\ConditionBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the seller role condition for orders.
 *
 * @CommerceCondition(
 *   id = "order_seller_role",
 *   label = @Translation("Seller role"),
 *   category = @Translation("Seller"),
 *   entity_type = "commerce_order",
 *   weight = -1,
 * )
 */
class OrderSellerRole extends ConditionBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'roles' => [],
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['roles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Allowed roles'),
      '#default_value' => $this->configuration['roles'],
      '#options' => array_map('\Drupal\Component\Utility\Html::escape', user_role_names()),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $values = $form_state->getValue($form['#parents']);
    $this->configuration['roles'] = array_filter($values['roles']);
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate(EntityInterface $entity) {
    $this->assertEntity($entity);
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $entity;
    $seller = $order->getStore()->getOwner();

    return (bool) array_intersect($this->configuration['roles'], $seller->getRoles());
  }

}

