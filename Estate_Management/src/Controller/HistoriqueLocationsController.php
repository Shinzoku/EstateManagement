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
 * @Route("/historique/locations", name="historique_locations_")
 */
class HistoriqueLocationsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
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
    public function new(Request $request, Locataires $locataires): Response
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
            'locataires'          => $locataires,
            'historique_location' => $historiqueLocation,
            'form'                => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(HistoriqueLocations $historiqueLocation): Response
    {
        return $this->render('historique_locations/show.html.twig', [
            'historique_location' => $historiqueLocation,
        ]);
    }
}
