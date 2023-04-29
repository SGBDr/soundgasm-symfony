<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Util\ArtistUtil;
use App\Entity\User;
use App\Entity\Artist;

#[Route('artist')]
class ArtistController extends AbstractController
{
    #[Route('/{id}', name: 'app_artist', requirements: ['id' => '\d+'])]
    public function home(Request $request, EntityManagerInterface $entityManager, Artist $artist): Response
    {
        $like = 0;
        $isPref = false;
        if($artist != null){
            foreach ($artist->getMusics() as $key => $musics) 
                $like += count($musics->getUsers());
            foreach($this->getUSer()->getArtists() as $key => $ar){
                if($ar->getId() == $artist->getId()){
                    $isPref = true;
                    break;
                }
            }
        }

        return $this->render('artist/index.html.twig', [
            "artist" => $artist,
            "like" => $like,
            "isPref" => $isPref,
            "name" => $this->getUser()->getName()
        ]);
    }

    #[Route('/{id}/{action}', name: 'app_artist_action', requirements: ['id' => '\d+', 'action' => 'add|remove'])]
    public function action($action, Request $request, EntityManagerInterface $entityManager, Artist $artist): Response
    {
        $like = 0;
        $isPref = false;
        if($artist != null){
            foreach ($artist->getMusics() as $key => $musics) 
                $like += count($musics->getUsers());
            $user = $this->getUser();
            if($action == "remove"){
                $user->removeArtist($artist);
                $entityManager->persist($user);
                $entityManager->flush();
                $isPref = false;
            }else if($action == "add"){
                $user->addArtist($artist);                        
                $entityManager->persist($user);
                $entityManager->flush();
                $isPref = true;
            }
        }

        return $this->render('artist/index.html.twig', [
            "artist" => $artist,
            "like" => $like,
            "isPref" => $isPref,
            "name" => $this->getUser()->getName()
        ]);
    }
}
