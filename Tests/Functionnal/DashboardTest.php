<?php

namespace Sonata\PropelAdminBundle\Tests\Functionnal;

class DashboardTest extends WebTestCase
{
    public function testAccessible()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/dashboard');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(1, $crawler->filter('*[role=presentation]:contains("Blog")'), 'There is a "Blog" section');
        $this->assertCount(1, $crawler->filter('*[role=presentation]:contains("Posts")'), 'There is a "Posts" sub-section');
    }
}
