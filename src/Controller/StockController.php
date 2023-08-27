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

#[Route('admin/stock')]
class StockController extends AbstractController
{
    public $stockRepo;

    public function __construct(StockRepository $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    #[Route('/', name: 'app_stock')]
    public function index(): Response
    {
        $stocks = $this->stockRepo->findAll();
        return $this->render('stock/index.html.twig', compact('stocks'));
    }

    #[Route('/create', name: 'create_stock')]
    public function create(Request $request): Response
    {
        $stock = new Stock();
        $form = $this->createForm(StockFormType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->stockRepo->save($data, true);
            return $this->redirectToRoute('app_stock');
        }

        return $this->render('stock/create.html.twig', ['form' => $form->createView()]);
    }
    #[Route('/edit/{id}', name: 'edit_stock')]
    public function edit($id): Response
    {
        $stockDB = $this->stockRepo->find($id);
        $stock = new Stock();
        $stock->setName($stockDB->getName());
        $stock->setDescription($stockDB->getDescription());
        $stock->setPrice($stockDB->getPrice());
        $stock->setQuantity($stockDB->getQuantity());
        $form = $this->createForm(StockFormType::class, $stock, ['action' => $this->generateUrl('update_stock', ['id' => $id])]);

        return $this->render('stock/edit.html.twig', ['form' => $form->createView()]);
    }
    #[Route('/update/{id}', name: 'update_stock')]
    public function update(Request $request, $id): Response
    {
        $data = $request->request->all()['stock_form'];
        $data['id'] = $id;
        $update = $this->stockRepo->update($data);
        return $this->redirectToRoute('edit_stock', ['id' => $id]);
    }

    #[Route('/delete/{stockId}', 'delete_stock')]
    public function delete($stockId)
    {
        $stock = $this->stockRepo->find($stockId);
        $this->stockRepo->remove($stock, true);
        $this->addFlash("success", "deleted");
        return $this->redirectToRoute('app_stock');
    }

    #[Route('/generate/{$number}', 'generate_stock')]
    public function generateFakeData($number)
    {
        StockFactory::createMany($number);
        return $this->redirectToRoute('app_stock');

    }


}