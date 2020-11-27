<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact();
        $notifications = null;
    
           $form = $this->createForm(ContactType::class, $contact);


           $form->handleRequest($request);

           if($form->isSubmitted() && $form->isValid()) {
  
               $user = $form->getData();
               $this->entityManager->persist($contact);
               $this->entityManager->flush();

              $this->addFlash('success', 'Votre message à bien été envoyer ');
             //  return $this->redirectToRoute('merci');

           }
   
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET", "PUT"})
     */
    public function edit(Contact $contact, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact, [
            'methods' => 'put'
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'le contact à bien été modifier');

            return $this->redirectToRoute('contact');

        }

        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
