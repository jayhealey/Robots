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
//
//    protected function addRuleLine($directories, $rule)
//    {
//        foreach ((array) $directories as $directory) {
//            $this->addLine("$rule: $directory");
//        }
//    }
//
//    public function testaddComment($comment)
//    {
//        $this->addLine("# $comment");
//    }
//
//    public function testaddSpacer()
//    {
//        $this->addLine("");
//    }
//
//    public function testaddLine($line)
//    {
//        $this->lines[] = (string) $line;
//    }
//
//    public function testaddLines($lines)
//    {
//        foreach ((array) $lines as $line) {
//            $this->addLine($line);
//        }
//    }
//
//    public function testreset()
//    {
//        $this->lines = array();
//    }
}
