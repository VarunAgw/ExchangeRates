<?php

namespace App\Utility;

use GuzzleHttp\Client;
use Cake\Core\Configure;

/*
 * FixerIo Api's
 */
class FixerIo {
    
    /*
     * Fixer API Key
     */
    protected $_apiKey;

    /*
     * Base URL of API
     */
    protected $_baseUri = 'http://data.fixer.io/api/';

    public function __construct() {

        $this->_apiKey = Configure::readOrFail('FixerIo.apiKey');
    }

    /**
     * Get list of all currencies supported by FixerIo
     * @return array list of supported currency symbols
     * @throws Exception
     */
    public function getCurrencyList() {
        $apiUrl = sprintf($this->_baseUri . 'latest?access_key=%s&base=EUR&format=1'
                , $this->_apiKey);


        $httpClient = new Client();
        $response = $httpClient->request('GET', $apiUrl);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Failed while querying from FixerIo');
        }

        $content = $response->getBody()->getContents();
        $rates = (array) json_decode($content)->rates;

        return array_keys($rates);
    }

    /**
     *  Get exchange rate from one currency to another
     * @param string $baseCurrency Symbol of base currency
     * @param string $targetCurrency Symbol of target currency
     * @return float exchange rate
     * @throws Exception
     */
    public function getExchangeRate($baseCurrency, $targetCurrency) {
        $apiUrl = sprintf($this->_baseUri . 'latest?access_key=%s&base=EUR&format=1'
                , $this->_apiKey);


        $httpClient = new Client();
        $response = $httpClient->request('GET', $apiUrl);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Failed while getting exchange rate from FixerIo');
        }

        $content = $response->getBody()->getContents();
        $rates = (array) json_decode($content)->rates;

        // Hack to use fixerio free api
        $exchangeRate = $rates[$targetCurrency] / $rates[$baseCurrency];
        return $exchangeRate;
    }

}
