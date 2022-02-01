<?php

/**
 * Custom Payment Method
 */

declare(strict_types=1);

namespace SkillUp\CustomPayment\Model\Payment;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Payment\Model\Method\AbstractMethod;

class CustomPayment extends AbstractMethod
{
    /**
     * @var string
     */
    protected $_code = "custompayment";

    /**
     * @var bool
     */
    protected $_isOffline = true;

    public function isAvailable(
        CartInterface $quote = null
    )
    {
        return parent::isAvailable($quote);
    }
}
