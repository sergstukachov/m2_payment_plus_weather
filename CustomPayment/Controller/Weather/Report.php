<?php

declare(strict_types=1);

namespace SkillUp\CustomPayment\Controller\Weather;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action ;
use Magento\Framework\Controller\Result\JsonFactory;
use SkillUp\CustomPayment\Model\Http\Client;

class Report extends Action
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @param Context $context
     * @param Client $httpClient
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        Client $httpClient,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->httpClient = $httpClient;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->jsonFactory->create();
        $params = $this->getRequest()->getParams();
        $city = $params['city'];
        $countryId = $params['country'];
        $result->setData($this->httpClient->getWeatherDataForCity($city, $countryId));
        return $result;
    }
}
