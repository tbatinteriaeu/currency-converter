<?php
/**
 * Service responsive for converting currencies
 *
 *
 * @author Tomasz Biedrzycki <tomasz.biedrzycki@interia.eu>
 */

namespace TBat\Converter\Model\Converter\Service;


use Zend\Server\Exception\RuntimeException;
use Magento\Framework\Exception\RemoteServiceUnavailableException;

class Client {

    /**
     * url parameter for base currency
     *
     * @var string
     */
    const PARAM_BASE = 'base';

    /**
     * url param for exchange currency
     *
     * @var string
     */
    const PARAM_SYMBOLS = 'symbols';

    /**
     *
     * @var string
     */
    protected $_baseUrl;


    /**
     *
     * @var \Magento\Framework\Json\DecoderInterface
     */
    protected $_jsonDecoder;

    /**
     * @param $url
     * @param \Magento\Framework\Json\DecoderInterface $jsonDecoder
     */
    public function __construct($url, \Magento\Framework\Json\DecoderInterface $jsonDecoder){
        $this->_baseUrl = $url;
        $this->_jsonDecoder = $jsonDecoder;
    }

    /**
     * calculate currency value
     * get currency rate from webservice and multiply it by given value
     *
     * @param float $base
     * @param float $exchange
     * @param float $value
     * @return float $result
     * @throws \Exception
     */
    public function calculate($base, $exchange, $value)
    {

        //prepare url for request
        $url = $this->_buildUrl($base, $exchange);

        //get response
        $response = $this->_getCurrencyRate($url);
        //get valid json
        $decoded = $this->_jsonDecoder->decode($response);

        if (!isset($decoded['rates']) || !isset($decoded['rates'][$exchange])) {
            throw new \Exception('Cannot convert value. No valid response!');
        }

        //get rate for given currency
        $rate = $decoded['rates'][$exchange];

        //multiply by given value and return
        return $rate * $value;
    }

    /**
     * get currency rate from webservice
     *
     * @param string $url
     * @return string
     * @throws \Exception $exception
     */
    protected function _getCurrencyRate($url)
    {
        try {
            $res = curl_init($url);
            curl_setopt($res, CURLOPT_RETURNTRANSFER, 1); //get response
            curl_setopt($res, CURLOPT_TIMEOUT, 5); //timeout 5 sec
            $result = curl_exec($res);
            curl_close($res);
            return $result;

        } catch (\Exception $e) {
            //pass it forward
            throw new \Exception($e->getMessage());
        }
        return $result;
    }

    /**
     * preparing url to webservice api
     *
     * @param string $base
     * @param string $exchange
     * @return string
     */
    protected function _buildUrl($base, $exchange)
    {
        $url = $this->_baseUrl
            .'?'.self::PARAM_BASE.'='.$base.'&'.self::PARAM_SYMBOLS.'='.$exchange;
        return $url;
    }

}
