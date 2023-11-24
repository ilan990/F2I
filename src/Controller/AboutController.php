<?php

// src/Controller/AboutController.php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

class AboutController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the getDoctrine method exists (added for compatibility)
                
            $entityManager = $this->doctrine->getManagerForClass(Contact::class);
            
            // Persiste l'objet Contact dans l'EntityManager
            $entityManager->persist($contact);
            
            // Effectue un flush pour sauvegarder les changements dans la base de données
            $entityManager->flush();

            return $this->redirectToRoute('homepage.index');
        }

        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
            'form' => $form->createView(),
        ]);
    }
}
