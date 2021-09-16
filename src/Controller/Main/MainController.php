<?php

namespace App\Controller\Main;

use App\Repository\CreationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(CreationRepository $creationRepository): Response
    {

              $projets =
      [
        [
          'nom' => 'Gaboma annonce',
          'client' => 'Malick Tounkara',
          'categorie' => 'Annonce',
          'date' => ' Février 2020 ',
          'title' => 'Site de petites annonces au Sénégal',
          'desc' => 'Gaboma Annonce est un site de petite annonce dédié à la Diaspora gabonaise du Sénégal ayant pour but de faciliter les échanges entre compatriotes.',
          'img' => 'gaboma-annonce-logo.png',
          'link' => 'https://gaboma-annonce.com',
          'color' => '#000033',
        ],
        [
          'nom' => 'Elec-com',
          'client' => 'Edwin Pambo',
          'categorie' => 'Commerce Electronique',
          'date' => 'Novembre 2020',
          'title' => 'Vente de produit électronique',
          'desc' => "ELEC-com est une plateforme de vente en ligne qui offre une facon simple, amusante et pratique de se retrouver dans l'univers des gadgets électronique et d'acheter en toute liberté les meilleurs produits.",
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
          'desc' => "ARITnet consulting propose des services informatiques qui permettent aux entreprises d'améliorer leur efficacité et leurs rentabilités.",
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
          'desc' => "Il vous est permis à travers ce site de bénéficier d'une panoplie d'information concernant l'adhésion à l'école mais également à l'amicale partant notamment de la liste des programmes qu'offre l'école aux événements futurs de l'amicale.",
          'img' => 'aeg-ipg-isti.jpeg',
          'link' => 'https://aeg-ipg-isti.com',
          'color' => '#fff',
        ],
      ];
        return $this->render('main/base.html.twig', [
            'projets'=>$creationRepository->findAll()
        ]);
    }
}