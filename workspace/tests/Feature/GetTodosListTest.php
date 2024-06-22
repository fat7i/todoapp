<?php

namespace App\Tests\Feature;

use App\Tests\DataBaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTodosListTest extends DataBaseWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    private function doRequest(string $headerOpt = null, mixed $page = 1, mixed $limit = 1): Response
    {
        $headers['HTTP_mock-response'] = $headerOpt;
        $this->client->request('GET', "/api/todos?page=". $page ."&limit=". $limit, server: [...$headers]);

        return $this->client->getResponse();
    }

    public function testValidRequest(): void
    {
        $response = $this->doRequest();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = json_decode((string) $response->getContent(), true);

        $this->assertArrayHasKey('total', $responseData);
        $this->assertArrayHasKey('page', $responseData);
        $this->assertArrayHasKey('limit', $responseData);
        $this->assertArrayHasKey('totalPages', $responseData);
        $this->assertArrayHasKey('todos', $responseData);
    }

    public function testSendingInvalidParams(): void
    {
        $response = $this->doRequest('invalidParam', 'invalid-param', 2);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertArrayHasKey('errors', $responseData);
    }

    public function testUnknownError(): void
    {
        $response = $this->doRequest('unknownError');
        $responseData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $expectedMessage = 'Unexpected Error';
        $givenMessage = $responseData['errors'];
        $this->assertEquals($expectedMessage, $givenMessage);
    }
}