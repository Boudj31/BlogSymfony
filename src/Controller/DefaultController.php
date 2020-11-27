<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Service\MessageGenerator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{

     /**
     * @Route("/", name="default", methods={"GET"})
     */
    public function index(ArticleRepository $article, MessageGenerator $generator): Response
    {
        $date = new DateTime();
        return $this->render('default/index.html.twig', [
            'message' => $generator->getMessage(),
            'day_date' => $date,
            'article' => $article->lastArticle()
        ]);
    }

    /**
     * @Route("/profile/{id}/password", name="edit_password", methods={"GET","POST","PUT"})
     */
    public function editPassword(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder): Response
    {

        $form = $this->createForm(ChangePasswordType::class, $user,[
            'method' => 'put'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
  
            $old_pwd = $form->get('old_password')->getData();

             if($encoder->isPasswordValid($user, $old_pwd)) {
             
                 $new_pwd = $form->get('new_password')->getData();
                 $password = $encoder->encodePassword($user, $new_pwd);

                 $user->setPassword($password);

                 $entityManager->flush();
                 $this->addFlash('success','Mise à jour du mot de passe effectué');

                 return $this->redirectToRoute('profile', [
                     'id' => $user->getId()
                 ]);
              }
            }


        return $this->render('default/password.html.twig', [
            'form_pass' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{id}/edit", name="edit_profile", methods={"GET","POST","PUT"})
     */
    public function editProfile(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(UserType::class, $user,[
            'method' => 'put'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

                 $entityManager->flush();
                 $this->addFlash('success','Mise à jour effectué');

                 return $this->redirectToRoute('profile', [
                     'id' => $user->getId()
                 ]);
              }

        return $this->render('default/edit.html.twig', [
            'form_edit' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{id}", name="profile"), methods={"GET"})
     */
    public function profile(User $user): Response
       {
        return $this->render('default/profil.html.twig', [
            'profile' => $user
        ]);
       }

    
}
