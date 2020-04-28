<?php

namespace App\Controller;


use App\Entity\Locataires;
use App\Entity\HistoriqueLocations;
use App\Form\HistoriqueLocationsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HistoriqueLocationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/historique/locations")
 */
class HistoriqueLocationsController extends AbstractController
{
    /**
     * @Route("/", name="historique_locations_index", methods={"GET"})
     */
    public function index(HistoriqueLocationsRepository $historiqueLocationsRepository): Response
    {
        return $this->render('historique_locations/index.html.twig', [
            'historique_locations' => $historiqueLocationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="add_location", methods={"GET","POST"})
     */
    public function new(Request $request,Locataires $locataires): Response
    {
        $historiqueLocation = new HistoriqueLocations();
        $form = $this->createForm(HistoriqueLocationsType::class, $historiqueLocation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $historiqueLocation->setLocataires($locataires);
            $entityManager->persist($historiqueLocation);
            $entityManager->flush();

            return $this->redirectToRoute('locataires_show', ['id'=>$locataires->getId()]);
        }

        return $this->render('historique_locations/new.html.twig', [
            'locataires' => $locataires,
            'historique_location' => $historiqueLocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="historique_locations_show", methods={"GET"})
     */
    public function show(HistoriqueLocations $historiqueLocation): Response
    {
        return $this->render('historique_locations/show.html.twig', [
            'historique_location' => $historiqueLocation,
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="historique_locations_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, HistoriqueLocations $historiqueLocation): Response
    // {
    //     $form = $this->createForm(HistoriqueLocationsType::class, $historiqueLocation);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('historique_locations_index');
    //     }

    //     return $this->render('historique_locations/edit.html.twig', [
    //         'historique_location' => $historiqueLocation,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="historique_locations_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, HistoriqueLocations $historiqueLocation): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$historiqueLocation->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($historiqueLocation);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('historique_locations_index');
    // }
}