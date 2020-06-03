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
 * @Route("/messages")
 */
class MessagesController extends AbstractController
{
    /**
     * @Route("/", name="messages_index", methods={"GET"})
     */
    public function index(MessagesRepository $messagesRepository): Response
    {
        return $this->render('messages/index.html.twig', [
            'messages' => $messagesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="messages_new", methods={"GET","POST"})
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
            $this->addFlash('success', 'Votre message a été envoyé.');
            return $this->redirectToRoute('biens_show_public', ['id' => $biens->getid()]);
        }

        return $this->render('messages/_form.html.twig', [
            'biens' => $biens,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="messages_show", methods={"GET"})
     */
    public function show(Messages $message): Response
    {
        
        $bienId = $message->getbiens();
        
        return $this->render('messages/show.html.twig', [
            'bien' => $bienId,
            'message' => $message,
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="messages_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Messages $message): Response
    // {
    //     $form = $this->createForm(MessagesType::class, $message);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('messages_index');
    //     }

    //     return $this->render('messages/edit.html.twig', [
    //         'message' => $message,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="messages_delete", methods={"DELETE"})
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
