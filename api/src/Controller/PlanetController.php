<?php

namespace App\Controller;

use App\Repository\FeedRepository;
use App\Repository\ItemRepository;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanetController extends AbstractController
{
    public function __construct(private ItemRepository $itemRepository, private FeedRepository $feedRepository)
    {
    }

    #[Route(path: '/rss.xml', methods: ['GET'])]
    #[Cache(smaxage: 600)]
    public function rssFeedAction(): Response
    {
        $response = $this->render(
            'feed.rss.xml.twig',
            ['items' => $this->itemRepository->findLatest(0, 30)]
        );
        $response->headers->set('Content-Type', 'application/rss+xml; charset=UTF-8');
        return $response;
    }

    #[Route(path: '/atom.xml', methods: ['GET'])]
    #[Cache(smaxage: 600)]
    public function atomFeedAction(): Response
    {
        $response = $this->render(
            'feed.atom.xml.twig',
            ['items' => $this->itemRepository->findLatest(0, 30)]
        );
        $response->headers->set('Content-Type', 'application/atom+xml; charset=UTF-8');
        return $response;
    }
}
