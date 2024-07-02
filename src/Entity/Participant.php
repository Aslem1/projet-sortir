<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'serie_id_seq', initialValue: 1, allocationSize: 100)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de renseigner un nom')]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/", message: 'Le nom ne doit contenir que des lettres et des espaces')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de renseigner un prenom')]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/", message: 'Le prenom ne doit contenir que des lettres et des espaces')]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true, unique: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner un pseudo')]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9_\-]*$/", message: 'Le pseudo ne doit contenir que des lettres, des chiffres, des traits de soulignement et des traits d\'union')]
    private ?string $pseudo = null;

    #[ORM\Column(length: 12, nullable: true)]
    #[Assert\Length(min: 10, max: 12)]
    private ?string $telephone = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner un mail')]
    #[Assert\Email]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Merci de renseigner un mot de passe')]
    private ?string $motDePasse = null;

    #[ORM\Column]
    private ?bool $administrateur = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actif = null;

    /**
     * @var Collection<int, Sortie>
     */
    #[ORM\ManyToMany(targetEntity: Sortie::class, mappedBy: 'participants')]
    private Collection $sortiesInscription;

    /**
     * @var Collection<int, Sortie>
     */
    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'organisateur', orphanRemoval: true)]
    private Collection $sorties;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    public function __construct()
    {
        $this->sortiesInscription = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function isAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur): static
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSortieInscription(): Collection
    {
        return $this->sortiesInscription;
    }

    public function addSortieInscription(Sortie $sortiesInscription): static
    {
        if (!$this->sortiesInscription->contains($sortiesInscription)) {
            $this->sortiesInscription->add($sortiesInscription);
            $sortiesInscription->addParticipant($this);
        }

        return $this;
    }

    public function removeSortieInscription(Sortie $sortiesInscription): static
    {
        if ($this->sortiesInscription->removeElement($sortiesInscription)) {
            $sortiesInscription->removeParticipant($this);
        }

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
            $sorty->setOrganisateur($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): static
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getOrganisateur() === $this) {
                $sorty->setOrganisateur(null);
            }
        }

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

    public function getPassword(): ?string
    {
        // TODO: Implement getPassword() method.
        return $this->motDePasse;
    }

    public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
        // si admin = true alors tableau avec role admin
        // Sinon role user
        return $this->administrateur ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return (string) $this->mail;
    }
}
