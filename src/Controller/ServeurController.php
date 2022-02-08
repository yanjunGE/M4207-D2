<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;

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
    public function valide(Request $request,EntityManagerInterface $manager): Response
    {
        $login=$request->request->get("login");
       $password=$request->request->get("password");
       

        $reponse = $manager -> getRepository(Utilisateur::class) -> findOneBy([ 'login' => $login]);
            if($reponse==NULL){
                $valide="utilisateur n'exsit pas";
               

            }else{
                $motdepass=$reponse -> getPassword();
                if($motdepass==$password){
                    $valide="valide";
                   
                }else{
                    $valide="password n'est pas correct";
                }
            
            }
            return $this->render('serveur/valide.html.twig', [
                    'controller_name' => 'ServeurController',
                    'login'=> $login,
                    'password'=> $password, 
                    'valide'=> $valide
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
