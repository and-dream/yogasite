<?php

namespace App\Controller;

use App\Entity\Retraite;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
  #[Route('/payment', name: 'app_payment')]
  public function index(): Response
  {
    return $this->render('payment/index.html.twig', [
      'controller_name' => 'PaymentController',
    ]);
  }


  #[Route('/checkout', name: 'checkout')]
  public function checkout($stripeSK): Response
  {

    Stripe::setAPIKey($stripeSK);
    $data = new Retraite;

    $session = Session::create([
      'line_items' => [[
        'price_data' => [
          'currency' => 'eur',
          'product_data' => [
            'name' => $data->getName(),
            'product' => $data->getPrice(),
          ],
          'unit_amount' => $data->getStock(),
        ],
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
      'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
    ]);

    // header("HTTP/1.1 303 See Other");
    // header("Location: " . $session->url); 
    return $this->redirectToRoute($session->url, [303]);
  }

  #[Route('/success-url', name: 'success_url')]
  public function successUrl(): Response
  {
    return $this->render('payment/sucess.html.twig');
  }

  #[Route('/cancel-url', name: 'cancel_url')]
  public function cancelUrl(): Response
  {
    return $this->render('payment/cancel.html.twig');
  }
}
