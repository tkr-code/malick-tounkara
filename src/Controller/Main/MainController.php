<?php

namespace App\Controller\Main;

use App\Form\ContactType;
use App\Repository\CreationRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
        
    /**
     * cv
     * @Route("/cv", name="cv")
     * @return void
     */
    public function cv(): Response
    {
      return $this->render('cv/index.html.twig');
    }
      /**
     * @Route("/change-lang/{locale}", name="lang")
     */
    public function changeLocale($locale, Request $request)
    {
    
        $locale = $request->attributes->get('locale');
        
        $request->getSession()->set('_locale', $locale);
        
        $request->setLocale($request->getSession()->get('_locale', $locale));    
        
        return $this->redirect($request->headers->get('referer'));
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, CreationRepository $creationRepository, MailerInterface $mailerInterface): Response
    {
      // contact form
      $formContact = $this->createForm(ContactType::class);
      $contact = $formContact->handleRequest($request);

      if($formContact->isSubmitted() && $formContact->isValid()){
        // dd($request);
        $email = (new TemplatedEmail())
        ->from($contact->get('email')->getData())
        ->to('malick.tounkara.1@gmail.com')
        ->subject('Contact depuis le site malick tounkara')
        ->htmlTemplate('email/contact.html.twig')
        ->context([
          'name'=>$contact->get('name')->getData(),
          'mail'=>$contact->get('email')->getData(),
          'phone'=>$contact->get('phone_number')->getData(),
          'message'=>$contact->get('message')->getData(),
        ])
        ;
        $mailerInterface->send($email);
        $this->addFlash('success','Email envoy??');
        return $this->redirectToRoute('home',['/#contact']);
      }

              $projets =
      [
        [
          'nom' => 'Gaboma annonce',
          'client' => 'Malick Tounkara',
          'categorie' => 'Annonce',
          'date' => ' F??vrier 2020 ',
          'title' => 'Site de petites annonces au S??n??gal',
          'desc' => 'Gaboma Annonce est un site de petite annonce d??di?? ?? la Diaspora gabonaise du S??n??gal ayant pour but de faciliter les ??changes entre compatriotes.',
          'img' => 'gaboma-annonce-logo.png',
          'link' => 'https://gaboma-annonce.com',
          'color' => '#000033',
        ],
        [
          'nom' => 'Elec-com',
          'client' => 'Edwin Pambo',
          'categorie' => 'Commerce Electronique',
          'date' => 'Novembre 2020',
          'title' => 'Vente de produit ??lectronique',
          'desc' => "ELEC-com est une plateforme de vente en ligne qui offre une facon simple, amusante et pratique de se retrouver dans l'univers des gadgets ??lectronique et d'acheter en toute libert?? les meilleurs produits.",
          'img' => 'elecom-logo.png',
          'link' => '', // 'https://elec-com.com',
          'color' => '#380F3E',
        ],
        [
          'nom' => 'Aritnet Consulting',
          'client' => 'Justice Dissoulama Grace',
          'categorie' => 'Service informatique',
          'date' => 'Octobre 2020',
          'title' => 'Service informatique',
          'desc' => "ARITnet consulting propose des services informatiques qui permettent aux entreprises d'am??liorer leur efficacit?? et leurs rentabilit??s.",
          'img' => 'aritnet-logo.png',
          'link' => 'https://aritnetconsulting.com',
          'color' => '#fff',
        ],
        [
          'nom' => 'AEG IPG ISTI',
          'client' => 'Prince Mabicka',
          'categorie' => 'Education',
          'date' => '5 mars 2020',
          'title' => 'Eductaion',
          'desc' => "Il vous est permis ?? travers ce site de b??n??ficier d'une panoplie d'information concernant l'adh??sion ?? l'??cole mais ??galement ?? l'amicale partant notamment de la liste des programmes qu'offre l'??cole aux ??v??nements futurs de l'amicale.",
          'img' => 'aeg-ipg-isti.jpeg',
          'link' => 'https://aeg-ipg-isti.com',
          'color' => '#fff',
        ],
      ];
        return $this->renderForm('main/base.html.twig', [
            'projets'=>$creationRepository->findAll(),
            'form_contact'=>$formContact
        ]);
    }
}