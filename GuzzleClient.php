<?php

use GuzzleHttp\Exception\ConnectException;

/**
 * Class GuzzleClient
 */
class GuzzleClient extends \GuzzleHttp\Client
{
    /**
     * @see \GuzzleHttp\RequestOptions for a list of available request options.
     */
    public function __construct()
    {
        $config = [
            'base_uri' => 'https://slack.com/api/',
            'proxy' => 'localhost:8888',
            'verify' => false,
        ];
        parent::__construct($config);
        $this->checkConnection();
    }

    /**
     * @param $method
     * @param array $params
     * @return array
     */
    public function sendPostRequest($method, array $params = []): array
    {
        $params['token'] = $_ENV['api_token'];
        $params['as_user'] = true;

        $params = [
            'query' => $params,
        ];

        return json_decode($this->get($method, $params)->getBody(), true);
    }

    private function checkConnection()
    {
        try {
            $this->sendPostRequest(SlackMethods::API_TEST);
        } catch (ConnectException $e) {
            if (false !== strpos($e->getMessage(), 'cURL error 7')) {
                echo 'Not connected to proxy';
                die;
            }
            echo 'Not connected to a network';
            die;
        } catch (GuzzleHttp\Exception\RequestException $e) {
            echo 'Proxy not connected to a network';
            die;
        }
    }
}