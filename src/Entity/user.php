<?php

    class User{
        /**
        * @ORM\Id()
        * @ORM\GeneratedValue(strategy="AUTO")
        * @ORM\Column(type="integer")
        */
        private $user_id;
        /**
        * @ORM\Column(type="string")
        */
        private $name;
        /**
        * @ORM\Column(type="datetime", name="date", nullable="true")
        */
        private $birthday;
        /**
         * @OneToOne(targetEntity="identifier")
         * @JoinColumn(name="identifier_id", referencedColumnName="identifier_id")
        */
        private $identifier;
        /**
         *
         * @ManyToMany(targetEntity="music")
         * @JoinTable(name="playlist_music",
         *      joinColumns={@JoinColumn(name="music_id", referencedColumnName="music_id")},
         *      inverseJoinColumns={@JoinColumn(name="playlist_id", referencedColumnName="playlist_id")}
         *      )
        */
        private array $like_musics;
        /**
         * @OneToMany(targetEntity="playlist", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
        */
        private array $playlists;
        /**
         *
         * @ManyToMany(targetEntity="music")
         * @JoinTable(name="playlist_music",
         *      joinColumns={@JoinColumn(name="music_id", referencedColumnName="music_id")},
         *      inverseJoinColumns={@JoinColumn(name="playlist_id", referencedColumnName="playlist_id")}
         *      )
        */
        private array $artists;
    }


?>