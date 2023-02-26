<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StockRepository;
use App\Factory\StockFactory;
use App\Form\StockFormType;
use App\Entity\Stock;

#[Route('admin/')]
class StockController extends AbstractController
{
    public $stockRepo;

    public function __construct(StockRepository $stockRepo){
        $this->stockRepo = $stockRepo;
    }

    #[Route('stock', name: 'app_stock')]
    public function index(): Response
    { 
        //StockFactory::createMany(5);

        $stocks = $this->stockRepo->findAll(); 
      
        return $this->render('stock/index.html.twig', compact('stocks'));
    }

    #[Route('stock/create' , name: 'create_stock')]
    public function create(): Response
    {

        $stock = new Stock();

        // $form = $this->createFormBuilder();
        $form = $this->createForm(StockFormType::class,$stock);
        return $this->render('stock/create.html.twig',['form'=>$form->createView()]);
    }


}
