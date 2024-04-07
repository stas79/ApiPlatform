<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\GuestListController;
use App\Repository\GuestListRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuestListRepository::class)]
#[ApiResource(
    operations: [
        new Get(security: 'is_granted("ROLE_USER")'),
        new GetCollection(controller: GuestListController::class,
            security: 'is_granted("ROLE_USER")'),
        new Patch(security: 'is_granted("ROLE_USER")'),
    ],
    normalizationContext: ['groups'=> ['guestlist:read']],
    denormalizationContext: ['groups'=> ['guestlist:create', 'guestlist:update']],
)]
class GuestList
{
    #[Groups(['guestlist:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['guestlist:read', 'guestlist:create', 'guestlist:update'])]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Groups(['guestlist:create', 'guestlist:update'])]
    #[ORM\Column]
    private bool $isPresent = false;

    #[ORM\ManyToOne(inversedBy: 'guests')]
    private ?Tables $table_id = null;

    // Use IRI reference for collection and JSON-LD, object for item
//    #[Groups(['guestlist:create', 'guestlist:update'])]
//    #[ORM\ManyToOne(targetEntity: Tables::class, inversedBy: 'guestLists')]
//    #[ORM\JoinColumn(name: 'table_id', referencedColumnName: 'id')]
//    private Tables $tables;

//    // Additional property for IRI representation
//    // This requires handling in your serializer or event listener to populate
//    private ?string $tablesIri = null;
//
//    public function getTablesIri(): ?string
//    {
//        return $this->tablesIri;
//    }
//
//    public function setTablesIri(?string $tablesIri): void
//    {
//        $this->tablesIri = $tablesIri;
//    }
    public function __toString(): string
    {
        // Return the property you want to use as the string representation
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsPresent(): bool
    {
        return $this->isPresent;
    }

    public function setIsPresent(bool $isPresent): self
    {
        $this->isPresent = $isPresent;

        return $this;
    }


    public function getTableId(): ?Tables
    {
        return $this->table_id;
    }

    public function setTableId(?Tables $table_id): self
    {
        if ($this->table_id !== $table_id && $table_id->getMaxGuests() < $table_id->getGuestsDef()) {
            // Decrement the counter from the old table
            if ($this->table_id !== null) {
                $table_id->decrementGuestsDef();
            }
            // Set the new table
            $this->table_id = $table_id;
            // Increment the counter for the new table
            if ($table_id !== null) {
                $table_id->incrementGuestsDef();
            }
        }

        return $this;
    }

}
