<?php

namespace App\Controller;

use App\Entity\Locataires;
use App\Entity\PropertySearch;
use App\Form\LocatairesType;
use App\Form\PropertySearchType;
use App\Repository\BiensRepository;
use App\Repository\ImagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicController extends AbstractController
{
    /**
     * @route("/accueil"), name="accueil_public", methods={"GET","POST"})
     */
    public function index(Request $request, PaginatorInterface $paginator, BiensRepository $repository, ImagesRepository $imagesRepository): Response
    {
        $search = new PropertySearch();
        $form   = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $biens = $paginator->paginate(
            $repository->findAllVisibleQuery($search), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        $biens->setCustomParameters([
            'align'      => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size'       => '', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style'      => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('public/index.html.twig', [
            'images' => $imagesRepository->findBy(['biens' => null]),
            'biens'  => $biens,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/accueil/public/ajax", name="accueil_public_ajax")
     */
    public function getBiensByFiltre(Request $request, PaginatorInterface $paginator, BiensRepository $repository)
    {
        if ($request->isXmlHttpRequest()) {
            $search = new PropertySearch();
            
            $surfaceMin = $request->request->get('minSurface');
            $priceMax = $request->request->get('maxPrice');
            $search ->setMinSurface($surfaceMin)
                    ->setMaxPrice($priceMax);
            $biens = $paginator->paginate(
                $repository->findAllVisibleQuery($search), // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );
            
            $biens->setCustomParameters([
                'align'      => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
                'size'       => '', # small|large (for template: twitter_bootstrap_v4_pagination)
                'style'      => 'bottom',
                'span_class' => 'whatever',
            ]);
            
            return $this->render('public/_content.html.twig', [
                'biens' => $biens,
            ]);
        }
    }

    /**
     * @Route("accueil/public/newsletter/inscription", name="newsletter_new", methods={"GET","POST"})
     */
    public function new(Request $request, ImagesRepository $imagesRepository): Response
    {
        $locataire = new Locataires();
        $form = $this->createForm(LocatairesType::class, $locataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($locataire);
            $entityManager->flush();

            return $this->redirectToRoute('accueil_public');
        }

        return $this->render('public/newsletter.html.twig', [
            'images' => $imagesRepository->findBy(['biens' => null]),
            'form'   => $form->createView(),
        ]);
    }
}
