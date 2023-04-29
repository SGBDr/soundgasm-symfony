<?php
    namespace App\Entity;
    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;

    /**
    * @ORM\Entity()
    * @ORM\Table(name="music")
    * */
    class Music{
        /**
        * @ORM\Id()
        * @ORM\Column(type="integer")
        */
        private $music_id;
        /**
        * @ORM\Column(type="string")
        */
        private $name;
        /**
        * @ORM\Column(type="text")
        */
        private $rep_image;
        /**
        * @ORM\Column(type="text")
        */
        private $track;
        /**
         * @ManyToOne(targetEntity="artist")
         * @JoinColumn(name="artist", referencedColumnName="name")
        */
        private $artist;
        /**
        * @ORM\Column(type="string", nullable="true")
        */
        private $style;
        /**
        * @ORM\Column(type="string", nullable="true")
        */
        private $country;
        /**
        * @ORM\Column(type="datetime", name="date")
        */
        private $release_date;
    }


?>