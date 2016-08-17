<?php

namespace App\Tests\API;

use Ramsey\Uuid\Uuid;
use Guardian\Models\Branch;

class PatronEndpointTest extends \TestCase
{

    private function str_random() {
        static $_str;
        if (!isset($_str)) {
            $_str = str_random(6);
        }
        return $_str;
    }

    /**
     * Listing all the patron.
     */
    public function testListing()
    {
        $this->get('/api/v1/patrons');
        $response = $this->response;
        $this->assertEquals(200, $response->status());
        $content = $this->shouldBeJsonEndpoint();
        $this->assertTrue(isset($content['data']));
        $this->assertTrue(isset($content['result']));
        $this->assertEquals('success', $content['result']);
    }

    public function testAddingPatron()
    {
        $branch_id = Uuid::uuid4()->toString();
        $branch = new Branch;
        $branch->id = $branch_id;
        $branch->name = 'Branch '.$this->str_random();
        $branch->save();

        $data = [
            'library_card_number' => 'CARD-'.$this->str_random(),
            'name' => 'Reader '.$this->str_random(),
            'birthday' => date("Y-m-d H:i:s",rand(1262055681,1262055681)),
            'branch_id' => $branch_id,
        ];
        $response = $this->json('POST', '/api/v1/patrons', $data);
        $this->assertResponseStatus(201);
        $this->shouldBeJsonEndpoint();
        $this->seeInDatabase('patrons', $data);
    }

    public function testEmptyAdding()
    {
        $this->json('POST', '/api/v1/patrons', []);
        $response = $this->response;
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(422);
    }

    public function testExistsPatron()
    {
        $this->get('/api/v1/patrons');
        $content = $this->shouldBeJsonEndpoint();
        $this->assertTrue(isset($content['data']));
        $this->assertTrue(isset($content['result']));
        $this->assertTrue(sizeof($content['data']) > 0);
        $data = $content['data'][0];
        $this->assertEquals('Reader '.$this->str_random(), $data['name']);
        return $data;
    }

    /**
     * @depends testExistsPatron
     * @param array $data
     * @return array
     */
    public function testUpdatePatron(array $data)
    {
        $url = sprintf('/api/v1/patrons/%s', $data['id']);
        $param = [
            'library_card_number' => 'CARD-'.$this->str_random().'(Updated)',
            'name' => 'Reader '.$this->str_random().'(Updated)',
            'birthday' => date("Y-m-d H:i:s",rand(1262055681,1262055681)),
            'branch_id' => $data['branch_id'],
        ];
        $response = $this->json('PUT', $url, $param);
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(200);
        return $data;
    }

    public function testUpdateInvalidFormat()
    {
        $url = sprintf('/api/v1/patrons/%s', '0000-0000');
        $data = ['name' => 'Test'
        ];
        $response = $this->json('PUT', $url, $data);
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(422);
    }

    public function testUpdateNotExists()
    {
        $url = sprintf('/api/v1/patrons/%s', Uuid::NIL);
        $data = [
          'library_card_number' => 'CARD-'.$this->str_random().'(Updated)',
          'name' => 'Reader '.$this->str_random().'(Updated)',
          'birthday' => date("Y-m-d H:i:s",rand(1262055681,1262055681)),
          'branch_id' => Uuid::uuid4()->toString(),
        ];
        $response = $this->json('PUT', $url, $data);
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(404);
    }

    public function testDeleteNotExists()
    {
        $url = sprintf('/api/v1/patrons/%s', Uuid::NIL);
        $response = $this->json('DELETE', $url);
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(404);
    }

    public function testDeleteInvalid()
    {
        $url = sprintf('/api/v1/patrons/%s', '0000-0000');
        $response = $this->json('DELETE', $url);
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(422);
    }

    /**
     * @depends testUpdatePatron
     * @param array $data
     */
    public function testDelete(array $data)
    {
        $url = sprintf('/api/v1/patrons/%s', $data['id']);
        $response = $this->json('DELETE', $url);
        $this->shouldBeJsonEndpoint();
        $this->assertResponseStatus(200);
    }
}
