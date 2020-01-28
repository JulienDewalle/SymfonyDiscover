<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    /**
     *  on va creer deux nouvelles routes :
     * /voir-session : afficher le contenu de la clé name dans la session
     *                  n'affiche rien lors de la premiére visite sur le site
     * /mettre-en-session/{name} : Mettre en session la valeur passée dans l'url
     * 
     */

     /**
      * @Route("/voir-session", name="show_session")
      */
      public function showSession(SessionInterface $session) 
      {
          dump($session->get('name'));
          
          return $this->render('demo/show_session.html.twig');
      }

      /**
     * @Route("/mettre-en-session/{name}", name="put_session")
     */
    public function putSession($name, SessionInterface $session)
    {
        // Je mets $name en session
        $session->set('name', $name); // Equivaut à $_SESSION['name'] = $name;

        // on peut crée un message flash
        $this->addFlash('success', 'Message de succès');

        return $this->redirectToRoute('show_session');
    }

    /**
     * @Route("/protected.pdf", name="cv")
     */
    public function dowloadCv() 
    {
        $authorized = (bool) rand(0, 1);
        if ($authorized){
            throw $this->createNotFoundException('Vous ne pouvez pas récuperez ce CV.');
        }
        return  $this->file(
            '../CV-julien-Dewalle.pdf',
             'new_file.pdf',
              ResponseHeaderBag::DISPOSITION_INLINE);
    }
}