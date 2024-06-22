<?php

namespace App\Tests\Feature;

use App\Tests\DataBaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateTodoTest extends DataBaseWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    private function doRequest(string $headerOpt = null, string $title = null, string $status = null, ?string $description = null): Response
    {
        $headers['HTTP_mock-response'] = $headerOpt;
        $cobtent = json_encode([
            'title' => $title,
            'status' => $status,
            'description' => $description,
        ], JSON_THROW_ON_ERROR);
        $this->client->request('POST', '/api/todos', content: $cobtent, server: [...$headers]);

        return $this->client->getResponse();
    }

    public function testValidRequest(): void
    {
        $response = $this->doRequest(null, 'test-title', 'pending', 'test-description');
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('title', $responseData);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('description', $responseData);
        $this->assertArrayHasKey('createdAt', $responseData);
        $this->assertArrayHasKey('updatedAt', $responseData);
    }

    public function testSendingInvalidParams(): void
    {
        $response = $this->doRequest('invalidParam');
        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertArrayHasKey('errors', $responseData);
    }

    public function testUnknownError(): void
    {
        $response = $this->doRequest('unknownError', 'test-title', 'pending', 'test-description');
        $responseData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $expectedMessage = 'Unexpected Error';
        $givenMessage = $responseData['errors'];
        $this->assertEquals($expectedMessage, $givenMessage);
    }
}