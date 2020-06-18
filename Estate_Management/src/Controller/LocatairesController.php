<?php

namespace App\Controller;

use App\Entity\Locataires;
use App\Form\LocatairesType;
use App\Entity\HistoriqueLocations;
use App\Repository\BiensRepository;
use App\Repository\LocatairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/locataires", name="locataires_")
 */
class LocatairesController extends AbstractController
{
    /**
     * @Route("/liste", name="index", methods={"GET"})
     */
    public function index(LocatairesRepository $locatairesRepository): Response
    {
        return $this->render('locataires/index.html.twig', [
            'locataires' => $locatairesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $locataire = new Locataires();
        $form = $this->createForm(LocatairesType::class, $locataire);
        $form->remove('newsletter')
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (isset($_POST['password'])) {
                $hash = $encoder->encodePassword($locataire, $locataire->getPassword());
                $locataire->setPassword($hash);
            }
            $entityManager->persist($locataire);
            $entityManager->flush();
            $this->addFlash('success', 'Ajout d\'un nouveau locataire avec succès.');
            return $this->redirectToRoute('locataires_index');
        }

        return $this->render('locataires/new.html.twig', [
            'locataire' => $locataire,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Locataires $locataire, BiensRepository $biensRepository): Response
    {
        $locataireId = $locataire->getId(); //for the view
        $entityManager = $this->getDoctrine()->getManager();
        $biens = $entityManager->getRepository(HistoriqueLocations::class)
            ->findBy(['locataires' => $locataireId]);
        
        return $this->render('locataires/show.html.twig', [
            'biensRepository' => $biensRepository->findAll(),
            'locataire'       => $locataire,
            'biens'           => $biens,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Locataires $locataire, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(LocatairesType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            if (isset($_POST['password'])) {
                $hash = $encoder->encodePassword($locataire, $locataire->getPassword());
                $locataire->setPassword($hash);
            }

            $entityManager->persist($locataire);
            $entityManager->flush();
            $this->addFlash('success', 'Modification du locataire effectué avec succès.');
            return $this->redirectToRoute('locataires_index');
        }

        return $this->render('locataires/edit.html.twig', [
            'locataire' => $locataire,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
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
}
