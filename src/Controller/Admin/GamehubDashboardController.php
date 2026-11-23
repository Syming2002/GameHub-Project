<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class GamehubDashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(BoardGameCrudController::class)
                ->setAction(Action::INDEX)
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet GameHub');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Gamehub Dashboard', 'fa fa-home');
        
        yield MenuItem::section('Board Game Section');

        yield MenuItem::linkTo(BoardGameCrudController::class, 'Board Games', 'fas fa-dice');


        yield MenuItem::section('Booking Section');

        yield MenuItem::linkTo(BookingCrudController::class, 'Booking', 'fas fa-calendar-check');


        yield MenuItem::section('Category Section');

        yield MenuItem::linkTo(CategoryCrudController::class, 'Categories', 'fas fa-table-list');

        yield MenuItem::section('Party Game Section');

        yield MenuItem::linkTo(PartyGameCrudController::class, 'Party Games', 'fas fa-puzzle-piece');

        // gestions des utilisateurs
        yield MenuItem::section('User Section');
        yield MenuItem::linkTo(UserCrudController::class, 'Users', 'fas fa-user');
    }
}
