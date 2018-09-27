<?php

namespace App\Controller;
use App\Entity\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//////////////
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//////////////////////

class DataController extends AbstractController
{

    
        /**
        * @Route("/add")
        * Method({"GET", "POST"})
        */
        public function new(Request $request)
        {   
            
            $user = new users();
            $user->setName('Podaj imie');
            $user->setSname('Podaj nazwisko');
           
    
            $form = $this->createFormBuilder($user)
                ->add('Name', TextType::class)
                ->add('Sname', TextType::class)
                ->add('file', FileType::class)
                ->add('save', ButtonType::class, array('label' => 'Create Task'))
                ->getForm();
            
          
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
                $jsonData = array();  
                $form->handleRequest($request);
               
                $file = $_FILES["image"]["name"];
                $name = $_POST['name'];
                $sname = $_POST['sname'];
                //$file = $_POST['file'];
                
                //$file = $form->get('file')->getData();  
                //$fileName = $file->getClientOriginalName(); 
                $user->setFile("cos");
                $user->setName($name);
                $user->setSname($sname);

                // $file->move(
                //             $this->getParameter('brochures_directory'), ///////////////////
                //         $fileName
                //         );
               
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return new JsonResponse(array('odp' => $name));
            }
            else{  
            return $this->render('control1/index.html.twig', array(
                'form' => $form->createView()
            ));
            }
        }

         // $form->handleRequest($request);
        // if ($form->isSubmitted()){
            
        //     $file = $form->get('file')->getData();               

        //     $fileName = $file->getClientOriginalName();

        //     $file->move(
        //         $this->getParameter('brochures_directory'), ///////////////////
        //         $fileName
        //     );
        //     $user->setFile($fileName);

        //     $loc = $this->getParameter('brochures_directory').'/'.$user->getFile();

        //     // $entityManager = $this->getDoctrine()->getManager();
        //     // $entityManager->persist($user);
        //     // $entityManager->flush();
        //     return new JsonResponse(array('name' => $name));
        // }



        /**
        * @Route("/data/ajax")
        * 
        */    
       

        public function ajaxAction(Request $request) {  
            $students = $this->getDoctrine() 
               ->getRepository(users::class) 
               ->findAll();  
               
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
               $jsonData = array();  
               $idx = 0;  
               foreach($students as $student) {  
                  $temp = array(
                     'name' => $student->getName(),  
                     'address' => $student->getSname(),  
                  );   
                  $jsonData[$idx++] = $temp;  
               } 
               return new JsonResponse($jsonData); 
            } else { 
               return $this->render('/data/ajax.html.twig'); 
            } 
         }    
    

 

    
  

    
    /**
     * @Route("/list", name="list")
     */
    public function show()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        
        $users = $this->getDoctrine()
        ->getRepository(Users::class)
        ->findAll();

        // if (!$user) {
        //     throw $this->createNotFoundException(
        //     'No user found for id '.$id
        //     );
        // }

        return $this->render('data/show.html.twig', array('users' => $users));

    // or render a template
    // in the template, print things with {{ product.name }}
    // return $this->render('product/show.html.twig', ['product' => $product]);

        
    }


    /**
     * @Route("/data")
     */
    public function test()
    {
            
    

        return $this->render('data/index.html.twig');
    }

}
