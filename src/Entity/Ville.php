<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'serie_id_seq', initialValue: 1, allocationSize: 100)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir un nom')]
    #[Assert\Length(min: 2, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/", message: 'Le nom ne doit contenir que des lettres et des espaces')]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank(message: 'Merci de saisir un code postal')]
    #[Assert\Length(min: 5, max: 5, minMessage: 'Le code postal doit comporter 5 caractères', maxMessage: 'Le code postal doit comporter 5 caractères')]
    private ?string $codePostal = null;

    /**
     * @var Collection<int, Lieu>
     */
    #[ORM\OneToMany(targetEntity: Lieu::class, mappedBy: 'ville', orphanRemoval: true)]
    private Collection $lieus;

    public function __construct()
    {
        $this->lieus = new ArrayCollection();
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

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, Lieu>
     */
    public function getLieus(): Collection
    {
        return $this->lieus;
    }

    public function addLieu(Lieu $lieu): static
    {
        if (!$this->lieus->contains($lieu)) {
            $this->lieus->add($lieu);
            $lieu->setVille($this);
        }

        return $this;
    }

    public function removeLieu(Lieu $lieu): static
    {
        if ($this->lieus->removeElement($lieu)) {
            // set the owning side to null (unless already changed)
            if ($lieu->getVille() === $this) {
                $lieu->setVille(null);
            }
        }

        return $this;
    }
}
