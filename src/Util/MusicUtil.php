<?php   
    namespace App\Util;

    use Doctrine\ORM\EntityManagerInterface;
    use App\Entity\Music;
    use App\Entity\Artist;
    use \DateTimeInterface;
    use Symfony\Contracts\HttpClient\HttpClientInterface;

    class MusicUtil{
        private $entityManager;
        private $client;

        public function __construct(EntityManagerInterface $entityManager){
            $this->entityManager = $entityManager;
        }

        public function getAll(){
            return $this->entityManager->getRepository(Music::class)->findAll();
        }

        public function getLikeSong(int $user_id){
            $list = array();
            foreach($this->musicRepo->findLikeSongOfUser($user_id) as $key => $value)
                array_push($list, $value->json());
            return $list;
        }

        public function LikeSong(int $music_id, int $user_id){
            return 5;
        }

        public function unLikeSong(int $music_id, int $user_id){
            return $this->musicRepo->unLikeSong($music_id, $user_id);
        }

        public function getById(int $music_id){
            $music = $this->entityManager->getRepository(Music::class)->findById($music_id);
            return count($music) == 0 ? null : $music[0];
        }

        public function feedDataBase(string $chr): void{
            $url = "https://itunes.apple.com/search?limit=100&term=" . str_replace(' ', '%20', $chr);
            $raw = file_get_contents($url);
            $json = json_decode($raw);
            foreach ($json->results as $key => $music) {
                if($music->wrapperType == "track"){
                    if($music->kind == "song" && isset($music->previewUrl)){
                        $entityA = $this->entityManager->getRepository(Artist::class);
                        if(count($entityA->CreateQueryBuilder("a")
                                        ->andWhere("a.name=:name AND a.artist_id=:artist_id")
                                        ->setParameter('name', strtolower($music->artistName))
                                        ->setParameter('artist_id', $music->artistId)
                                        ->getQuery()->getResult()) == 0){
                            $ar = new Artist();
                            $ar->setName(strtolower($music->artistName))
                                ->setArtistId($music->artistId);
                            $this->entityManager->persist($ar);
                            $this->entityManager->flush();
                        }
                        $entityM = $this->entityManager->getRepository(Music::class);
                        if(count($entityM->CreateQueryBuilder("m")
                                ->andWhere("m.music_id=:music_id")
                                ->setParameter('music_id', $music->trackId)
                                ->getQuery()->getResult()) == 0){
                            $m = new Music();

                            $ar = $entityA->CreateQueryBuilder("a")
                            ->andWhere("a.artist_id=:artist_id")
                            ->setParameter('artist_id', $music->artistId)
                            ->getQuery()
                            ->getResult()[0];

                            $m->setMusicId($music->trackId)
                                ->setName(strtolower($music->trackName))
                                ->setRepImage($music->artworkUrl100)
                                ->setTrack($music->previewUrl)
                                ->setArtist($ar)
                                ->setCountry($music->country)
                                ->setStyle($music->primaryGenreName)
                                ->setReleaseDate(new \DateTime($music->releaseDate));
                            $this->entityManager->persist($m);
                            $this->entityManager->flush();
                        }
                           
                    }
                }
            }
        }

        public function findByNameOrArtist(string $chr){
            $entity = $this->entityManager->getRepository(Music::class);
            $list = array();
            foreach($entity->findAll() as $key => $value)
                if(str_contains($value->getName(), $chr) || str_contains($value->getArtist()->getName(), $chr))
                    array_push($list, $value);
            if(count($list) <= 15)
                $this->feedDataBase($chr);
            return $list;
        }



    }
