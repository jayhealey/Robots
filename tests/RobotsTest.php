<?php

use Healey\Robots\Robots;

class RobotsTest extends PHPUnit_Framework_TestCase
{
    public function testNewInstanceEmpty()
    {
        $robots = new Robots();
        $this->assertEquals("", $robots->generate());
    }

    public function testAddSitemap()
    {
        $robots  = new Robots();
        $sitemap = "sitemap.xml";

        $this->assertNotContains($sitemap, $robots->generate());
        $robots->addSitemap($sitemap);
        $this->assertContains("Sitemap: $sitemap", $robots->generate());
    }

    public function testAddUserAgent()
    {
        $robots    = new Robots();
        $userAgent = "Google";

        $this->assertNotContains("User-agent: $userAgent", $robots->generate());
        $robots->addUserAgent($userAgent);
        $this->assertContains("User-agent: $userAgent", $robots->generate());
    }

    public function testaddHost()
    {
        $robots = new Robots();
        $host   = "www.google.com.au";

        $this->assertNotContains("Host: $host", $robots->generate());
        $robots->addHost($host);
        $this->assertContains("Host: $host", $robots->generate());
    }

    public function testaddDisallow()
    {
        $robots = new Robots();
        $path   = "/dir/";
        $paths  = array("/dir-1/", "/dir-2/", "/dir-3/");

        // Test a single path.
        $this->assertNotContains("Disallow: $path", $robots->generate());
        $robots->addDisallow($path);
        $this->assertContains("Disallow: $path", $robots->generate());

        // Test array of paths.
        foreach($paths as $path_test)
            $this->assertNotContains("Disallow: $path_test", $robots->generate());

        // Add the array of paths
        $robots->addDisallow($paths);

        // Check the old path is still there
        $this->assertContains("Disallow: $path", $robots->generate());
        foreach($paths as $path_test)
            $this->assertContains("Disallow: $path_test", $robots->generate());
    }

    public function testaddAllow()
    {
        $robots = new Robots();
        $path   = "/dir/";
        $paths  = array("/dir-1/", "/dir-2/", "/dir-3/");

        // Test a single path.
        $this->assertNotContains("Allow: $path", $robots->generate());
        $robots->addAllow($path);
        $this->assertContains("Allow: $path", $robots->generate());

        // Test array of paths.
        foreach($paths as $path_test)
            $this->assertNotContains("Allow: $path_test", $robots->generate());

        // Add the array of paths
        $robots->addAllow($paths);

        // Check the old path is still there
        $this->assertContains("Allow: $path", $robots->generate());
        foreach($paths as $path_test)
            $this->assertContains("Allow: $path_test", $robots->generate());
    }

    public function testaddComment()
    {
        $robots    = new Robots();
        $comment_1 = "Test comment";
        $comment_2 = "Another comment";
        $comment_3 = "Final test comment";

        $this->assertNotContains("# $comment_1", $robots->generate());
        $this->assertNotContains("# $comment_2", $robots->generate());
        $this->assertNotContains("# $comment_3", $robots->generate());

        $robots->addComment($comment_1);
        $this->assertContains("# $comment_1", $robots->generate());

        $robots->addComment($comment_2);
        $this->assertContains("# $comment_1", $robots->generate());
        $this->assertContains("# $comment_2", $robots->generate());

        $robots->addComment($comment_3);
        $this->assertContains("# $comment_1", $robots->generate());
        $this->assertContains("# $comment_2", $robots->generate());
        $this->assertContains("# $comment_3", $robots->generate());
    }

    public function testaddSpacer()
    {
        $robots = new Robots();

        $lines  = count(preg_split('/'. PHP_EOL .'/', $robots->generate()));
        $this->assertEquals(1, $lines); // Starts off with at least one line.

        $robots->addSpacer();
        $robots->addSpacer();
        $lines = count(preg_split('/'. PHP_EOL .'/', $robots->generate()));

        $this->assertEquals(2, $lines);
    }

    public function testReset()
    {
        $robots = new Robots();

        $this->assertEquals("", $robots->generate());

        $robots->addComment("First Comment");
        $robots->addHost("www.google.com");
        $robots->addSitemap("sitemap.xml");
        $this->assertNotEquals("", $robots->generate());

        $robots->reset();
        $this->assertEquals("", $robots->generate());
    }
}
