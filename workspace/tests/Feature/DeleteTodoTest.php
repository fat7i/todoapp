<?php

namespace App\Tests\Feature;

use App\Tests\DataBaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteTodoTest extends DataBaseWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    private function doRequest(string $headerOpt = null, mixed $id = 1): Response
    {
        $headers['HTTP_mock-response'] = $headerOpt;
        $this->client->request('DELETE', "/api/todos/". $id, server: [...$headers]);

        return $this->client->getResponse();
    }

    public function testValidRequest(): void
    {
        $response = $this->doRequest();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
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