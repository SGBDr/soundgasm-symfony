<?php
    namespace App\Entity;
    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity()
    * @ORM\Table(name="artist")
    * */
    class Artist{
        /**
        * @ORM\Id()
        * @ORM\Column(type="integer")
        */
        private $artist_id;
        /**
        * @ORM\Column(type="string", unique=true)
        */
        private $name;
    }

?>