<?php   
    namespace App\Util;

    use Doctrine\ORM\EntityManagerInterface;
    use App\Entity\Artist;
    use \DateTimeInterface;
    use Symfony\Contracts\HttpClient\HttpClientInterface;

    class ArtistUtil{
        private $entityManager;
        private $client;

        public function __construct(EntityManagerInterface $entityManager){
            $this->entityManager = $entityManager;
        }

        public function getAll(){
            return $this->entityManager->getRepository(Artist::class)->findAll();
        }

        public function getById(int $artist_id){
            $artist = $this->entityManager->getRepository(Artist::class)->findById(intval($artist_id));
            return count($artist) == 0 ? null : $artist[0];
        }

    }
