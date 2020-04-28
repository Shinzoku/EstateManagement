<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Form\BiensType;
use App\Entity\Locataires;
use App\Entity\HistoriqueLocations;
use App\Repository\BiensRepository;
use App\Repository\AdressesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/biens")
 */
class BiensController extends AbstractController
{
    /**
     * @Route("/", name="biens_index", methods={"GET"})
     */
    public function index(BiensRepository $biensRepository, AdressesRepository $adressesRepository): Response
    {
        return $this->render('biens/index.html.twig', [
            'biens' => $biensRepository->findAll(),
            'adresses' => $adressesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="biens_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bien = new Biens();
        $form = $this->createForm(BiensType::class, $bien);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();            
            $entityManager->persist($bien);
            $entityManager->flush();

            return $this->redirectToRoute('biens_index');
        }

        return $this->render('biens/new.html.twig', [
            'bien' => $bien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="biens_show", methods={"GET"})
     */
    public function show(Locataires $locataires, Biens $biens): Response
    {
        $bienId = $biens->getId(); //for the view
        $entityManager = $this->getDoctrine()->getManager();
        $locataires = $entityManager->getRepository(HistoriqueLocations::class)
            ->findBy(['biens' => $bienId]);

        return $this->render('biens/show.html.twig', [
            'locataires' => $locataires,
            'biens' => $biens,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="biens_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Biens $bien): Response
    {
        $form = $this->createForm(BiensType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('biens_index');
        }

        return $this->render('biens/edit.html.twig', [
            'bien' => $bien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="biens_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Biens $bien): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('biens_index');
    }
}
