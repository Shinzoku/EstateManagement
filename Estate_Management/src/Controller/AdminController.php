<?php

namespace App\Controller;

use App\Repository\LocatairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/accueil/admin", name="accueil")
     */
    public function index(LocatairesRepository $locatairesRepository): Response
    {
        $locatairesData = $locatairesRepository->LocatairesDataChart();
        //dd($locatairesData);
        return $this->render('admin/index.html.twig', [
            'locatairesData' => $locatairesData,
        ]);
    }
}
