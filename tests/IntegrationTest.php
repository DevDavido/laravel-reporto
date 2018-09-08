<?php

namespace DevDavido\Reporto\Test;

class IntegrationTest extends TestCase
{
    /** @test */
    public function it_adds_report_to_header_via_the_middleware()
    {
        $response = $this->call('get', '/');

        $response->assertHeader('Report-To');
        $headerValue = '[' . $response->headers->get('Report-To') . ']';
        $headerJson = json_decode($headerValue);

        $this->assertJson($headerValue);
        $this->assertNotEmpty($headerJson);
    }
}