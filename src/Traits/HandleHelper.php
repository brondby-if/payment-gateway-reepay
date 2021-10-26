<?php

namespace Brondby\PaymentGateway\Traits;

trait HandleHelper
{
    /**
     * Get Customer prefix.
     *
     * @return string
     */
    public function getCustomerPrefix()
    {
        if (! is_null(config('brondby.subscription.customer_prefix'))) {
            return config('brondby.subscription.customer_prefix');
        }

        if (! app()->environment('production')) {
            return app()->environment().'-';
        }

        return '';
    }

    /**
     * Get Customer handle including prefix.
     *
     * @return string
     */
    public function getCustomerHandle($id)
    {
        return $this->getCustomerPrefix().$id;
    }

    /**
     * Remove customer prefix from string.
     *
     * @return string
     */
    public function removeCustomerPrefix($id)
    {
        $prefix = $this->getCustomerPrefix();
        if (empty($prefix)) {
            return $id;
        }

        return ltrim($id, $prefix.'-');
    }
}
