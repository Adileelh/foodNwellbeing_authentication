<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    private $productRepo;
    private $categoryRepo;


    public function __construct(ProductRepository $productRepo, CategoriesRepository $categoryRepo){
        $this->productleRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepo): Response
    {
        $products = $productRepo->findAll();

         $productBestSeller =  $productRepo->findByIsBestSeller(1);
         $productNewArrival =  $productRepo->findByIsNewArrival(1);
         $productFeatured =  $productRepo->findByIsFeatured(1);
         $productSpecialOffer =  $productRepo->findByIsSpecialOffer(1);

        //  dd([$productBestSeller, $productNewArrival, $productFeatured, $productSpecialOffer]);

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'productNewArrival' =>  $productNewArrival,
            'productBestSeller' => $productBestSeller,
            'productFeatured' =>  $productFeatured,
            'productSpecialOffer' =>$productSpecialOffer,
        ]);
    }

    #[Route('/product/{slug}', name: 'product_details')]

    public function show(?Product $product):response
    {

        if (!$product) {

            return $this->redirectToRoute('home');
        }

        return $this->render('home/single.html.twig',[
            'product'=>$product,
        ]);
    }
 }
