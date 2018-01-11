<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Customer
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $lastName;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $address;
}