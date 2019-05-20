<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 */
class Visit


{

    const TYPE_HALF_DAY = 0;
    const TYPE_FULL_DAY = 1;
    const NB_TICKET_MAX_DAY = 1000;
    const LIMITED_HOUR_TODAY = 16;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $invoiceDate;

    /**
     * @ORM\Column(type="date")
     */
    private $visitDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfTicket;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookingID;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ticket", mappedBy="visit")
     */
    private $tickets;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\customer", inversedBy="visits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoiceDate(): ?\DateTimeInterface
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(\DateTimeInterface $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNumberOfTicket(): ?int
    {
        return $this->numberOfTicket;
    }

    public function setNumberOfTicket(int $numberOfTicket): self
    {
        $this->numberOfTicket = $numberOfTicket;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getBookingID(): ?string
    {
        return $this->bookingID;
    }

    public function setBookingID(string $bookingID): self
    {
        $this->bookingID = $bookingID;

        return $this;
    }


    /**
     * @return Collection|ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setVisit($this);
        }

        return $this;
    }

    public function removeTicket(ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getVisit() === $this) {
                $ticket->setVisit(null);
            }
        }

        return $this;
    }

    public function getCustomer(): ?customer
    {
        return $this->customer;
    }

    public function setCustomer(?customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
