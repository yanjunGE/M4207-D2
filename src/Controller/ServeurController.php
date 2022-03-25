<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Persistence\ManagerRegistry;

class ServeurController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request): Response
    {
        return $this->render('serveur/index.html.twig', [
            'controller_name' => 'ServeurController',
        ]);
        
       
      
    }

    /**
     * @Route("/logout", name="logout")
     */
    
    public function logout(Request $request,SessionInterface $session): Response
    {
		
		$session = $request->getSession();
		$session->clear();
		
        return $this->redirectToRoute('login');
    }
    
   
    
   
        
    /**
     * @Route("/valide", name="valide")
     */
    public function valide(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $login=$request->request->get("login");
       $password=$request->request->get("password");
       dump($login,$password);
		$val=0;

        $reponse = $manager -> getRepository(Utilisateur::class) -> findOneBy([ 'login' => $login]);
            if($reponse==NULL){
                $valide="utilisateur n'exsit pas";
               
               

            }else{
                $motdepass=$reponse -> getPassword();
                
                if($motdepass==$password){
                    $valide="valide";
                     $val=1;
				    dump($val);
                    $session = new Session();
                    $userId=$reponse ->getId();
                    $userId = $session -> set('userId',$userId);
                  
                    $session->set('idUser', $reponse->getId());
                    dump($session->get('nameUser'));
                   return $this->redirectToRoute('affiche');
                }else{
                    $valide="password n'est pas correct";
                }
            
            }
            
            return $this->render('serveur/valide.html.twig', [
                    'controller_name' => 'ServeurController',
                    'login'=> $login,
                    'password'=> $password, 
                    'valide'=> $valide,
                    
                    ]);

    }

    /**
    * @Route("/supprimerUtilisateur/{id}",name="supprimer_Utilisateur")
    */
    public function supprimerUtilisateur(EntityManagerInterface $manager,Utilisateur $editutil): Response {
        $manager->remove($editutil);
        $manager->flush();
        // Affiche de nouveau la liste des utilisateurs
        return $this->redirectToRoute ('affiche');
    }
    /**
     * @Route("/signup", name="creerutilisateur")
     */
    public function signup(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    { 
        $session = $request->getSession();
		
		if($session->get('userId')==NULL){
			
			return $this->redirectToRoute('login');
		}else{	
        return $this->render('serveur/creerutilisateur.html.twig', [
            'controller_name' => 'ServeurController',
        ]);
    }
    } 
     /**
     * @Route("/newutilisateur", name="newutilisateur")
     */
    public function newutilisateur(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $session = $request->getSession();
		
		if($session->get('userId')==NULL){
			
			return $this->redirectToRoute('login');
		}else{	
        $newlogin=$request->request->get("newlogin");
        $newpassword=$request->request->get("newpassword1");
        $newutilisateur= new Utilisateur();
        $newutilisateur->setlogin($newlogin);
        $newutilisateur->setpassword($newpassword);
        $manager -> persist($newutilisateur);
        $manager ->flush();
        return $this->redirectToRoute ('affiche');
    }
          
    }
     /**
     * @Route("/affiche", name="affiche")
     */
    public function affiche(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        if($session->get('userId')==NULL){
			
			return $this->redirectToRoute('login');
		}else{	
        $mesUtilisateurs = $manager->getRepository(Utilisateur::class)->findAll();
        return $this->render('serveur/affiche.html.twig',['lst_utilisateurs' => $mesUtilisateurs]);
            
        }

        
    } 
     /**
     * @Route("/session", name="session")
     */
    public function session(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        $vs = $session -> get('login');
        $userId = $session -> get('userId');
       
        $utilisateur = $manager -> getRepository(Utilisateur::class)->findOneById($userId);
        if ($utilisateur==NULL){
            return $this->redirectToRoute ('logout');
        }else{
            return $this->redirectToRoute ('affiche');
        }

        //$val = 44;
        //$session -> set('situation',$val);

    
        
          
    }
     /**
     * @Route("/menu", name="menu")
     */
    public function menu(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        
            return $this->redirectToRoute ('login');
        

        //$val = 44;
        //$session -> set('situation',$val);

        
          
    }
      /**
     * @Route("/listedocuments", name="listedocuments")
     */
    public function listedocuments(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
    {
        if($session->get('userId')==NULL){
			
			return $this->redirectToRoute('login');
		}else{	
        $mesDocuments = $manager->getRepository(Document::class)->findAll();
        return $this->render('serveur/listededocuments.html.twig',['lst_documents' => $mesDocuments]);
            
        }

        
    } 
      /**
     * @Route("/insertdocuments", name="insertdocuments")
     */
    public function insertdocuments(Request $request,EntityManagerInterface $manager,SessionInterface $session,ManagerRegistry $doctrine): Response
    {
        if($session->get('userId')==NULL){
			
			return $this->redirectToRoute('login');
		}else{	
            return $this->render('serveur/insertdocument.html.twig', [
				'Document' => $doctrine->getRepository(Document::class)->findAll(),
				'Utilisateur' => $doctrine->getRepository(Utilisateur::class)->findAll(),
			]); 
        }

        
    } 
     /**
     * @Route("/uploadDocument", name="uploadDocument")
     */
    public function uploadDocument(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $em): Response
    {
		
		if($session->get('userId')==NULL){
			
			return $this->redirectToRoute('login');
			
		}else{	
			
			$doc = new Document();
			$doc->setLogin($request->request->get('login'));
			$doc->setChemin("toto");
			if($request->request->get('choixBox')=="on"){
				$doc->setActif(1);
			}else{
				$doc->setActif(0);
			}
			$doc->setCreatedAt(new \DatetimeImmutable);
			$doc->setType($doctrine->getRepository(Genre::class)->findOneById($request->request->get('genre')));
			$em->persist($doc);
			$em->flush();
			//maj de la table acces
			$acces = new Acces();
			$acces->setDocument($doc);
			$acces->setAutorisation($doctrine->getRepository(Autorisation::class)->findOneById(2));
			$acces->setUtilisateur($doctrine->getRepository(User::class)->findOneById($session->get('idUser')));
			$em->persist($acces);
			$em->flush();
			if($request->request->get('user')!="null"){
				$acces = new Acces();
				$acces->setDocument($doc);
				$acces->setAutorisation($doctrine->getRepository(Autorisation::class)->findOneById(2));
				$acces->setUtilisateur($doctrine->getRepository(User::class)->findOneById($request->request->get('user')));
				$em->persist($acces);
				$em->flush();
			}
			//5) sinon on renvoie la page demandée.
			return $this->redirectToRoute('listedocuments');
		}
    }
    

      
    
            
    
}
