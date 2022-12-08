<?php

namespace App\Controller;

use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravellerAccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(TripRepository $tr): Response
    {
        $user = $this->getUser();
        $trips = $tr->findBy(['travellerEmail' => $user->getUserIdentifier()]);
        return $this->render('traveller_account/index.html.twig', [
            'controller_name' => 'TravellerAccountController',
            'user' => $user,
            'trips' => $trips
        ]);
    }
}
