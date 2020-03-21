<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank
	 * @Assert\Length(
	 *     min = 4,
	 *     max = 255,
	 *     minMessage = "Le nom de l'entreprise doit faire au minimum {{ limit }} caractères",
	 *     maxMessage = "Le nom de l'entreprise doit faire au maximum {{ limit }} caractères"
	 * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=150)
	 * @Assert\NotBlank
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=100)
	 * @Assert\Regex(pattern="#^[1-9][0-9]{0,2}(bis| bis)? #i", message = "Le numéro de rue semble incorrect.")
	 * @Assert\Regex(pattern="# rue | voie | avenue | boulevard | impasse | allée | place | route #i", message = "Le type de route/voie semble incorrect.")
	 * @Assert\Regex(pattern="# [0-9]{5} #", message = "Il semble y avoir un problème avec le code postal.")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=150)
	 * @Assert\Url
     */
    private $adresseWeb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAdresseWeb(): ?string
    {
        return $this->adresseWeb;
    }

    public function setAdresseWeb(string $adresseWeb): self
    {
        $this->adresseWeb = $adresseWeb;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
