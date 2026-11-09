<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHome(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);

        $this->assertCount(3, $crawler->filter('.event-card'));

        $html = $client->getResponse()->getContent();

        $this->assertStringNotContainsString('Concert passé', $html);
        $this->assertStringNotContainsString('Tournoi de basket', $html);
    }


    public function testEventDetail(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $client->clickLink('Soirée jazz');

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains(
            'h1',
            'Soirée jazz'
        );
    }


    public function testCategoryFilter(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/?categorie=sport');

        $this->assertResponseIsSuccessful();

        $this->assertCount(1, $crawler->filter('.event-card'));

        $this->assertSelectorExists('.legend .cat-sport a.active');
    }

}

