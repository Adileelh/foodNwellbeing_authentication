<?php

namespace App\Controller;

use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $cartServices;
    public function __construct(CartServices $cartServices){

        $this->cartServices = $cartServices;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
       
        $cart = $this->cartServices->getFullCart();
        // si la cle products n'est pas definie
        //( products provient du tableau $fullCart)
        //alors on redirige vers la page home 
        if (!isset($cart['products'])) {
            return $this->redirectToRoute('home');
        }
        // sinon on affiche le panier
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }
    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addToCart($id): Response
    {
        $this->cartServices->addToCart($id);

        return $this->redirectToRoute('home');

    }
    #[Route('/cart/addOnCart/{id}', name: 'app_cart_add_on_cart')]
    public function addToCartOnCart($id): Response
    {
        $this->cartServices->addToCart($id);

        return $this->redirectToRoute('app_cart');

    }


    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function deleteFromCart($id): Response
    {

        $this->cartServices->deleteFromCart($id);

        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/deleteAll/{id}', name: 'app_cart_deleteAllQuantityFromCart')]
    public function deleteAllQuantityFromCart($id): Response
    {

        $this->cartServices->deleteAllQuantityFromCart($id);

        return $this->redirectToRoute('app_cart');
    }
}
