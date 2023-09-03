<?php

namespace App\Controller\Admin;

use App\Entity\DishOrDrink;
use App\Entity\Menu;
use App\Entity\Place;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
// redirect to easyadmin Place CRUD controller
//        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
//        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        return $this->render('admin/dashboard.html.twig', [
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MenusSolution')
            ->setFaviconPath('favicon.ico')
            ->setTranslationDomain('admin')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // get place of user
        $place = $this->getUser()->getPlace();
        // if user has ROLE_ADMIN display link to edit his own place
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            yield MenuItem::linkToCrud('Mon restaurant', 'fa fa-cutlery', Place::class)->setController(PlaceCrudController::class)->setAction(Action::EDIT)->setDefaultSort(['id' => 'ASC'])->setEntityId($place->getId());
        }
        yield MenuItem::linkToCrud('Plats et boissons', 'fa fa-glass', DishOrDrink::class);
        yield MenuItem::linkToCrud('Les cartes', 'fa fa-list', Menu::class);
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            // Section spécifique pour les super admins
            yield MenuItem::section('Super Admin');
            yield MenuItem::linkToCrud('Restaurants', 'fa fa-cutlery', Place::class);
            yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
            // get all places
            $places = $this->entityManager->getRepository(Place::class)->findAll();
            // for each place create subMenu with every linked menus
            foreach ($places as $place) {
                yield MenuItem::subMenu($place->getName())->setSubItems(
                    [
                        MenuItem::linkToCrud('Restaurant', 'fa fa-cutlery', Place::class)->setController(PlaceCrudController::class)->setAction(Action::DETAIL)->setDefaultSort(['id' => 'ASC'])->setEntityId($place->getId()),
                        MenuItem::linkToCrud('Menus', 'fa fa-list', Menu::class)->setController(MenuCrudController::class)->setAction(Action::INDEX)->setDefaultSort(['id' => 'ASC']),
                        MenuItem::linkToCrud('Dishes/Drinks', 'fa fa-glass', DishOrDrink::class)->setController(DishOrDrinkCrudController::class)->setAction(Action::INDEX)->setDefaultSort(['name' => 'ASC'])->setQueryParameter('filters', ['place' => ['value' => $place->getId()]]),
                        MenuItem::linkToCrud('Users', 'fa fa-user', User::class)->setController(UserCrudController::class)->setAction(Action::INDEX)->setDefaultSort(['lastName' => 'ASC'])->setQueryParameter('filters', ['place' => ['value' => $place->getId()]]),
                        ]
                );
            }
        }
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
