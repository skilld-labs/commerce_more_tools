<?php

namespace Drupal\commerce_more_tools\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_store\Form\StoreForm as StoreFormBase;

class StoreForm extends StoreFormBase {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    /** @var \Drupal\commerce_store\Entity\StoreInterface $store */
    $store = $this->entity;
    /** @var \Drupal\Core\Session\AccountProxy $current_user */
    $current_user = $this->currentUser();

    // No special behavior here. Just created for later processing.

    return $form;
  }

}
