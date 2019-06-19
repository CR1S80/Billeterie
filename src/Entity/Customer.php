<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
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
     * @Assert\NotBlank(message="constraint.ticket.notblank.lastname", groups={"address"})
     * @Assert\Regex(pattern="/^[a-zA-Z-éàèçù]+$/i",message="constraint.ticket.type.lastname", groups={"address"})
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.ticket.notblank.firstname", groups={"address"})
     * @Assert\Regex(pattern="/^[a-zA-Z-éàèçù]+$/i",message="constraint.ticket.type.firstname", groups={"address"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.customer.notblank.email", groups={"address"})
     * @Assert\Email(checkMX=true, strict=true, message="constraint.customer.message.email", groups={"address"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.customer.notblank.adress", groups={"address"})
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.customer.notblank.postcode", groups={"address"})
     * @Assert\Regex(pattern="/^[a-zA-Z0-9]+$/i",message="constraint.customer.regex.postcode", groups={"address"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="constraint.customer.notblank.city", groups={"address"})
     * @Assert\Regex(pattern="/^[a-zA-Z-éàèçù]+$/i",message="constraint.customer.regex.city", groups={"address"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visit", inversedBy="customer")
     */
    private $visit;





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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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
