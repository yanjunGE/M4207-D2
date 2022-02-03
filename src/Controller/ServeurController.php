<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ServeurController extends AbstractController
{
    /**
     * @Route("/serveur", name="serveur")
     */
    public function index(Request $request): Response
    {
        return $this->render('serveur/index.html.twig', [
            'controller_name' => 'ServeurController',
        ]);
        
       
      
    }
        
    /**
     * @Route("/valide", name="valide")
     */
    public function valide(Request $request): Response
    {
        $login=$request->request->get("root");
        $password=$request->request->get("valide");

        
            return $this->rendre('serveur/valide.html.twig', [
                'controller_name' => 'ServeurController',
                'login'=> $login,
                'password'=> $password,
            ]);
        

    }
    /**
     * @Route("/signup", name="creerutilisateur")
     */
    public function signup(): Response
    {
        return $this->render('serveur/creerutilisateur.html.twig', [
            'controller_name' => 'ServeurController',
        ]);

        
    } 

      
    
            
    
}
