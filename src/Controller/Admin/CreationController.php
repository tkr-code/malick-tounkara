<?php

namespace App\Controller\Admin;

use App\Entity\Creation;
use App\Form\CreationType;
use App\Repository\CreationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/creation")
 */
class CreationController extends AbstractController
{
    /**
     * @Route("/", name="creation_index", methods={"GET"})
     */
    public function index(CreationRepository $creationRepository): Response
    {
        return $this->render('admin/creation/index.html.twig', [
            'creations' => $creationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="creation_new", methods={"GET","POST"})
     * @Route("/{id}/edit", name="creation_edit", methods={"GET","POST"})
     */
    public function new(Creation $creation = null,Request $request): Response
    {
        if($creation == null){
            $creation = new Creation();
        }
        $form = $this->createForm(CreationType::class, $creation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $image = $form->get('image')->getData();
            if ($image) {
                $fichier = md5(uniqid()). '.'.$image->guessExtension();
                $image->move(
                $this->getParameter('creation_images_directory'),
                $fichier
                );
                $creation->setImage($fichier);
            }

            $entityManager->persist($creation);
            $entityManager->flush();

            return $this->redirectToRoute('creation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/creation/new.html.twig', [
            'creation' => $creation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="creation_show", methods={"GET"})
     */
    public function show(Creation $creation): Response
    {
        return $this->render('admin/creation/show.html.twig', [
            'creation' => $creation,
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="creation_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Creation $creation): Response
    // {
    //     $form = $this->createForm(CreationType::class, $creation);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('creation_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('admin/creation/edit.html.twig', [
    //         'creation' => $creation,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="creation_delete", methods={"POST"})
     */
    public function delete(Request $request, Creation $creation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($creation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('creation_index', [], Response::HTTP_SEE_OTHER);
    }
}
