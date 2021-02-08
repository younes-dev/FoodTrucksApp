<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Emplacement::class, inversedBy="reservations")
     */
    private $emplacement;

    /**
     * @ORM\ManyToOne(targetEntity=FoodTruck::class, inversedBy="reservations")
     */
    private $foodtruck;

    /**
     * @ORM\Column(type="date")
     */
    private $reservationAt;

    /**
     *  @ApiProperty(
     *     attributes={
     *         "openapi_context"={
     *             "type"="string",
     *             "enum"={"midi", "soir"},
     *             "example"="soir"
     *         }
     *     }
     * )
     * @ORM\Column(type="string")
     */
    private $periode;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getFoodtruck(): ?FoodTruck
    {
        return $this->foodtruck;
    }

    public function setFoodtruck(?FoodTruck $foodtruck): self
    {
        $this->foodtruck = $foodtruck;

        return $this;
    }

    public function getReservationAt(): ?\DateTimeInterface
    {
        return $this->reservationAt;
    }

    public function setReservationAt(\DateTimeInterface $reservationAt): self
    {
        $this->reservationAt = $reservationAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    /**
     * @param mixed $periode
     */
    public function setPeriode(string $periode): void
    {
        $this->periode = $periode;
    }

}
