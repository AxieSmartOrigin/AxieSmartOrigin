<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Card;
use App\Entity\User;
use App\Entity\Part;
use App\Entity\AxieClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Axie Origin Builder');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('All Cards', 'fas fa-eye', Card::class);
        yield MenuItem::linkToCrud('Parts', 'fas fa-child', Part::class);
        yield MenuItem::linkToCrud('Class', 'fas fa-leaf', AxieClass::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tag', Tag::class);
    }
}
