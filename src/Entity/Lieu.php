<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'serie_id_seq', initialValue: 1, allocationSize: 100)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nom obligatoire')]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/", message: 'Le nom ne doit contenir que des lettres et des espaces')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Rue obligatoire')]
    #[Assert\Length(min: 2, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9\s,\#]*$/", message: 'La rue ne doit contenir que des lettres, des chiffres, des espaces, des virgules et des dièses.')]
    private ?string $rue = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "float", message: "La latitude doit être un nombre à virgule")]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "float", message: "La longitude doit être un nombre à virgule")]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'lieus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null;

    /**
     * @var Collection<int, Sortie>
     */
    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'lieu', orphanRemoval: true)]
    private Collection $sorties;

    public function __construct()
    {
        $this->sorties = new ArrayCollection();
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): static
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setLieu($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): static
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getLieu() === $this) {
                $sorty->setLieu(null);
            }
        }

        return $this;
    }
}
