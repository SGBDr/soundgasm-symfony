<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Util\MusicUtil;

#[Route('/reader')]
class ReaderController extends AbstractController
{
    #[Route('', name: 'app_reader')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $id = $request->query->get("id") . "";
        $music = null;
        $musics = array();
        $isLike = false;

        if($id != ""){
            $m = new MusicUtil($entityManager);
            $music = $m->getById(intval($id));
            
            if($music != null){
                $musics = $music->getArtist()->getMusics();

                $action = $request->query->get("action");
                $user = $this->getUser();

                foreach($user->getLikeMusics() as $m){
                    if($m->getId() == $music->getId()){
                        $isLike = true;
                        break;
                    }
                }

                if($action == "like"){
                    $user->addLikeMusic($music);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $isLike = true;
                }else if($action == "unlike"){
                    $user->removeLikeMusic($music);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $isLike = false;
                }
            }
        }

        return $this->render('reader/index.html.twig', [
            "music" => $music,
            "musics" => $musics,
            "isLike" => $isLike,
            "name" => $this->getUser()->getName()
        ]);
    }
}
