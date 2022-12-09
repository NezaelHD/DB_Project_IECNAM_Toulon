<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\ActivityRepository;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelReservationController extends AbstractController
{
    #[Route('/hotel/{hotel}', name: 'app_hotel_reservation')]
    public function index(CityRepository $cr, Hotel $hotel): Response
    {
        $city = $cr->findOneBy(['cityID' => $hotel->getCityID()]);
        return $this->render('hotel_reservation/index.html.twig', [
            'controller_name' => 'HotelReservationController',
            'hotel' => $hotel,
            'activities' => $city->getActivities(),
            'city' => $city
        ]);
    }
}
