<?php

namespace App\Tests\Entity;

use App\Entity\Event;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class EventTest extends TestCase
{
    #[DataProvider('placesProvider')]
    public function testRemainingPlaces(
        int $places,
        int $participants,
        int $expected
    ): void {
        $event = new Event();
        $event->setPlaces($places);

        for ($i = 0; $i < $participants; $i++) {
            $event->addParticipant(new User());
        }

        $this->assertSame(
            $expected,
            $event->getRemainingPlaces()
        );
    }

    public static function placesProvider(): array
    {
        return [
            'aucun inscrit' => [10, 0, 10],
            'quelques inscrits' => [10, 3, 7],
            'Complet' => [3, 3, 0],
        ];
    }


    #[DataProvider('categoryProvider')]
    public function testCategoryLabel(
        string $category,
        string $expected
    ): void {
        $event = new Event();

        $event->setCategory($category);

        $this->assertSame(
            $expected,
            $event->getCategoryLabel()
        );
    }

    public static function categoryProvider(): array
    {
        return [
            'Concert' => ['concert', 'Concert'],
            'Conférence' => ['conference', 'Conférence'],
            'Atelier' => ['atelier', 'Atelier'],
            'Sport' => ['sport', 'Sport'],
        ];
    }

}
