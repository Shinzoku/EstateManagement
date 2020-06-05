<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/messages", name="messages_")
 */
class MessagesController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('messages/index.html.twig', [
            'messages' => $messagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, Biens $biens): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message->setBiens($biens);
            $entityManager->persist($message);
            $entityManager->flush();
            
            return $this->redirectToRoute('biens_show_public', ['id' => $biens->getid()]);
        }

        return $this->render('messages/_form.html.twig', [
            'biens' => $biens,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Messages $message): Response
    {
        $bienId = $message->getbiens();
        
        return $this->render('messages/show.html.twig', [
            'bien'    => $bienId,
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Messages $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('messages_index');
    }
}
