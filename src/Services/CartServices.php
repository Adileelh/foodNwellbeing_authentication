<?php
namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartServices
{
    // declaration des variables d'environnement (variable accessible dans toute la classe )
    private $requestStack;
    private $repoProduct;
    private $tva1 = 0.2;
    private $tva2 = 0.05;


    // injection des classes requestack et ProductRepository pour que le methodes puissent en beneficier
    public function __construct(RequestStack $requestStack, ProductRepository $repoProduct)
    {

        $this->requestStack = $requestStack;
        $this->repoProduct = $repoProduct;
    }

    //Methode d'ajout d'un article dans le panier
    public function addToCart($id){
        //recuperation du panier (si existant sinon panier vide) et affectation à la variable $cart
        $cart = $this->getCart();
        // controle de la presence de la variable $Cart avec les $id des produits
        if(isset($cart[$id])){
            //produit déjà dans le panier on incrémente de 1
            $cart[$id]++;
        }else{
            //produit pas encore dans le panier on ajoute
            $cart[$id] = 1;
        }
        //mise a jour du panier
        $this->updateCart($cart);
    }


    // methode de decrementation de la quantite d'un article ex passe de 3 à 2
    public function deleteFromCart($id){
        //recuperation du dernier panier enregistrer en session
        $cart = $this->getCart();
        //si produit déjà dans le panier 
        if(isset($cart[$id])){
            //si il y a plus d'une fois le produit dans le panier on décrémente
            if($cart[$id] >1){
                $cart[$id] --;
            }else{
                //Sinon on supprime
                unset($cart[$id]);
            }
            //on met à jour la session
            $this->updateCart($cart);
        }
    }

    // methode de suppression de toutes les quantités liees a un article 
    public function deleteAllQuantityFromCart($id){
        //recuperation du dernier panier enregistrer en session
        $cart = $this->getCart();
        //si produit(s) déjà dans le panier 
        if(isset($cart[$id])){
                //on supprime
            unset($cart[$id]);
        }
            //on met à jour la session
        $this->updateCart($cart);
    }

    // methode de suppression de panier en en tier
    public function deleteCart(){
        //on supprime tous les produits (en vidant le tableau []) + mise a jour
        $this->updateCart([]);
    }

    //methode de mise a jour du panier
    public function updateCart($cart){
        //recuperation et creation de la session cart 
        $this->requestStack->getSession()->set('cart', $cart);
        //recuperation et creation de la  session cartData 
        $this->requestStack->getSession()->set('cartData', $this->getFullCart());
    }

    public function getCart(){

        $session = $this->requestStack->getSession();
        return $session->get('cart', []);
    }

    public function getFullCart(){
        // recuperation du panier 
        $cart = $this->getCart();
        // initialisation de la quantite de produit dans le panier
        $cart_quantity = 0;
        // intialisation du prix a 0 
        $subTotal = 0;
        // declaration du tabbleau qui va recueillir les information sur le panier 
        $fullCart = [];
        // boucle for each qui parcour le tableau $cart pour recuperer l'id des produits et en determiner la quantité 
        foreach ($cart as $id => $quantity){
            // recuperation des produit grace au repository
            $product = $this->repoProduct->find($id);
            // si produit
            if($product){
                 //alors mettre la quantity et le produit dans le tableau avec la cle products
                 //qui contiendra les produits et un deuxieme tableau qui qui aura la clé data declarée plus bas
                 //qui retournera les information qte, prixttc, ht, tax
                 $fullCart['products'] []=[
                    'quantity' => $quantity,
                    'product' => $product
                ];
                // incrementation de la quantité 
                $cart_quantity += $quantity;
                // incrementation du prix 
                $subTotal += $quantity * ($product->getPrice()/100);
            }else{
                //sinon on supprime le produit et nous mettons a jour la session deleteFromCart($id) inclue une mise a jour de session
                $this->deleteFromCart($id); 
            }
        }
        // on rempli un tableau avant de la donner a la session avec la cle data qui contient les prix et les quantity incrementée
        $fullCart['data'] = [
            'cart_quantity'=>$cart_quantity,
            'subTotalHT' => $subTotal,
            'subTotalTTC' => round(($subTotal + ($subTotal * $this->tva1)),2 ),
            'tax'=> round($subTotal * $this->tva1, 2),

        ];
        return $fullCart;
    }

}