<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/category')]
class CategoryController extends AbstractController
{

    public function __construct(CategoryRepository $catRepo){

        $this->catRepo = $catRepo;

    }

    #[Route('/', name: 'app_category')]
    public function index(): Response
    {
       $categorys =  $this->catRepo->findAll();

       return $this->render('category/index.html.twig', compact('categorys'));
    }

    #[Route('/create', name : 'create_category')] 
    public function create() :  Response 
    {
        $category = new Category();
        $category_form = $this->createForm(CategoryFormType::class,$category,['action' => $this->generateUrl('store_category')]);
        $category_form = $category_form->createView();

        return $this->render('category/create.html.twig',compact('category_form'));
    }

    #[Route('/store' , name : 'store_category')]
    public function store(Request $request ,SluggerInterface $slugger) : Response
    {
        $category = new Category();
        $category_form = $this->createForm(CategoryFormType::class,$category);
        $category_form->handleRequest($request);

        if($category_form->isSubmitted())
        {
            $data = $category_form->getData();
            $image_category = $category_form->get('image')->getData();

            if($image_category)
            {
              $originalFilename = pathinfo($image_category->getClientOriginalName(),PATHINFO_FILENAME);
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$image_category->guessExtension(); 

              try
              {

                $image_category->move($this->getParameter('images_directory'),$newFilename); 

              }catch(FileException $e)
              {
                dd("folder not found"); 
              }

              $category->setImage($newFilename); 
              $this->catRepo->save($data,true);

            }

            $this->addFlash('success','add');
            return $this->redirectToRoute('app_category'); 
        }
        dd($category_form->getErrors());

    }

    #[route('/edit/{id}',name:'edit_category')]
    public function edit($id) : Response 
    {
      $category = new Category();
      $category_form = $this->createForm(CategoryFormType::class,$category,['action' => $this->generateUrl('store_category')]);
      $category_form = $category_form->createView();

      return $this->render('category/edit.html.twig',compact('category_form'));
    }

    #[Route('/delete/{id}' , name : 'delete_category')]
    public function delete($id)
    {
       $category = $this->catRepo->find($id);
       $this->catRepo->remove($category,true);
       $this->addFlash('success','deleted');
       return $this->redirectToRoute('app_category');
    }

}
