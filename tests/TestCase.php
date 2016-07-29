<?php

use Illuminate\Http\Response;
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
     * @param Response $response
     *
     * @return array Content of decoded data
     */
    protected function shouldBeJsonEndpoint(Response $response)
    {
        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $content = json_decode($response->content());
        $this->assertEquals(json_last_error(), JSON_ERROR_NONE);
        return $content;
    }
}
