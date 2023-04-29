<?php
    namespace App\Entity;
    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity()
    * @ORM\Table(name="identifier")
    * */
    class Identifier{
        /**
        * @ORM\Id()
        * @ORM\GeneratedValue(strategy="AUTO")
        * @ORM\Column(type="integer")
        */
        private $identifier_id;
        /**
        * @ORM\Column(type="string")
        */
        private $email;
        /**
        * @ORM\Column(type="string")
        */
        private $password;
        /**
        * @ORM\Column(type="boolean")
        */
        private $active;
        /**
        * @ORM\Column(type="string")
        */
        private $role;
    }


?>