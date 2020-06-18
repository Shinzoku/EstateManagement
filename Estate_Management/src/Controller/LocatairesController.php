<?php

namespace App\Controller;

use App\Entity\Locataires;
use App\Entity\HistoriqueLocations;
use App\Form\LocatairesType;
use App\Repository\BiensRepository;
use App\Repository\LocatairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        //créer un formulaire en utilisant le form RegistrationType avec l'objet Locataires
        $form = $this->createForm(LocatairesType::class, $locataire);
        //retire le champ 'newsletter' car pas nessessaire dans le cas présent
        $form->remove('newsletter')
            //annalyse des champs avec handleRequest
            ->handleRequest($request);

        /*l'enregistrement dans la base de donnée */
        //si le formulaire est submit ET valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (isset($_POST['password'])) {
                // encode le mot de passe de l'objet locataires et lit la colonne password
                $hash = $encoder->encodePassword($locataire, $locataire->getPassword());
                //change la valeur dans colonne password
                $locataire->setPassword($hash);
            }
            //le faire persister dans le temps, c'est une prépation pour la requête SQl
            $entityManager->persist($locataire);
            //enregistrement véritable de la requete SQl. On met les données dans la table
            $entityManager->flush();
            $this->addFlash('success', 'Ajout d\'un nouveau locataire avec succÃ¨s.');
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
            $this->addFlash('success', 'Modification du locataire effectuÃ© avec succÃ¨s.');
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
