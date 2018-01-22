<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository('AppBundle:Slider')->findBy(
                                                            array('statut'  => 1),
                                                            array('id'  => 'DESC')
                                                        ); 

        $accueil = $em->getRepository('AppBundle:Accueil')->findOneBy(
                                                            array('statut'  => 1),
                                                            array('id'  => 'DESC'),
                                                            $limit = 1,
                                                            $offset = 0
                                                        );
        $actualites = $em->getRepository('AppBundle:Actualite')->findBy(
                                                            array('statut'  => 1),
                                                            array('id'  => 'DESC'),
                                                            $limit = 3,
                                                            $offset = 0
                                                        );//dump($actualites);die();

        return $this->render('default/index.html.twig', [
            'sliders' => $sliders,
            'accueil'   => $accueil,
            'actualites'    => $actualites,
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('default/dashboard.html.twig');
    }

    /**
     * @Route("/partenaire", name="partenaire")
     */
    public function partenaireAction()
    {
        $em =$this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('AppBundle:Partenaire')->findBy(array('statut' => 1));

        return $this->render('default/partenaire.html.twig',[
            'partenaires'    => $partenaires,
        ]);
    }

    /**
     * @Route("/qui-sommes-nous", name="presentation")
     */
    public function presentationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $presentation = $em->getRepository('AppBundle:Presentation')
                            ->findOneBy(
                                array('statut' => 1), 
                                array('id' => 'DESC')
                        );//dump($presentation);die();

        $ariane = 'Qui sommes-nous?';

        return $this->render('default/page.html.twig',[
            'page'  => $presentation,
            'ariane'    => $ariane,
        ]);
    }

    /**
     * @Route("/objectif", name="objectif")
     */
    public function objectifAction()
    {
        $em = $this->getDoctrine()->getManager();
        $objectif = $em->getRepository('AppBundle:Objectif')
                            ->findOneBy(
                                array('statut' => 1), 
                                array('id' => 'DESC')
                        );//dump($presentation);die();

        $ariane = 'Notre objectif';

        return $this->render('default/page.html.twig',[
            'page'  => $objectif,
            'ariane'    => $ariane,
        ]);
    }

    /**
     * @Route("/liste-des-actualites", name="nos_actualites")
     */
    public function actualitesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $actualites = $em->getRepository('AppBundle:Actualite')
                            ->findBy(
                                array('statut'  => 1),
                                array('id'=> 'DESC'),
                                $limit = 3,
                                $offset = 0
                            );//dump($actualites);die();
        
        $ariane = "Nos actualités";

        return $this->render('default/actualite.html.twig',[
            'actualites' => $actualites,
            'ariane'    => $ariane,
        ]);
    }

    /**
     * @Route("/actualite/{slug}", name="actualite_detail")
     */
    public function actualiteDetailAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $actualite = $em->getRepository('AppBundle:Actualite')
                            ->findOneBy(
                                array('slug'    => $slug, 
                                        'statut'  => 1
                                    )
                            );

        $ariane = 'Actualité';

        return $this->render('default/page.html.twig',[
            'page'  => $actualite,
            'ariane'    => $ariane,
        ]);
    }

    /**
     * @Route("/documentation/{slug}", name="documentation")
     */
    public function documentAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository('AppBundle:Documentation')->findDocumentionByDepartementSlug($slug);
                                // dump($documents);die();

        $ariane = "Les documents de ".$slug;

        return $this->render('default/documentation.html.twig',[
            'documents' => $documents,
            'ariane'    => $ariane,
            'departement'   => $slug,
        ]);
    }

    /**
     * @Route("/menu-document", name="menu_documentation")
     */
    public function menuDocumentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('AppBundle:Departement')
                    ->findBy(
                        array('statut' => 1),
                        array('libelle' => 'ASC')
                    );

        return $this->render('default/menuDocumentation.html.twig',[
            'menus' => $menus,
        ]);
    }
}
