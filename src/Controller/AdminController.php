<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Entity\Retraite;
use App\Form\RetraiteFormType;
use App\Repository\CoursRepository;
use App\Repository\RetraiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    // GESTION DES RETRAITES

    #[Route('/retraitesliste', name: 'app_retraite_index', methods: ['GET'])]
    public function retraite(RetraiteRepository $retraiteRepository): Response
    {
        return $this->render('admin/retraite/index.html.twig', [
            'retraite' => $retraiteRepository->findAll(),
        ]);
    }

    #[Route('/newretraite', name: 'ajouter')]
    public function addRetraite(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        // creation nouveau sejour
        $retrait = new Retraite;

        // creation formulaire
        $formRetraite = $this->createForm(RetraiteFormType::class, $retrait);

        // traitement formulaire
        $formRetraite->handleRequest($request);

        // verification formulaire soumis et valide

        if ($formRetraite->isSubmitted() && $formRetraite->isValid()) {
            // dd($formRetraite['image']->getData());
            // !traitement image

            $imageFile = $formRetraite->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('img_upload'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $retrait->setImage($newFilename);
            }

            // !fin traitement image


            // requête préparée
            $manager->persist($retrait);
            $manager->flush();

            return $this->redirectToRoute('app_retraite_index');
        }

        return $this->render('admin/retraite/ajouter.html.twig', [
            'formRetraite' => $formRetraite,
        ]);
    }


    #[Route('/{id}/show', name: 'app_retraite_show', methods: ['GET'])]
    public function showRetraite(Retraite $retrait): Response
    {
        return $this->render('admin/retraite/show.html.twig', [
            'retrait' => $retrait,
        ]);
    }

    #[Route('/{id}/editer', name: 'app_retraite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Retraite $retrait, EntityManagerInterface $entityManager): Response
    {
        $formRetraite = $this->createForm(RetraiteFormType::class, $retrait);
        $formRetraite->handleRequest($request);

        if ($formRetraite->isSubmitted() && $formRetraite->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_retraite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/retraite/editer.html.twig', [
            'retrait' => $retrait,
            'formRetraite' => $formRetraite,
        ]);
    }


    #[Route('/{id}/r', name: 'app_retraite_delete', methods: ['POST'])]
    public function delete(Request $request, Retraite $retrait, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $retrait->getId(), $request->request->get('_token'))) {
            $entityManager->remove($retrait);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_retraite_index', [], Response::HTTP_SEE_OTHER);
    }
}
