<?php

namespace tests;

use Bazalt\Rest;
use Tonic;

class ResourceTest extends \Bazalt\Rest\Test\BaseCase
{
    protected $app;

    protected function setUp()
    {
        global $loader;

        $config = array(
            'load' => array(
                $loader->findFile('tests\\Hello'),
            )
        );
        $this->app = new Tonic\Application($config);
    }

    protected function tearDown()
    {
    }

    public function testGet()
    {
        $response = new \Bazalt\Rest\Response(200, array(
            'hello' => '',
            'url' => '/hello'
        ));

        $this->assertResponse('GET /hello.json', [], $response);
    }


    public function testPost()
    {
        $response = new \Bazalt\Rest\Response(200, array(
            'hello' => 'computer'
        ));

        $this->assertResponse('POST /hello.json', [
            'data' => json_encode([
                'hello' => 'computer'
            ])
        ], $response);
    }

    public function testAction()
    {
        $response = new \Bazalt\Rest\Response(200, 'testAction');

        $_GET = ['action' => 'test'];
        $this->assertResponse('GET /hello.json', [], $response);
    }
}