<?php

namespace App\Entity;

use App\Repository\SynopsisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * 
 * @ORM\Entity(repositoryClass=SynopsisRepository::class)
 * @UniqueEntity(
 * fields={"Titre"},
 *
 * )
 * 
 */

class Synopsis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TitreOriginal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Theme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NombreEpisode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Origine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AgeConseiller;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DateDiffusion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Studio;

    /**
     * @ORM\Column(type="text")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AnimeImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getTitreOriginal(): ?string
    {
        return $this->TitreOriginal;
    }

    public function setTitreOriginal(string $TitreOriginal): self
    {
        $this->TitreOriginal = $TitreOriginal;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->Theme;
    }

    public function setTheme(string $Theme): self
    {
        $this->Theme = $Theme;

        return $this;
    }

    public function getNombreEpisode(): ?string
    {
        return $this->NombreEpisode;
    }

    public function setNombreEpisode(string $NombreEpisode): self
    {
        $this->NombreEpisode = $NombreEpisode;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->Origine;
    }

    public function setOrigine(string $Origine): self
    {
        $this->Origine = $Origine;

        return $this;
    }

    public function getAgeConseiller(): ?string
    {
        return $this->AgeConseiller;
    }

    public function setAgeConseiller(string $AgeConseiller): self
    {
        $this->AgeConseiller = $AgeConseiller;

        return $this;
    }

    public function getDateDiffusion(): ?string
    {
        return $this->DateDiffusion;
    }

    public function setDateDiffusion(string $DateDiffusion): self
    {
        $this->DateDiffusion = $DateDiffusion;

        return $this;
    }

    public function getStudio(): ?string
    {
        return $this->Studio;
    }

    public function setStudio(string $Studio): self
    {
        $this->Studio = $Studio;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getAnimeImage(): ?string
    {
        return $this->AnimeImage;
    }

    public function setAnimeImage(string $AnimeImage): self
    {
        $this->AnimeImage = $AnimeImage;

        return $this;
    }
}
