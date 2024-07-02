<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'serie_id_seq', initialValue: 1, allocationSize: 100)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Merci de saisir un nom')]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/", message: 'Le nom ne doit contenir que des lettres et des espaces')]
    private ?string $nom = null;

    /**
     * @var Collection<int, Sortie>
     */
    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'campus', orphanRemoval: true)]
    private Collection $siteOrganisateur;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\OneToMany(targetEntity: Participant::class, mappedBy: 'campus', orphanRemoval: true)]
    private Collection $participants;

    public function __construct()
    {
        $this->siteOrganisateur = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSiteOrganisateur(): Collection
    {
        return $this->siteOrganisateur;
    }

    public function addSiteOrganisateur(Sortie $siteOrganisateur): static
    {
        if (!$this->siteOrganisateur->contains($siteOrganisateur)) {
            $this->siteOrganisateur->add($siteOrganisateur);
            $siteOrganisateur->setCampus($this);
        }

        return $this;
    }

    public function removeSiteOrganisateur(Sortie $siteOrganisateur): static
    {
        if ($this->siteOrganisateur->removeElement($siteOrganisateur)) {
            // set the owning side to null (unless already changed)
            if ($siteOrganisateur->getCampus() === $this) {
                $siteOrganisateur->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setCampus($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getCampus() === $this) {
                $participant->setCampus(null);
            }
        }

        return $this;
    }
}
