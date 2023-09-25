<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 


#[Route('/admin/config', name: 'app_config')]
class ConfigController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')] 

    public function settings(): Response
    {
        return $this->render('config/settings.html.twig');
    }
    public function delete(Request $request): Response
    {
        return $this->render('config/delete.html.twig');
    }

    function redirectBack($routeName, Request $request): Response
    {

        $previousRouteName = $request->headers->get('referer');

        $url = $request->getRequestUri(); // Get the URL from the request

        return $this->redirectToRoute($routeName);
    }
}