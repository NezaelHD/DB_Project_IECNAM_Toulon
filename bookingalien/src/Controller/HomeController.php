<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CountryRepository $cr): Response
    {
        $allCountries = $cr->findAll();
        return $this->render('home/index.html.twig', [
            'countries' => $allCountries
        ]);
    }

    #[Route('/country/{country}/cities', name: 'ajax_city')]
    public function city(Country $country, SerializerInterface $serializer, CityRepository $cr)
    {
        $allCities = $cr->findBy(['countryName' => $country]);
        $data = $serializer->serialize($allCities, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }]
        );
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/city/{city}/hotels', name: 'ajax_hotel')]
    public function hotel(City $city, SerializerInterface $serializer, HotelRepository $hr): JsonResponse
    {
        $allHotels = $hr->findBy(['cityID' => $city]);
        $data = $serializer->serialize($allHotels, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
