<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Checkout;
use Brondby\PaymentGateway\Customers;
use Brondby\PaymentGateway\Invoices;
use Brondby\PaymentGateway\Plans;
use Brondby\PaymentGateway\Subscriptions;
use Exception;

class PaymentGatewayClient
{
    /**
     * Name of the Payment Gayeway
     */
    public $name = 'Reepay';

    /**
     * Instance of Brondby\PaymentGateway\Checkout
     */
    public $checkout;

    /**
     * Instance of Brondby\PaymentGateway\Customers
     */
    public $customers;

    /**
     * Instance of Brondby\PaymentGateway\Invoices
     */
    public $invoices;

    /**
     * Instance of Brondby\PaymentGateway\plans
     */
    public $plans;

    /**
     * Instance of Brondby\PaymentGateway\Subscriptions
     */
    public $subscriptions;

    /**
     * Instance of Brondby\PaymentGateway\PaymentMethods
     */
    public $paymentMethods;

    /**
     * Return an instance of the Invoices class.
     *
     * @return Invoices
     */
    public function invoices() : Invoices
    {
        if (! $this->invoices instanceof Invoices) {
            $this->invoices = new Invoices();
        }

        return $this->invoices;
    }

    /**
     * Return an instance of the Customers class.
     *
     * @return Customers
     */
    public function customers() : Customers
    {
        if (! $this->customers instanceof Customers) {
            $this->customers = new Customers();
        }

        return $this->customers;
    }

    /**
     * Return an instance of the Subscriptions class.
     *
     * @return Subscriptions
     */
    public function subscriptions() : Subscriptions
    {
        if (! $this->subscriptions instanceof Subscriptions) {
            $this->subscriptions = new Subscriptions();
        }

        return $this->subscriptions;
    }

    /**
     * Return an instance of the Plans class.
     *
     * @return Plans
     */
    public function plans() : Plans
    {
        if (! $this->plans instanceof Plans) {
            $this->plans = new Plans();
        }

        return $this->plans;
    }

    /**
     * Return an instance of the Checkout class.
     *
     * @return Checkout
     */
    public function checkout() : Checkout
    {
        if (! $this->checkout instanceof Checkout) {
            $this->checkout = new Checkout();
        }

        return $this->checkout;
    }

    /**
     * Return an instance of the PaymentMethods class.
     *
     * @return PaymentMethods
     */
    public function paymentMethods() : PaymentMethods
    {
        if (! $this->paymentMethods instanceof PaymentMethods) {
            $this->paymentMethods = new PaymentMethods();
        }

        return $this->paymentMethods;
    }
}
