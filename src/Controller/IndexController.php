<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MenuRepository;
use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;

use Symfony\Component\String\Slugger\SluggerInterface;

class IndexController extends AbstractController
{
    public function __construct(
        MenuRepository $menuRepo,
        CategoryRepository $catRepo,
        ArticleRepository $articleRep
    ) {
        $this->menuRepo = $menuRepo;
        $this->catRepo = $catRepo;
        $this->articleRep = $articleRep;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $menus = $this->menuRepo->findAll();
        $categorys = $this->catRepo->findAll();

        return $this->render('index/index.html.twig', compact('menus', 'categorys'));
    }
    #[Route('/{category}', name: 'app_cat_index')]
    public function category($category)
    {

        $menus = $this->menuRepo->findByCategory($category);

        return $this->render('index/menu.html.twig', compact('menus'));

    }

    #[Route('/menu-item/{id}' , name: 'app_menu_item')]
    public function menuItem($id)  {
        $menu = $this->menuRepo->find($id);
        return $this->render('index/menu-item.html.twig',compact('menu'));
    }
}