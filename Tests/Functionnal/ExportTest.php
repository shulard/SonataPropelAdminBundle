<?php

namespace Sonata\PropelAdminBundle\Tests\Functionnal;

class ExportTest extends WebTestCase
{
    protected $expected_formats = array('json', 'xml', 'csv', 'xls');

    public function testExportLinksAreShownOnDashboard()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/sonata/test/blogpost/list');
        $link_selector = $this->getExportLinksSelector();

        $this->assertTrue($client->getResponse()->isSuccessful());
        foreach ($this->expected_formats as $format) {
            $this->assertCount(1, $crawler->filter(sprintf('a:contains("%s")', $format), sprintf('The format %s is proposed', $format)));
        }
    }

    public function testExportLinksWork()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/sonata/test/blogpost/list');

        $this->assertTrue($client->getResponse()->isSuccessful());
        foreach ($this->expected_formats as $format) {
            $link = $crawler->selectLink($format)->link();

            // as Sonata\AdminBundle\Export\Exporter writes directly to php://output
            // the exported data is displayed in the console
            ob_start();
            $client->click($link);
            ob_end_clean();

            $this->assertTrue($client->getResponse()->isSuccessful(), sprintf('BlogPosts can be exported to %s', $format));
        }
    }

    protected function getExportLinksSelector()
    {
        return '.pull-right a';
    }
}
