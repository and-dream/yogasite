<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/apropos.html.twig');
    }

    #[Route('/cours', name: 'app_cours')]
    public function cours(): Response
    {    
        return $this->render('home/cours.html.twig');
    }


    #[Route('/retraites', name: 'app_retraites')]
    public function retraites(): Response
    {
        return $this->render('home/retraites.html.twig');
    }

    // Pour plus tard lorsque Holi Sens voudra lancer son e-shop
    #[Route('/boutique', name: 'app_shop')]
    public function boutique(): Response
    {
        return $this->render('home/boutique.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('home/mentions.html.twig');
    }

    #[Route('//cgv', name:'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('home/cgv.html.twig');
    }

    #[Route('/contact', name:'app_contact')]
    public function contact(Request $request): Response
    {
       $form = $this->createForm(ContactType::class);
        return $this->render('home/contact.html.twig', [
            'formContact' => $form
        ]);
    }


}
