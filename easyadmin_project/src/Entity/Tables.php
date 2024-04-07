<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\TablesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TablesRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource(
    operations: [
        new Get(security: 'is_granted("ROLE_USER")'),
        new GetCollection(security: 'is_granted("ROLE_USER")'),
        new Patch(security: 'is_granted("ROLE_USER")'),
        new GetCollection(uriTemplate: '/tables/{id}/guests',
            security: 'is_granted("ROLE_USER")'),
        new GetCollection(uriTemplate: '/tables_stats',
            security: 'is_granted("ROLE_USER")'),
    ],
    normalizationContext: ['groups' => ['tables:read']],
    denormalizationContext: ['groups' => ['tables:create', 'tables:update']],
)]
class Tables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['tables:read', 'tables:create', 'tables:update'])]
    #[ORM\Column]
    private int $num;

    #[Groups(['tables:create', 'tables:update'])]
    #[ORM\Column(length: 255)]
    private string $description;

    #[Groups(['tables:create', 'tables:update'])]
    #[ORM\Column(length: 2)]
    private int $maxGuests;

    #[Groups(['tables:create', 'tables:update'])]
    #[ORM\Column(length: 2)]
    private int $guestsDef;

    #[Groups(['tables:create', 'tables:update'])]
    #[ORM\Column(length: 2)]
    private int $guestsNow;

    #[Groups(['tables:create', 'tables:update'])]
    #[ORM\OneToMany(targetEntity: GuestList::class, mappedBy: 'table_id')]
    private Collection $guests;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNum(): int
    {
        return $this->num;
    }


    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxGuests(): int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(int $maxGuests): self
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    public function getGuestsDef(): int
    {
        return $this->guestsDef;
    }

    public function setGuestsDef(int $guestsDef): self
    {
        $this->guestsDef = $guestsDef;

        return $this;
    }

    public function getGuestsNow(): int
    {
        return $this->guestsNow;
    }

    public function setGuestsNow(int $guestsNow): self
    {
        $this->guestsNow = $guestsNow;

        return $this;
    }

    /**
     * @return Collection<int, GuestList>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(GuestList $guest): static
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->setTableId($this);
        }

        return $this;
    }

    public function removeGuest(GuestList $guest): static
    {
        if ($this->guests->removeElement($guest)) {
            // set the owning side to null (unless already changed)
            if ($guest->getTableId() === $this) {
                $guest->setTableId(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function countGuestsForTable(): void
    {
        $this->guestsNow = $this->guests->count();
    }

    public function __toString(): string {
        return $this->num;
    }

    public function incrementGuestsDef(): self
    {
        $this->guestsDef++;

        return $this;
    }

    public function decrementGuestsDef(): self
    {
        if ($this->guestsDef > 0) {
            $this->guestsDef--;
        }

        return $this;
    }

}
