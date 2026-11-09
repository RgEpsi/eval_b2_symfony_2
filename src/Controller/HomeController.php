<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        // Catégorie passée dans l'URL : /?categorie=concert
        $categorie = $request->query->get('categorie');

        $events = $eventRepository->findUpcoming($categorie);

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'categorie' => $categorie,
        ]);
    }

   #[Route('/mes-inscriptions', name: 'app_my_events')]
   #[IsGranted('ROLE_USER')]
   public function mine(): Response
 {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $events = $user->getEvents();

        return $this->render('event/mine.html.twig', [
            'events' => $events,
        ]);
    }

}
