<?php

namespace App\Tests\Feature;

use App\Tests\DataBaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetTodoTest extends DataBaseWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    private function doRequest(string $headerOpt = null, mixed $id = 1): Response
    {
        $headers['HTTP_mock-response'] = $headerOpt;
        $this->client->request('GET', "/api/todos/". $id, server: [...$headers]);

        return $this->client->getResponse();
    }

    public function testValidRequest(): void
    {
        $response = $this->doRequest();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = json_decode((string) $response->getContent(), true);

        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('title', $responseData);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('description', $responseData);
        $this->assertArrayHasKey('createdAt', $responseData);
        $this->assertArrayHasKey('updatedAt', $responseData);
    }

    public function testSendingInvalidParams(): void
    {
        $response = $this->doRequest('invalidParam', 'invalid-param');
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

    public function testNoneExistingTodo(): void
    {
        $response = $this->doRequest('notFound', 2);
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertArrayHasKey('errors', $responseData);
    }
}