<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\ContactType;
use App\Form\CommandeType;
use App\Repository\RetraiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/meditation', name: 'app_meditation')]
    public function meditation(): Response
    {
        return $this->render('home/meditation.html.twig');
    }


    #[Route('/retraites', name: 'app_retraites')]
    public function retraites(RetraiteRepository $repo): Response
    {

        return $this->render('home/retraites.html.twig', [
            'retraite' => $repo->findAll(),
        ]);
    }


    // Pour plus tard lorsque Holi Sens voudra lancer son e-shop
    #[Route('/boutique', name: 'app_shop')]
    public function boutique(): Response
    {
        return $this->render('home/boutique.html.twig');
    }

    #[Route('/formules', name: 'app_formules')]
    public function formules(): Response
    {
        return $this->render('home/formules.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('home/mentions.html.twig');
    }

    #[Route('//cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('home/cgv.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($form);
            $manager->flush();
        }

        return $this->render('home/contact.html.twig', [
            'formContact' => $form
        ]);
    }
}

