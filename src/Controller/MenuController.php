<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Factory\MenuFactory;
use App\Repository\MenuRepository;
use App\Form\MenuType;
use App\Entity\Menu;
#[Route("/admin")]
class MenuController extends AbstractController
{
    public $menuRepo;

    public function __construct(MenuRepository $menuRepo){
        $this->menuRepo = $menuRepo;
    }


    #[Route('/menu', name: 'app_menu')]
    public function index(): Response
    {
       // MenuFactory::createMany(5);

       $menus = $this->menuRepo->findAll();

        return $this->render('menu/index.html.twig', compact("menus"));
    }

    #[Route('/menu/create' , name: 'create_menu')]
    public function create(Request $request ,SluggerInterface $slugger): Response
    {
        $menu = new Menu();
        $formMenu = $this->createForm(MenuType::class,$menu);
        $formMenu->handleRequest($request);

        if($formMenu->isSubmitted() && $formMenu->isValid())
        {
         
            $formMenus = $formMenu->getData(); 

            $formMenuFile = $formMenu->get('image')->getData(); 

            if ($formMenuFile) {
                $originalFilename = pathinfo($formMenuFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$formMenuFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $formMenuFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd("folder not found");
                    // ... handle exception if something happens during file upload
                }

                $menu->setImage($newFilename); 

                $this->menuRepo->save($formMenus,true);
                
            }

            $this->addFlash('success','add');
            return $this->redirectToRoute('app_menu');
        }

        $formMenu = $formMenu->createView();

        return $this->render('menu/create.html.twig',compact("formMenu"));
    }

    #[Route('/menu/delete/{menuId}',name:'delete_menu')]
    public function delete($menuId)
    {
       $menu =  $this->menuRepo->find($menuId);
       $this->menuRepo->remove($menu,true);

       $this->addFlash('success','deleted');

       return $this->redirectToRoute('app_menu');
    } 


    #[Route('/menu/generate/{number}','generate_menu')]
    public function generateFakeData($number)
    {
        MenuFactory::createMany($number);
        return $this->redirectToRoute('app_menu');

    }
}
