<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Menu;
use App\Repository\MenuRepository;
use App\Repository\CategoryRepository;

class IndexController extends AbstractController
{
    public function __construct(MenuRepository $menuRepo ,CategoryRepository $catRepo)
    {
        $this->menuRepo = $menuRepo;
        $this->catRepo = $catRepo;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
       $menus = $this->menuRepo->findAll();
       $categorys = $this->catRepo->findAll();

        return $this->render('index/index.html.twig', compact('menus','categorys'));
    }
}
