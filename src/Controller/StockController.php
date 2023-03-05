<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StockRepository;
use App\Factory\StockFactory;
use App\Form\StockFormType;
use App\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;
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
        $stocks = $this->stockRepo->findAll(); 
      
        return $this->render('stock/index.html.twig', compact('stocks'));
    }

    #[Route('stock/create' , name: 'create_stock')]
    public function create(Request $request): Response
    {
        $stock = new Stock(); 
        
        $form = $this->createForm(StockFormType::class,$stock);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $this->stockRepo->save($data,true); 
          
            return $this->redirectToRoute('app_stock');
        }
        
        return $this->render('stock/create.html.twig',['form'=>$form->createView()]);
    }

    #[Route('stock/delete/{stockId}','delete_stock')]
    public function delete($stockId)
    {
        $stock = $this->stockRepo->find($stockId);
        $this->stockRepo->remove($stock, true);

        $this->addFlash("success","deleted");
       
        return $this->redirectToRoute('app_stock');
    }

    #[Route('stock/generate/{$number}','generate_stock')]
    public function generateFakeData($number)
    {
        StockFactory::createMany($number);
        return $this->redirectToRoute('app_stock');

    }


}
