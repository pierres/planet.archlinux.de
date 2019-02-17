<?php

namespace App\Tests\Service;

use App\Service\FeedReaderFactory;
use PHPUnit\Framework\TestCase;

class FeedReaderFactoryTest extends TestCase
{
    public function testCreateFeedReader()
    {
        $feedReaderFactory = new FeedReaderFactory();
        $feedReader = $feedReaderFactory->createFeedReader('https://www.archlinux.de/news/feed');

        $this->assertInstanceOf(\SimplePie::class, $feedReader);
        $this->assertEquals('https://www.archlinux.de/news/feed', $feedReader->feed_url);
    }
}
