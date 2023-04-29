<?php
    namespace App\Entity;
    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;

    /**
    * @ORM\Entity()
    * @ORM\Table(name="playlist")
    * */
    class PlayList{
        /**
        * @ORM\Id()
        * @ORM\GeneratedValue(strategy="AUTO")
        * @ORM\Column(type="integer")
        */
        private int $playlist_id;
        /**
        * @ORM\Column(type="string")
        */
        private string $name;
        /**
         *
         * @ManyToMany(targetEntity="music")
         * @JoinTable(name="playlist_music",
         *      joinColumns={@JoinColumn(name="music_id", referencedColumnName="music_id")},
         *      inverseJoinColumns={@JoinColumn(name="playlist_id", referencedColumnName="playlist_id")}
         *      )
        */
        private array $musics;
        /**
        * @ORM\Column(type="integer")
        */
        private int $user_id;
    }



?>