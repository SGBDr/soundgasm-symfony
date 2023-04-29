<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('home')]
class HomeController extends AbstractController
{
    private $pager;

    #[Route('', name: 'app_home_zero')]
    public function indexx(Request $request): Response
    {
        $result_pref = array();

        foreach($this->getUser()->getArtists() as $art)
            foreach($art->getMusics() as $mu)
                array_push($result_pref, $mu);

        $pages = count($result_pref) / 5;
        if(intval($pages) != $pages) $pages = intval($pages) + 1;

        $page = 1;

        $page_songs = array_slice($result_pref, ($page-1)*5, 5);
        
            
        return $this->render('home/index.html.twig', [
            'name' => $this->getUser()->getName(),
            'page' => $page,
            'pages' => $pages,
            'page_songs' => $page_songs,
        ]);
    }

    #[Route('/{page}', name: 'app_home', requirements: ['page' => '\d+'])]
    public function index($page, Request $request): Response
    {
        $result_pref = array();

        foreach($this->getUser()->getArtists() as $art)
            foreach($art->getMusics() as $mu)
                array_push($result_pref, $mu);

        $pages = count($result_pref) / 5;
        if(intval($pages) != $pages) $pages = intval($pages) + 1;

        if(!is_numeric($page))
            $page = 1;
        if($page <= 0) $page = 1;
        else if($page > $pages) $page = $pages;

        
        $page_songs = array_slice($result_pref, ($page-1)*5, 5);
        
            
        return $this->render('home/index.html.twig', [
            'name' => $this->getUser()->getName(),
            'page' => $page,
            'pages' => $pages,
            'page_songs' => $page_songs,
        ]);
    }

    #[Route('/{page}/{action}', name: 'app_home_action', requirements: ['id' => '\d+', 'action' => 'previous|next'])]
    public function action($page, $action, Request $request): Response
    {
        $result_pref = array();

        foreach($this->getUser()->getArtists() as $art)
            foreach($art->getMusics() as $mu)
                array_push($result_pref, $mu);

        $pages = count($result_pref) / 5;
        if(intval($pages) != $pages) $pages = intval($pages) + 1;

        if(!is_numeric($page))
            $page = 1;
        if($action == "next")$page += 1;
        else if($action == "previous")$page -= 1;
        if($page <= 0) $page = 1;
        else if($page > $pages) $page = $pages;

        
        $page_songs = array_slice($result_pref, ($page-1)*5, 5);
        
            
        return $this->render('home/index.html.twig', [
            'name' => $this->getUser()->getName(),
            'page' => $page,
            'pages' => $pages,
            'page_songs' => $page_songs,
        ]);
    }
}
