<?php

declare(strict_types=1);

namespace SkillUp\CustomPayment\Model\DataMapping\Config;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Provide system configuration value
 */
class ConfigProvider
{
    /**
     * Delivery day system configuration value XPATH
     */
    public const XML_PATH_DELIVERY_DAYS = 'payment/custompayment/days_for_delivery';

    /**
     * Api key for OpenWeather system configuration value XPATH
     */
    public const XML_PATH_API_KEY = 'payment/custompayment/api_key';

    /**
     * Api URL for OpenWeather system configuration value XPATH
     */
    public const XML_PATH_API_URL = 'payment/custompayment/api_url';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->getConfig(self::XML_PATH_API_KEY);
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->getConfig(self::XML_PATH_API_URL);
    }

    /**
     * @param string $config_path
     * @return string
     */
    protected function getConfig(string $config_path): string
    {
        return $this->scopeConfig->getValue(
            $config_path,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getDeliveryData(): string
    {
        if ((int) $this->getConfig(self::XML_PATH_DELIVERY_DAYS)) {
            $step = '+' . $this->getConfig(self::XML_PATH_DELIVERY_DAYS) . ' day';
        } else {
            $step = 'now';
        }
        return (string)date(' d.m.y ', strtotime($step));
    }
}
