<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use App\Repository\SocioRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['read:Empresa']]),
        new Post(normalizationContext: ['groups' => ['read:Empresa']]),
        new Put(normalizationContext: ['groups' => ['read:Empresa']]),
        new Delete(normalizationContext: ['groups' => ['read:Empresa']]),
        new GetCollection(normalizationContext: ['groups' => ['read:Empresa']])
    ]
)]
class Socio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Empresa'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['read:Empresa'])]
    private ?string $nome = null;

    #[ORM\Column(length: 14)]
    #[Assert\NotBlank]
    #[Groups(['read:Empresa'])]
    private ?string $cpf = null;

    #[ORM\ManyToMany(targetEntity: Empresa::class, mappedBy: 'socios', cascade: ['persist'])]
    // #[Groups(['read:Empresa'])]
    private Collection $empresas;

    public function __construct()
    {
        $this->empresas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return Collection<int, Empresa>
     */
    public function getEmpresas(): Collection
    {
        return $this->empresas;
    }

    public function addEmpresa(Empresa $empresa): static
    {
        if (!$this->empresas->contains($empresa)) {
            $this->empresas->add($empresa);
            $empresa->addSocio($this);
        }

        return $this;
    }

    public function removeEmpresa(Empresa $empresa): static
    {
        if ($this->empresas->removeElement($empresa)) {
            $empresa->removeSocio($this);
        }

        return $this;
    }
}
