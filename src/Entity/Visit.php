<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validator\Constraints as Validate;

/**
 * Class Visit
 *
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 * @UniqueEntity("bookingID")
 * @Validate\FullDayLimitHour(hour=14, groups={"order"})
 *
 * @package App\Entity
 */
class Visit


{

    const TYPE_HALF_DAY = 0;
    const TYPE_FULL_DAY = 1;
    const NB_TICKET_MAX_DAY = 1000;
    const LIMITED_HOUR_TODAY = 16;

    const IS_VALID_INIT = ["order"];
    const IS_VALID_WITH_TICKET = ["order", "customer"];
    const IS_VALID_WITH_CUSTOMER = ["order", "customer", "address"];
    const IS_VALID_WITH_BOOKINGCODE = ["order", "customer", "address", "pay"];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @Assert\DateTime(groups={"order"})
     */
    private $invoiceDate;

    /**
     *
     * @ORM\Column(type="date")
     * @Assert\Range(min="today", minMessage="constraint.visit.min.visitdate",
     *     max="+1 year", maxMessage="constraint.visit.max.visitdate", groups={"order"})
     * @Validate\HourLimitToday(hour=16, groups={"order"})
     * @Validate\NoBookingOnSunday(groups={"order"})
     * @Validate\NoBookingOnTuesday(groups={"order"})
     * @Validate\PublicHolidays(groups={"order"})
     * @Assert\NotNull()
     *
     */
    private $visitDate;

    /**
     * @var integer
     * @ORM\Column(name="type", type="integer")
     * @Assert\Range(min=0, minMessage="constraint.visit.type", max="1", maxMessage="constraint.visit.type")
     *
     * @Assert\NotBlank(message="constraint.visit.type", groups={"order"})
     */
    private $type;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, minMessage="constraint.visit.min.nb.tickets", max=10,
     *     maxMessage="constraint.visit.max.nb.tickets")
     */
    private $numberOfTicket;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPrice;

    /**
     * @ORM\Column(name="booking_id", type="string", unique=true, length=255)
     * @Assert\NotNull(groups={"pay"})
     *
     */
    private $bookingID;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="visit",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid(groups={"customer"})
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="visit", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid(groups={"address"})
     */
    private $customer;



    public function __construct()

    {

        $this->invoiceDate = new DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->visitDate = new DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->tickets = new ArrayCollection();
        $this->customer = new ArrayCollection();

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

    /**
     * @param string $bookingID
     * @return Visit
     */
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

    /**
     * @return Collection|customer[]
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customer->contains($customer)) {
            $this->customer[] = $customer;
            $customer->setVisit($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customer->contains($customer)) {
            $this->customer->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getVisit() === $this) {
                $customer->setVisit(null);
            }
        }

        return $this;
    }




}
