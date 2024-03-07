<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\EmpresaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['read:Empresa']]),
        new Post(normalizationContext: ['groups' => ['read:Empresa']]),
        new Put(normalizationContext: ['groups' => ['read:Empresa']]),
        new Delete(normalizationContext: ['groups' => ['read:Empresa']]),
        new GetCollection(normalizationContext: ['groups' => ['read:Empresa']])
    ]
)]
class Empresa
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

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['read:Empresa'])]
    private ?string $razaoSocial = null;

    #[ORM\Column(length: 18)]
    #[Assert\NotBlank]
    #[Groups(['read:Empresa'])]
    private ?string $cnpj = null;

    #[ORM\ManyToMany(targetEntity: Socio::class, inversedBy: 'empresas', cascade: ['persist'])]
    #[Groups(['read:Empresa'])]
    private Collection $socios;

    public function __construct()
    {
        $this->socios = new ArrayCollection();
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

    public function getRazaoSocial(): ?string
    {
        return $this->razaoSocial;
    }

    public function setRazaoSocial(string $razaoSocial): static
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * @return Collection<int, Socio>
     */
    public function getSocios(): Collection
    {
        
        return $this->socios;

    }

    public function addSocio(Socio $socio): static
    {
        if (!$this->socios->contains($socio)) {
            $this->socios->add($socio);
        }

        return $this;
    }

    public function removeSocio(Socio $socio): static
    {
        $this->socios->removeElement($socio);

        return $this;
    }
}
