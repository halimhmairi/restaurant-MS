<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Form\ArticleFormType;
use App\Entity\Article;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        $article = new Article();
        $article_form = $this->createForm(ArticleFormType::class,$article,["action"=>$this->generateUrl('store_article')]);
        $article_form = $article_form->createView();

        return $this->render('article/create.html.twig',compact('article_form'));
    }

    #[Route('/store',name:'store_article')]
    public function store(Request $request,SluggerInterface $slugger): Response
    {
        $article = new Article();
        $article_form = $this->createForm(ArticleFormType::class,$article);
        $article_form->handleRequest($request);

        if($article_form->isSubmitted() && $article_form->isValid())
        {
            $data = $article_form->getData();
            $now = new \DateTimeImmutable();
            $article->setCreatedAt($now);
            $this->articlerepo->save($data,true);

         return  $this->redirectToRoute("create_article");
        }


    }

    #[Route('/remove',name:'remove_article')]
    public function remove(): Response
    {

    }
}
