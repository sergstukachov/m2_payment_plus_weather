<?php

/**
 * Custom Payment Method
 */

declare(strict_types=1);

namespace SkillUp\CustomPayment\Model\Payment;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Payment\Model\Method\Adapter;

class CustomPayment extends Adapter
{
    /**
     * @var string
     */
    protected $_code = "custompayment";

    /**
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * @param CartInterface|null $quote
     * @return array|bool|mixed|null
     */
    public function isAvailable(CartInterface $quote = null)
    {
        return parent::isAvailable($quote);
    }
}
