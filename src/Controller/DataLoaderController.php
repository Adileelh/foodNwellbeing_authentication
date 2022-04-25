<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataLoaderController extends AbstractController
{
    #[Route('/data', name: 'app_data_loader')]
    public function index(EntityManagerInterface $manager): Response
    {
        // creation objet metier recu en json (remonte a la racine car le json a ete mis a la racine)
        $file_products= dirname(dirname(__DIR__))."\prod.json";
        // mise en format ph avec json_decode
        $data_products = json_decode(file_get_contents($file_products))[0]->rows;
        $file_categories= dirname(dirname(__DIR__))."\cat.json";
        $data_categories = json_decode(file_get_contents($file_categories))[0]->rows;
        // dd( $data_products);
        // dd( $data_categories);
        // delaration des tableau vide pour les remplir ensuite
        $categories = [];
        $products = [];
        

        // boucle foreach pour parcourir le tableau php creer plus haut et en extraire les donnees voulue au champ voulue voir les index avec dd($variable) pour reperer les champs
       foreach ($data_categories as $data_category) {
           
            $category = new Categories();
            $category->setName($data_category[1])
                     ->setImage($data_category[3]);
            // on persist les donnees recuperee dans $category
            $manager->persist($category);
            // on affecte les donnees dans le tableau vide $categories[]
            $categories[] = $category;
       }

       foreach ($data_products as $data_product) {
           
            $product = new Product();
            $product->setName($data_product[1])
                    ->setDescription($data_product[2])
                    ->setPrice($data_product[4])
                    ->setIsBestSeller($data_product[5])
                    ->setIsNewArrival($data_product[6])
                    ->setIsFeatured($data_product[7])
                    ->setIsSpecialOffer($data_product[8])
                    ->setImage($data_product[9])
                    ->setBrand($data_product[10])
                    ->setQuantity(intval($data_product[11]))
                    ->setSlug($data_product[14])
                    ->setTags($data_product[13])
                    ->setCreatedAt(new \DateTimeImmutable());
            // on persist les donnees recuperee dans $category
            $manager->persist($product);
            // on affecte les donnees dans le tableau vide $categories[]
            $products[] = $product;
       }
    //    $manager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DataLoaderController.php',
        ]);
    }
}
