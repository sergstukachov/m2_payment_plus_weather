<?php

declare(strict_types=1);

namespace SkillUp\CustomPayment\Model\Http;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl;
use SkillUp\CustomPayment\Model\DataMapping\Config\ConfigProvider;

/**
 * Create URL and get Api data
 */
class Client
{
    public const QUERY_STRING_PREFIX = '?q=';
    public const QUERY_STRING_SEPARATOR = '&';
    public const QUERY_STRING_LANG_APP_ID = 'lang=en&appid';
    public const QUERY_STRING_UNITS = 'units';
    public const QUERY_STRING_UNIT_METRIC = 'metric';
    public const QUERY_STRING_CNT = 'cnt=7';
    public const SUCCESS_RESPONSE_CODE = 200;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @param Curl $curl
     * @param ScopeConfigInterface $scopeConfig
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Curl $curl,
        ScopeConfigInterface $scopeConfig,
        ConfigProvider $configProvider
    ) {
        $this->curl = $curl;
        $this->scopeConfig = $scopeConfig;
        $this->configProvider = $configProvider;
    }

    /**
     * @param $city
     * @param $country
     * @return false|string
     */
    public function getWeatherDataForCity($city, $country)
    {
        $url = $this->createApiUrl($city, $country);
        if ($url) {
            $this->curl->get($url);
            $response = $this->curl->getBody();
            if ($this->curl->getStatus() == self::SUCCESS_RESPONSE_CODE) {
                return json_encode($this->parse($response));
            }
        }
        return false;
    }

    /**
     * @param $city
     * @param $country
     * @return string
     */
    private function createApiUrl($city, $country)
    {
        if ($this->configProvider->getApiKey() && $this->configProvider->getApiUrl()) {
            $city = urlencode($city);
            return $this->configProvider->getApiUrl() .
                self::QUERY_STRING_PREFIX . $city . ',' . $country .
                self::QUERY_STRING_SEPARATOR . self::QUERY_STRING_UNITS . '=' . self::QUERY_STRING_UNIT_METRIC .
                self::QUERY_STRING_SEPARATOR . self::QUERY_STRING_CNT . self::QUERY_STRING_SEPARATOR .
                self::QUERY_STRING_LANG_APP_ID . '=' . $this->configProvider->getApiKey();
        }
        return false;
    }

    /**
     * @param $response
     * @return array|false
     */
    private function parse($response)
    {
        $deliveryDate = $this->configProvider->getDeliveryData();
        $arr = json_decode($response);
        $weatherData = $arr->{'list'};
        foreach ($weatherData as $oneDay) {
            if (date(' d.m.y ', $oneDay->{'dt'}) === $deliveryDate) {
                $deliveryWeather = [
                    'temp' => $oneDay->{'temp'}->{'day'},
                    'day' => $deliveryDate,
                    'weather' => $oneDay->{'weather'}[0]->{'description'}
                ];
                return $deliveryWeather;
            }
        }
        return false;
    }
}
