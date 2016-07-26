<?php

namespace App\Tests\API;


class BranchEndpointTest extends \TestCase
{
    /**
     * Listing all the branch.
     */
    public function testListing()
    {
        $response = $this->call('GET', '/api/v1/branches');
        $this->assertEquals(200, $response->status());
        $content = $this->shouldBeJsonEndpoint($response);
        $this->assertInternalType('array', $content['data']);
    }

    /**
     * Add a branch
     */
    public function testAddingBranch()
    {
        $data = [
            'name' => 'Testing'
        ];
        $response = $this->call('POST', '/api/v1/branches', $data);
        $this->assertEquals(201, $response->status());
        $this->shouldBeJsonEndpoint($response);
    }
}