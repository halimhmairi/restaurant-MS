<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/admin/config', name: 'app_config')]
class ConfigController extends AbstractController
{
    public function delete(Request $request): Response
    {   
        $previousRouteName = $request->headers->get('referer'); 

        $url = $request->getRequestUri(); // Get the URL from the request


        dd($previousRouteName,$url);

        return $this->render('config/delete.html.twig');
    }
    
    function redirectBack($routeName) : Response {
        return $this->redirectToRoute($routeName);
    }
}
