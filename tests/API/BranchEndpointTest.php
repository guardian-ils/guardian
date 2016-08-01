<?php

namespace App\Tests\API;

use Illuminate\Support\Facades\DB;

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
        $this->assertTrue(isset($content->data));
        $this->assertTrue(isset($content->result));
        $this->assertEquals('success', $content->result);
    }

    /**
     * Add a branch
     */
    public function testAddingBranch()
    {
        $data = [
            '_token' => csrf_token(),
            'name' => 'Testing'
        ];
        $response = $this->call('POST', '/api/v1/branches', $data);
        $this->assertEquals(201, $response->status());
        $this->shouldBeJsonEndpoint($response);
        $this->seeInDatabase('branches', ['name' => 'Testing']);
    }

    public function tearDown()
    {
        DB::table('branches')->delete();
    }
}
