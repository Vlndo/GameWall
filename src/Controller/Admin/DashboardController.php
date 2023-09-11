<?php

namespace App\Controller\Admin;

use App\Entity\Bill;
use App\Entity\Country;
use App\Entity\Images;
use App\Entity\Paiment;
use App\Entity\Platform;
use App\Entity\Product;
use App\Entity\System;
use App\Entity\Tag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GameWall');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fa fa-user',User::class);
        yield MenuItem::linkToCrud('Product', 'fa fa-list-alt',Product::class);
        yield MenuItem::linkToCrud('Tag', 'fa fa-tag',Tag::class);
        yield MenuItem::linkToCrud('System', 'fa fa-terminal',System::class);
        yield MenuItem::linkToCrud('Platform', 'fa fa-shop',Platform::class);
        yield MenuItem::linkToCrud('Paiment', 'fa fa-money-bill',Paiment::class);
        yield MenuItem::linkToCrud('Image', 'fa fa-image',Images::class);
        yield MenuItem::linkToCrud('country', 'fa fa-earth-europe',Country::class);
        yield MenuItem::linkToCrud('bill', 'fa fa-earth-europe',Bill::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
