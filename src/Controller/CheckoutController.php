<?php

namespace App\Controller;

use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function index(CartServices $cartServices): Response
    {
        $user= $this->getUser();
        $cart = $cartServices->getFullCart();

        if(!$cart){

            return $this->redirectToRoute('home');
        }

        if ($user->getAddresses()->getValues) {

            return $this->redirectToRoute('app_address_new');
        }

        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
        ]);
    }
}
