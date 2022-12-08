<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelReservationController extends AbstractController
{
    #[Route('/hotel/{hotel}', name: 'app_hotel_reservation')]
    public function index(ActivityRepository $ar, Hotel $hotel): Response
    {
        $activities = $ar->findBy(['city' => $hotel->getCityID()]);
        return $this->render('hotel_reservation/index.html.twig', [
            'controller_name' => 'HotelReservationController',
            'hotel' => $hotel,
            'activities' => $activities
        ]);
    }
}
