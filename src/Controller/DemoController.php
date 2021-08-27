<?php

namespace App\Controller;

use App\Entity\Demo;
use App\Form\DemoType;
use App\Repository\DemoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/demo")
 */
class DemoController extends AbstractController
{
    /**
     * @Route("/", name="demo_index", methods={"GET"})
     */
    public function index(DemoRepository $demoRepository): Response
    {
        return $this->render('admin/demo/index.html.twig', [
            'demos' => $demoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="demo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $demo = new Demo();
        $form = $this->createForm(DemoType::class, $demo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demo);
            $entityManager->flush();
            $this->addFlash('success','demo created');
            return $this->redirectToRoute('demo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/demo/new.html.twig', [
            'demo' => $demo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="demo_show", methods={"GET"})
     */
    public function show(Demo $demo): Response
    {
        return $this->render('admin/demo/show.html.twig', [
            'demo' => $demo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Demo $demo): Response
    {
        $form = $this->createForm(DemoType::class, $demo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Demo modify');
            return $this->redirectToRoute('demo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/demo/edit.html.twig', [
            'demo' => $demo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="demo_delete", methods={"POST"})
     */
    public function delete(Request $request, Demo $demo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demo_index', [], Response::HTTP_SEE_OTHER);
    }
}
