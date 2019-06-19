<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as Validate;
use Exception;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{

    const AGE_CHILD = 4;
    const AGE_ADULT = 12;
    const AGE_SENIOR = 60;
    const PRICE_ADULT = 16;
    const PRICE_DISCOUNT = 10;
    const PRICE_SENIOR = 12;
    const PRICE_CHILD = 8;
    const PRICE_FREE = 0;
    const PRICE_HALF_DAY_COEFF = 0.5;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.ticket.notblank.lastname", groups={"customer"})
     * @Assert\Regex(pattern="/^[a-zA-Z-éàèçù]+$/i",message="constraint.ticket.type.lastname", groups={"customer"})
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.ticket.notblank.firstname", groups={"customer"})
     * @Assert\Regex(pattern="/^[a-zA-Z-éàèçù]+$/i",message="constraint.ticket.type.firstname", groups={"customer"})
     */
    private $firstname;

    /**
     *
     * @ORM\Column(name="birthday", type="datetime")
     * @Assert\LessThan(
     *      "today",
     *      message = "test", groups={"customer"})
     *
     */
    private $birthday;


    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $reducedPrice;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visit", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visit;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(groups={"customer"})
     */
    private $country;

    /**
     * Ticket constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }



    public function getReducedPrice(): ?bool
    {
        return $this->reducedPrice;
    }

    public function setReducedPrice(bool $reducedPrice): self
    {
        $this->reducedPrice = $reducedPrice;

        return $this;
    }


    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVisit(): ?Visit
    {
        return $this->visit;
    }

    public function setVisit(?Visit $visit): self
    {
        $this->visit = $visit;

        return $this;
    }






}
