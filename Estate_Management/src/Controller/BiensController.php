<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\Images;
use App\Form\BiensType;
use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Component\Mime\Email;
use App\Entity\HistoriqueLocations;
use App\Repository\BiensRepository;
use Symfony\Component\Mime\Address;
use App\Repository\ImagesRepository;
use App\Repository\AdressesRepository;
use App\Repository\LocatairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/biens", name="biens_")
 */
class BiensController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(BiensRepository $biensRepository, AdressesRepository $adressesRepository): Response
    {
        return $this->render('biens/index.html.twig', [
            'biens'    => $biensRepository->findAll(),
            'adresses' => $adressesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer, LocatairesRepository $LocatairesRepository): Response
    {
        $bien = new Biens();
        $form = $this->createForm(BiensType::class, $bien);
        $form->remove('images');
        $form->handleRequest($request);
        
        $mails = $LocatairesRepository->foundEmail();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();

            foreach ($mails as $key => $val) {
                foreach ($val as $valu) {
                    $email = (new Email())
                    ->from(new Address('shinzoku62800@gmail.com', 'Estate Management'))
                    ->to($valu)
                    ->subject('Nouveauté sur Estate Management')
                    ->text('Il y a une nouvelle habitation qui a été ajouté. Venez vite voir!!!');
                
                    $mailer->send($email);
                }
            }
            return $this->redirectToRoute('biens_index');
        }

        return $this->render('biens/new.html.twig', [
            'bien' => $bien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_admin", methods={"GET"})
     */
    public function show(LocatairesRepository $locatairesRepository, Biens $biens, ImagesRepository $imagesRepository): Response
    {
        $bienId = $biens->getId(); //for the view
        $entityManager = $this->getDoctrine()->getManager();
        $locataires = $entityManager->getRepository(HistoriqueLocations::class)
            ->findBy(['biens' => $bienId]);
        
        return $this->render('biens/show.html.twig', [
            'locatairesRepository' => $locatairesRepository->findAll(),
            'locataires'           => $locataires,
            'images'               => $imagesRepository->findBy(['biens' => $bienId]),
            'biens'                => $biens,
        ]);
    }

    /**
     * @Route("/public/{id}", name="show_public", methods={"GET"})
     */
    public function showPublic(Request $request, LocatairesRepository $locatairesRepository, Biens $biens, ImagesRepository $imagesRepository): Response
    {
        $bienId = $biens->getId(); //for the view
        $entityManager = $this->getDoctrine()->getManager()->getRepository(HistoriqueLocations::class);
        $locataires = $entityManager->findBy(['biens' => $bienId]);

        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message->setBiens($biens);
            $entityManager->persist($message);
            $entityManager->flush();
        }

        return $this->render('biens/showPublic.html.twig', [
            'locatairesRepository' => $locatairesRepository->findAll(),
            'images'               => $imagesRepository->findBy(['biens' => null]),
            'imagesbien'           => $imagesRepository->findBy(['biens' => $bienId]),
            'locataires'           => $locataires,
            'form'                 => $form->createView(),
            'biens'                => $biens,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Biens $bien, MailerInterface $mailer, LocatairesRepository $LocatairesRepository): Response
    {
        $form = $this->createForm(BiensType::class, $bien);
        $form->remove('images')
            ->handleRequest($request);

        $mails = $LocatairesRepository->foundEmail();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager()->flush();
            
            $statut = $bien->getStatuts();
            
            if ($statut == 0) {
                foreach ($mails as $key => $val) {
                    foreach ($val as $valu) {
                        $email = (new Email())
                        ->from(new Address('shinzoku62800@gmail.com', 'Estate Management'))
                        ->to($valu)
                        ->subject('Information sur Estate Management')
                        ->text('Il y a une habitation qui est à nouveau disponible. Venez vite voir!!!');
                    
                        $mailer->send($email);
                    }
                }
            }
            
            return $this->redirectToRoute('biens_index');
        }

        return $this->render('biens/edit.html.twig', [
            'bien' => $bien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
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

    /**
     * @Route("/{id}/new/images", name="images_new", methods={"GET","POST"})
     */
    public function addNewImages(Request $request, Biens $biens): Response
    {
        $form = $this->createForm(BiensType::class, $biens);
        $form->remove('noms')
            ->remove('descriptions')
            ->remove('nbr_pieces')
            ->remove('nbr_chambres')
            ->remove('surfaces')
            ->remove('loyers')
            ->remove('statuts')
            ->remove('Adresses')
            ->remove('ajouter')
            ->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData(); // On récupère les images transmises
            
            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setNoms($fichier);
                $biens->addImage($img);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($biens);
            $entityManager->flush();
            
            return $this->redirectToRoute('biens_show_admin', ['id' => $biens->getId()]);
        }

        return $this->render('images/addimagesBien.html.twig', [
            'biens' => $biens,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprime/image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request): Response
    {
        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            // On récupère le nom de l'image
            $nom = $image->getNoms();
            // On supprime le fichier
            unlink($this->getParameter('upload_directory').'/'.$nom);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('biens_edit', ['id' => $image->getBiens()->getId()]);
    }
}
