<?php

namespace Bazalt\Rest\Test;

use Tonic;
use Bazalt\Rest;

abstract class BaseCase extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function send($request, $options= array())
    {
        list($method, $uri) = explode(' ', $request);

        if (!is_array($options)) {
            $options = array();
        }
        if (!isset($options['contentType'])) {
            $options['contentType'] = 'application/json';
        }
        $options['method'] = $method;
        $options['uri'] = $uri;

        $get = $_GET;
        if (strtolower($method) == 'get' && isset($options['data'])) {
            $_GET = $options['data'];
        }

        $request = new \Tonic\Request($options);

        $resource = $this->app->getResource($request);
        $response = $resource->exec();

        $_GET = $get;

        $body = $response->body;
        if ($options['contentType'] == 'application/json') {
            $body = json_decode($response->body, true);
        }
        return array($response->code, $body);
    }

    public function assertResponse($request, $options= array(), \Bazalt\Rest\Response $assertResponse)
    {
        list($code, $response) = $this->send($request, $options);

        $this->assertEquals($assertResponse->body, $response);
        $this->assertEquals($assertResponse->code, $code);
    }
}