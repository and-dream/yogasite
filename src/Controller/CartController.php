<?php

namespace App\Controller;

use App\Entity\Retraite;
use App\Repository\RetraiteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, RetraiteRepository $retraiteRepository)
    {
        $panier = $session->get('panier', []);

        //initialiser les variables
        $data = [];
        $total = 0;

        foreach ($panier as $id => $quantity) {
            $retraite = $retraiteRepository->find($id);

            //on ajoute dans le data panier

            $data[] = [
                'retraite' => $retraite,
                'quantity' => $quantity

            ];
            $total += $retraite->getPrice() * $quantity;
        }
        return $this->render('cart/index.html.twig', compact('data', 'total'));
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Retraite $retraite, SessionInterface $session)
    {
        //récupérer l'id du produit
        $id = $retraite->getId();

        //récupérer le panier (dans la session) s'il y en a un
        $panier = $session->get('panier', []);

        //ajout du produit dans le panier
        //sinon on incrémente sa quantité
        //'empty' va renvoyer vrai si la variable n'existe pas

        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        //je passe ma variable dans la session (sauvegarde dans la session)
        $session->set('panier', $panier);

        //on redirige vers la page du panier
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Retraite $retraite, SessionInterface $session)
    {
        // je récupère le panier actuel
        $id = $retraite->getId();
        $panier = $session->get('panier', []);

        //retirer le produit du panier s'il n'y a qu'un seul produit
        //sinon on décrémente sa quantité
        //là on vérifie si ce n'est PAS vide
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {

                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Retraite $retraite, SessionInterface $session)
    {

        $id = $retraite->getId();
        $panier = $session->get('panier', []);

        // on vérifie si on n'a rien
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }

    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
}
