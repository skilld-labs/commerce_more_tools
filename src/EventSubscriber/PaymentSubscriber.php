<?php

namespace Drupal\commerce_more_tools\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\commerce_payment\Event\PaymentEvent;
use Drupal\commerce_payment\Event\PaymentEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PaymentSubscriber implements EventSubscriberInterface {

  /**
   * The entityTypeManager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new PaymentSubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entityTypeManager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [
      PaymentEvents::PAYMENT_INSERT => 'onPaymentSaved',
      PaymentEvents::PAYMENT_UPDATE => 'onPaymentSaved',
    ];

    return $events;
  }

  /**
   * Clear order cache after saving payment.
   *
   * @param \Drupal\commerce_payment\Event\PaymentEvent $event
   *   The payment event.
   */
  public function onPaymentSaved(PaymentEvent $event) {
    $payment = $event->getPayment();
    if ($payment && $order = $payment->getOrder()) {
      // Clearing order cache, to avoid any mismatched value.
      $this->entityTypeManager->getStorage('commerce_order')->resetCache([$order->id()]);
      // Let's validate prices, to get proper status.
      $total_paid = $order->getTotalPaid();
      $order_total = $order->getTotalPrice();
      if ($total_paid->greaterThan($order_total)) {
        $state = 'overpaid';
      }
      elseif ($total_paid->equals($order_total)) {
        $state = 'complete';
      }
      elseif ($total_paid->lessThan($order_total)) {
        $state = 'partial';
      }
      else {
        $state = 'pending';
      }
      // Now, let's set status.
      if ($order->get('payment_state')->getString() != $state) {
        $order->set('payment_state', $state);
        $order->save();
      }
    }
  }

}
