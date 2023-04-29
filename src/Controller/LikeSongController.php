<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/likeSong')]
class LikeSongController extends AbstractController
{
    #[Route('', name: 'app_like_song')]
    public function index(): Response
    {

        return $this->render('like_song/index.html.twig', [
            "result_like" => $this->getUser()->getLikeMusics(),
            "name" => $this->getUser()->getName()
        ]);
    }
}
