<?php

namespace App\Controller;

use App\Service\FileServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Factory\MenuFactory;
use App\Repository\MenuRepository;
use App\Form\MenuType;
use App\Entity\Menu;

#[Route("/admin/menu")]
class MenuController extends AbstractController
{
    public $menuRepo;
    public $fileServices;

    public function __construct(MenuRepository $menuRepo, FileServices $fileServices)
    {
        $this->menuRepo = $menuRepo;
        $this->fileServices = $fileServices;
    }


    #[Route('/', name: 'app_menu')]
    public function index(): Response
    {
        // MenuFactory::createMany(5);

        $menus = $this->menuRepo->findAll();

        return $this->render('menu/index.html.twig', compact("menus"));
    }

    #[Route('/create', name: 'create_menu')]
    public function create(Request $request, SluggerInterface $slugger): Response
    {
        $menu = new Menu();
        $formMenu = $this->createForm(MenuType::class, $menu);
        $formMenu->handleRequest($request);

        if ($formMenu->isSubmitted() && $formMenu->isValid()) {

            $formMenus = $formMenu->getData();
            $formMenuFile = $formMenu->get('image')->getData();

            if ($formMenuFile) {

                $newFilename = $this->fileServices->UploadFiles($formMenuFile);

                $menu->setImage($newFilename);

                $this->menuRepo->save($formMenus, true);

            }

            $this->addFlash('success', 'add');
            return $this->redirectToRoute('app_menu');
        }

        $formMenu = $formMenu->createView();

        return $this->render('menu/create.html.twig', compact("formMenu"));
    }

    #[Route('/edit/{id}', name: 'edit_menu')]
    public function edit($id)
    {
        $menuDB = $this->menuRepo->find($id);

        $menuEntity = new Menu();

        $menuEntity->setName($menuDB->getName());
        $menuEntity->setPrice($menuDB->getPrice());
        $menuEntity->setOffre($menuDB->getOffre());
        $menuEntity->setDescription($menuDB->getDescription());


        //$menuEntity->setImage(file_get_contents(realpath("images/".$menuDB->getImage())));

        $menuEntity->setCategory(($menuDB->getCategory()));

        $formMenu = $this->createForm(MenuType::class, $menuEntity, ["action" => $this->generateUrl("update_menu", ["id" => $menuDB->getId()])]);
        $formMenu = $formMenu->createView();

        return $this->render('menu/edit.html.twig', compact("formMenu"));
    }
    #[Route('/update/{id}', name: 'update_menu')]
    public function update(Request $request, $id)
    {

        $image = $request->files->all()["menu"]["image"];

        $data = $request->request->all()["menu"];
        $data['id'] = $id;

        if ($image) {
            $data['image'] = $this->fileServices->UploadFiles($image);
        }

        $this->menuRepo->update($data);

        return $this->redirectToRoute('app_menu');
    }

    #[Route('/delete/{menuId}', name: 'delete_menu')]
    public function delete($menuId)
    {
        $menu = $this->menuRepo->find($menuId);
        $this->menuRepo->remove($menu, true);

        $this->addFlash('success', 'deleted');

        return $this->redirectToRoute('app_menu');
    }


    #[Route('/generate/{number}', 'generate_menu')]
    public function generateFakeData($number)
    {
        MenuFactory::createMany($number);
        return $this->redirectToRoute('app_menu');

    }
}