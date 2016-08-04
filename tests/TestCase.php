<?php

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Check endpoint response is JSON Response
     *
     * @return array Content of decoded data
     */
    protected function shouldBeJsonEndpoint()
    {
        $response = $this->response;
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $content = json_decode($response->content(), true);
        $this->assertEquals(json_last_error(), JSON_ERROR_NONE);
        $this->assertTrue($content !== false);
        return $content;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\Response
     */
    public function json($method, $uri, array $data = [], array $headers = [])
    {
        parent::json($method, $uri, $data, $headers);
        return $this->response;
    }
}
