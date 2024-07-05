<?php

namespace App\Form\FormObject;

use App\Entity\Campus;

class SearchSortieObject
{
    // TODO prendre exemple sur une entité mais sans ORM
    // Peut garder les asserts mais pas au début le temps de tester
    // un campus
    // Un string nom
    // Deux dates start et end
    // 4 bool (check box)

private Campus $campus;

private ?string $nomSortie = null;

private ?\DateTimeInterface $dateDebutSortie = null;

private ?\DateTimeInterface $dateFinSortie = null;

private ?bool $sortiesOrganisateur = false;
private ?bool $sortiesInscrit = false;
private ?bool $sortiesPasInscrit = false;
private ?bool $sortiesPassees = false;

    public function getCampus(): Campus
    {
        return $this->campus;
    }

    public function setCampus(Campus $campus): void
    {
        $this->campus = $campus;
    }

    public function getNomSortie(): ?string
    {
        return $this->nomSortie;
    }

    public function setNomSortie(?string $nomSortie): void
    {
        $this->nomSortie = $nomSortie;
    }

    public function getDateDebutSortie(): ?\DateTimeInterface
    {
        return $this->dateDebutSortie;
    }

    public function setDateDebutSortie(?\DateTimeInterface $dateDebutSortie): void
    {
        $this->dateDebutSortie = $dateDebutSortie;
    }

    public function getDateFinSortie(): ?\DateTimeInterface
    {
        return $this->dateFinSortie;
    }

    public function setDateFinSortie(?\DateTimeInterface $dateFinSortie): void
    {
        $this->dateFinSortie = $dateFinSortie;
    }

    public function getSortiesOrganisateur(): bool
    {
        return $this->sortiesOrganisateur;
    }

    public function setSortiesOrganisateur(?bool $sortiesOrganisateur): void
    {
        $this->sortiesOrganisateur = $sortiesOrganisateur;
    }

    public function getSortiesInscrit(): bool
    {
        return $this->sortiesInscrit;
    }

    public function setSortiesInscrit(?bool $sortiesInscrit): void
    {
        $this->sortiesInscrit = $sortiesInscrit;
    }

    public function getSortiesPasInscrit(): bool
    {
        return $this->sortiesPasInscrit;
    }

    public function setSortiesPasInscrit(?bool $sortiesPasInscrit): void
    {
        $this->sortiesPasInscrit = $sortiesPasInscrit;
    }

    public function getSortiesPassees(): bool
    {
        return $this->sortiesPassees;
    }

    public function setSortiesPassees(?bool $sortiesPassees): void
    {
        $this->sortiesPassees = $sortiesPassees;
    }
}