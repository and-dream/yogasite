<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    #[Route('/agenda', name: 'app_agenda')]
    public function index(CalendarRepository $calendar): Response
    {
        $events = $calendar->findAll();

        // dd($events);
        $rdvs = [];
        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('d-m-Y H:i:s'),
                'end' => $event->getEnd()->format('d-m-Y H:i:s'),
                'title' => $event->getId(),
                'description' => $event->getId(),
                'backgroundColor' => $event->getId(),
                'textColor' => $event->getId(),



            ];
        }
        $data = json_encode($rdvs);

        return $this->render('agenda/index.html.twig', compact('data'));
    }
}
