<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Menu;
use App\Repository\MenuRepository;

class IndexController extends AbstractController
{
    public function __construct(MenuRepository $menuRepo)
    {
        $this->menuRepo = $menuRepo;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
       $menus = $this->menuRepo->findAll();

        return $this->render('index/index.html.twig', compact('menus'));
    }
}
