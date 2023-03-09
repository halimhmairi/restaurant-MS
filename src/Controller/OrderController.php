<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Factory\OrderFactory;
use App\Repository\OrderRepository;
#[Route('/admin')]
class OrderController extends AbstractController
{
    public $orderRepo;

    public function __construct(OrderRepository $orderRepo)
    {
       $this->orderRepo = $orderRepo;
    }

    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
        $orders = $this->orderRepo->findAll(); 
        
        return $this->render('order/index.html.twig',compact('orders'));
    }

    #[Route('order/generate/{number}',name:'generate_order')]
    public function generateFakeData($number)
    {
        OrderFactory::createMany($number);
        return $this->redirectToroute('app_order');
    }



}
