<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // $user_id = app.user->getId();
        // $user = User::getName() ;

        // return $this->render('category/index.html.twig', [
        
        // ]);

        $repository = $this->getDoctrine()->getRepository(Categorie::class);


        $categorie = $repository->findAll();

        return $this->render('user/index.html.twig', [
            'Categorie'=> $categorie,
            // 'Questions'=> $question,
        ]);
    
    }

    /**
     * @route("/edit/{id}" , name ="user_edit")
     */

    public function edit($id){

        $repository = $this->getDoctrine()->getRepository(User::class);

        $user = $repository->find($id);
    
        return $this->render("user/edit.html.twig",[
        'user'=> $user
        ]);

    }

    /**
     * @route("/update" , name ="user_update" ,methods={"GET", "POST"})
     */

    public function update(Request $request,UserPasswordEncoderInterface $passwordEncoder,MailerInterface $mailer):Response
    {

        $user = $this->security->getUser(); 
        $actualEmail =$user->getEmail();
        $post = $request->request->all();

        $name='';
        $email='';
        $password='';
        $confirm_password='';

        foreach($post as $key => $value){
            switch($key){
                case 'name':
                    $name = $post['name'];
                        break;
                    case 'email':
                    $email = $post['email'];
                        break;
                    case 'password':
                    $password = $post['password'];
                        break;
                    case 'confirm_password':
                    $confirm_password = $post['confirm_password'];
                        break;
            
            }
        
        }

        if (isset($name)) {
            // var_dump($name);
            $user->setName($name);
        }
        
        if (isset($email)) {
            if ($email === $actualEmail) {
                echo"this email already exist";
            }else{
            $user->setEmail($email);
            }
        }

        if (strlen($password) >= 8 && ($password === $confirm_password) ) {
            // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                            $password
                    )
                );

            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);

            $entityManager->flush();


        if (($email)!= '') {

            $email = (new Email())
            ->from('freeadssymfony@gmail.com')
            ->to($email)
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>Thanks for reistering on My_Quiz. Please click on the link to complete your registration
            <a>http://localhost:8000/token_234edqadcfdxaaxkey</a> 
            </p>');

            $mailer->send($email);
        
        } 

        return $this->redirectToRoute('home');
         
    }

}
