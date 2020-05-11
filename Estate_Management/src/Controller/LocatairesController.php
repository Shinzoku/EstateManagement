<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\Locataires;
use App\Form\LocatairesType;
use Symfony\Component\Mime\Email;
use App\Entity\HistoriqueLocations;
use App\Repository\LocatairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/locataires")
 */
class LocatairesController extends AbstractController
{
    /**
     * @Route("/liste", name="locataires_index", methods={"GET"})
     */
    public function index(LocatairesRepository $locatairesRepository): Response
    {
        return $this->render('locataires/index.html.twig', [
            'locataires' => $locatairesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="locataires_new", methods={"GET","POST"})
     */
    public function new(Request $request/*, UserPasswordEncoderInterface $encoder*/): Response
    {
        $locataire = new Locataires();
        $form = $this->createForm(LocatairesType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // $hash = $encoder->encodePassword($locataire, $locataire->getPassword());
            // $locataire->setPassword($hash);
            $entityManager->persist($locataire);
            $entityManager->flush();

            return $this->redirectToRoute('locataires_index');
        }

        return $this->render('locataires/new.html.twig', [
            'locataire' => $locataire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="locataires_show", methods={"GET"})
     */
    public function show(Locataires $locataire, Biens $biens): Response
    {
        $locataireId = $locataire->getId(); //for the view
        $entityManager = $this->getDoctrine()->getManager();
        $biens = $entityManager->getRepository(HistoriqueLocations::class)
            ->findBy(['locataires' => $locataireId]);
        
        return $this->render('locataires/show.html.twig', [
            'locataire' => $locataire,
            'biens' => $biens,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="locataires_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Locataires $locataire): Response
    {
        $form = $this->createForm(LocatairesType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('locataires_index');
        }

        return $this->render('locataires/edit.html.twig', [
            'locataire' => $locataire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="locataires_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Locataires $locataire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$locataire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($locataire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('locataires_index');
    }

    // public function sendEmail(MailerInterface $mailer)
    // {
    //     $email = (new Email())
    //         ->from('shinzoku62800@gmail.com')
    //         ->to('shinzoku62800@gmail.com')
    //         ->subject('Time for Symfony Mailer!')
    //         ->text('Sending emails is fun again!')
    //         ->html('<p>See Twig integration for better HTML integration!</p>');

    //     $mailer->send($email);

    //     // ...
    // }
}
