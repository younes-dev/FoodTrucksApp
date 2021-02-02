

1  bin/console make:functional-test
2  composer req phpunit
3  bin/phpunit




foodtruck
 - id
 - name
 - adresse

parking

emplacement
reservation



- parking(id,name,adresse, emplacements)
  parkink-enmplacement(id-parking,id-emplacement)
- emplacement(id,localisation,name)

reservation id_emplacement id_truck date_resrvation 

 plusieurs emplacemenet -> chaque emplacment -> reservations pour une date specifique <- foodtruck
 
ctl + L



    public function getReservationAt(): ?\DateTimeInterface
    {
        return $this->reservationAt;
    }

    public function setReservationAt(\DateTimeInterface $reservationAt): self
    {
        $this->reservationAt = $reservationAt;

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