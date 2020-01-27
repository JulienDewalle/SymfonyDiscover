<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index(Request $request)
    {
        // Récupérer $_GET['A']
        dump($request->query->get('A'));

        //Récupérer IP utilisateur
        dump($request->server->get('REMOTE_ADDR'));

        //Renvoie un objet Request
        dump($request);

        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
        ]);
    }
    /**
     * @Route("/toto", name="toto")
     */
    public function toto() 
    {
        return $this->redirectToRoute('demo');
    }

    /**
     * @Route("/event/{slug}")
     */
    public function showEvent(Request $request, $slug, LoggerInterface $logger)
    {
        // mes evenements
        $events = ['a', 'b', 'c'];

        if(!in_array($slug, $events)) {
            // Si le slug n'est pas dans le tableau 
            throw $this->createNotFoundException('Cet événement n\'existe pas');
        }

        // On peut logguer des "trucs" dans symfony
        $ip = $request->server->get('REMOTE_ADDR');
        dump(get_class($logger));
        $logger->info($ip.'a vue l\'évenement '.$slug);

        return new Response('<body>'.$slug.'</body>');
    }
}