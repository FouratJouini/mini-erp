<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Facture;
use App\Entity\Fournisseur;
use App\Entity\Operation;
use App\Entity\Stock;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/admin_dash.html.twig', [
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Caisse');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::subMenu('Stock', 'fas fa-boxes')->setSubItems([
            MenuItem::linkToCrud('Catégories', 'fas fa-list', Categorie::class),
            MenuItem::linkToCrud('Articles', 'fas fa-list', Article::class),
            MenuItem::linkToCrud('Stock', 'fas fa-list', Stock::class),
        ]);
        yield MenuItem::linkToCrud('Clients', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('Fournisseurs', 'fas fa-list', Fournisseur::class);
        yield MenuItem::subMenu('Caisse', 'fas fa-boxes')->setSubItems([
            MenuItem::linkToCrud('Achats', 'fas fa-list', Operation::class)
                ->setQueryParameter('type', 'achat'),
            MenuItem::linkToCrud('Ventes', 'fas fa-list', Operation::class)
                ->setQueryParameter('type', 'vente'),
        ]);
        yield MenuItem::subMenu('Compta', 'fas fa-boxes')->setSubItems([
            MenuItem::linkToCrud('Factures', 'fas fa-list', Facture::class)
                ->setQueryParameter('type', 'achat'),
            MenuItem::linkToCrud('Ventes non indexés', 'fas fa-list', Operation::class)
                ->setQueryParameter('type', 'vente')
                ->setQueryParameter('indexed', false),
            MenuItem::linkToCrud('Suivie', 'fas fa-list', Operation::class)
                ->setQueryParameter('showItems', false),
        ]);
    }
}
