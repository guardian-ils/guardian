<?php

namespace App\Tests\API;

use Ramsey\Uuid\Uuid;

class BranchEndpointTest extends \TestCase
{
    /**
     * Listing all the branch.
     */
    public function testListing()
    {
        $this->get('/api/v1/branches');
        $response = $this->response;
        $this->assertEquals(200, $response->status());
        $content = $this->shouldBeJsonEndpoint();
        $this->assertTrue(isset($content['data']));
        $this->assertTrue(isset($content['result']));
        $this->assertEquals('success', $content['result']);
    }

    public function testAddingBranch()
    {
        $data = [
            'name' => 'Testing',
            'foo' => 'bar'
        ];
        $response = $this->json('POST', '/api/v1/branches', $data);
        $this->assertEquals(201, $response->status());
        $this->shouldBeJsonEndpoint();
        $this->seeInDatabase('branches', ['name' => 'Testing']);
    }

    public function testEmptyAdding()
    {
        $this->json('POST', '/api/v1/branches', []);
        $response = $this->response;
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(422, $response->status());
    }

    public function testExistsBranch()
    {
        $this->get('/api/v1/branches');
        $content = $this->shouldBeJsonEndpoint();
        $this->assertTrue(isset($content['data']));
        $this->assertTrue(isset($content['result']));
        $data = $content['data'][0];
        $this->assertEquals('Testing', $data['name']);
        return $data;
    }

    /**
     * @depends testExistsBranch
     * @param array $data
     * @return array
     */
    public function testUpdateBranch(array $data)
    {
        $url = sprintf('/api/v1/branches/%s', $data['id']);
        $param = ['name' => 'Test'];
        $response = $this->json('PUT', $url, $param);
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(200, $response->getStatusCode());
        return $data;
    }

    public function testUpdateInvalidFormat()
    {
        $url = sprintf('/api/v1/branches/%s', '0000-0000');
        $data = ['name' => 'Test'];
        $response = $this->json('PUT', $url, $data);
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function testUpdateNotExists()
    {
        $url = sprintf('/api/v1/branches/%s', Uuid::NIL);
        $data = ['name' => 'Test'];
        $response = $this->json('PUT', $url, $data);
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteNotExists()
    {
        $url = sprintf('/api/v1/branches/%s', Uuid::NIL);
        $response = $this->json('DELETE', $url);
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteInvalid()
    {
        $url = sprintf('/api/v1/branches/%s', '0000-0000');
        $response = $this->json('DELETE', $url);
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(422, $response->getStatusCode());
    }

    /**
     * @depends testUpdateBranch
     * @param array $data
     */
    public function testDelete(array $data)
    {
        $url = sprintf('/api/v1/branches/%s', $data['id']);
        $response = $this->json('DELETE', $url);
        $this->shouldBeJsonEndpoint();
        $this->assertEquals(200, $response->getStatusCode());
    }
}