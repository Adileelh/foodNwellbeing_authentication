<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProductCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

     public function __construct(
         private AdminUrlGenerator $adminUrlGenerator
         )
    {
      
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
        $url = $this->adminUrlGenerator
            ->setController(ProductCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);
       
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FoodNwellbeing');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Product', 'fas fa-shopping-cart', Product::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-truck', Carrier::class);
    }
}
