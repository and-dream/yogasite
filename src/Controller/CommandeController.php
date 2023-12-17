<?php

namespace App\Controller;

use DateTime;
use App\Entity\Commande;
use App\Entity\CommandeDetails;
use App\Repository\RetraiteRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[route('/commandes', name: 'app_orders_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, RetraiteRepository $retraiteRepository, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);
        
        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('app_homepage');
        }


        //le panier n'est pas vide : création de la commande
        $order = new Commande;
        $order->setCreatedAt(new DateTimeImmutable());

        //on remplit la commande
        $order->setMembre($this->getUser());
        $order->setReference(uniqid()); //pour avoir un exemple

        //on parcourt le panier (boucle)
        foreach($panier as $item => $quantity){
            $orderDetails = new CommandeDetails;

            //on va récupérer le produit
            $product = $retraiteRepository->find($item);
            
            $price = $product->getPrice();

            //création détail de la commande
            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);

            $order->addCommandeDetail($orderDetails);
        }


        $manager->persist($order);
        $manager->flush();

        $session->remove('panier');
        
        $this->addFlash('message', 'commande créée avec succès');
        return $this->redirectToRoute('app_homepage');
       
    }
}
