<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Util\MusicUtil;

class SearchController extends AbstractController
{

    #[Route('/search', name: 'app_search')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $term = trim(strtolower($request->query->get("term")));
        $result_t = array();
        $result_recent = array();

        if($term != ""){
            $m = new MusicUtil($entityManager);
            $result_t = $m->findByNameOrArtist($term);
        }

        if(count($this->getUser()->getArtists()) != 0)
            $result_recent = $this->getUser()->getArtists()[count($this->getUser()->getArtists()) - 1]->getMusics();


        return $this->render('search/index.html.twig', [
            "term" => $term,
            "result" => $result_t,
            "result_recent" => $result_recent,
            "name" => $this->getUser()->getName()
        ]);
    }
}
