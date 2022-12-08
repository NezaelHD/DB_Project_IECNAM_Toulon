<?php

namespace App\Controller;

use App\Entity\Traveller;
use App\Form\LoginFormType;
use App\Repository\TravellerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authCheck): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $traveller = new Traveller();
        $traveller->setTravellerEmail($authenticationUtils->getLastUsername());

        if ($authCheck->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute("app_home");
        } else {
            $form = $this->createForm(LoginFormType::class, $traveller);
        }
        if (!is_null($authenticationUtils->getLastAuthenticationError(false))) {
            $form->addError(new FormError(
                $authenticationUtils->getLastAuthenticationError()->getMessageKey()
            ));
        }
        $form->handleRequest($request);

        return $this->render('login/index.html.twig', array(
                'loginForm' => $form->createView(),
            )
        );
    }
    #[Route('/testt', name: 'app_testt')]
    public function testt(TravellerRepository $tr){
        return new Response($tr->find("blou.bloublon@bloublou.blou")->getTravellerName(), 200);
    }

}
