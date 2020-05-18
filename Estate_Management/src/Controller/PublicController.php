<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\BiensRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page


class PublicController extends AbstractController
{

    /**
     * @Route("/accueil/Public", name="accueil_public")
     */
    public function index(Request $request, PaginatorInterface $paginator, BiensRepository $repository): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        
        $biens = $paginator->paginate(
            $repository->findAllVisibleQuery($search), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
    
        return $this->render('public/index.html.twig', [
            'biens' => $biens,
            'form'  => $form->createView(),
        ]);
    }
}
