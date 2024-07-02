<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'serie_id_seq', initialValue: 1, allocationSize: 100)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de saisir un nom')]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/", message: 'Le nom ne doit contenir que des lettres et des espaces')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotNull(message: 'Merci de saisir une date')]
    #[Assert\DateTime]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(message: 'La durée est requise')]
    #[Assert\Type(type: "integer", message: "La durée doit être une valeur entière")]
    #[Assert\Positive(message: 'La durée doit être un nombre entier positif')]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotNull(message: 'La date limite d\'inscription est obligatoire')]
    #[Assert\DateTime]
    private ?\DateTimeInterface $dateLimiteInscription = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(message: 'Un nombre maximum d\'inscriptions est requis')]
    #[Assert\Type(type: "integer", message: "Le nombre maximum d'inscriptions doit être un nombre entier.")]
    #[Assert\Positive(message: 'Le nombre maximum d\'inscriptions doit être un nombre entier positif.')]
    private ?int $nbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infosSortie = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    #[ORM\ManyToOne(targetEntity: Etat::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\ManyToMany(targetEntity: Participant::class, inversedBy: 'sortiesInscription')]
    private Collection $participants;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participant $organisateur = null;

    #[ORM\ManyToOne(inversedBy: 'siteOrganisateur')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    public function __construct()
    {
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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(?\DateTimeInterface $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(?\DateTimeInterface $dateLimiteInscription): static
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(?int $nbInscriptionsMax): static
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): static
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

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
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): static
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): static
    {
        $this->campus = $campus;

        return $this;
    }
}
