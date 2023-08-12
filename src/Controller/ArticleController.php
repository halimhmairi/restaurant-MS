<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
#[Route('/admin/article')]
class ArticleController extends AbstractController
{
    public function __construct(ArticleRepository $articlerepo)
    {
        $this->articlerepo = $articlerepo;
    }
    #[Route('/', name: 'app_article')]
    public function index(): Response
    {
       $articles =  $this->articlerepo->findAll();

        return $this->render('article/index.html.twig',compact('articles'));
    }

    #[Route('/create',name:'create_article')]
    public function create(): Response
    {
        return $this->render('article/create.html.twig');
    }

    #[Route('/store',name:'store_article')]
    public function store(): Response
    {
        //
    }

    #[Route('/remove',name:'remove_article')]
    public function remove(): Response
    {

    }
}
