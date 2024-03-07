<?php

namespace App\DTO;

class ConsultarEmpresa implements EmpresaInterface{

    private ?int $Id;

    private ?string $Nome;

    private ?string $RazaoSocial;

    private ?string $Cnpj;


    public function getId(): ?int
    {
        return $this->Id;
    }


    public function getNome(): ?string
    {
        return $this->Nome;
    }


    public function getRazaoSocial(): ?string
    {
        return $this->RazaoSocial;
    }


    public function getCnpj(): ?string
    {
        return $this->Cnpj;
    }


    public function setId(?int $Id): void
    {
        $this->Id = $Id;
    }


    public function setNome(?string $Nome): void
    {
        $this->Nome = $Nome;
    }


    public function setRazaoSocial(?string $RazaoSocial): void
    {
        $this->RazaoSocial = $RazaoSocial;
    }


    public function setCnpj(?string $Cnpj): void
    {
        $this->Cnpj = $Cnpj;
    }


    public function __construct(?int $Id, ?string $Nome, ?string $RazaoSocial, ?string $Cnpj)
    {
        $this->Id = $Id;
        $this->Nome = $Nome;
        $this->RazaoSocial = $RazaoSocial;
        $this->Cnpj = $Cnpj;
    }

    
    public function toArray(): array
    {
        return [
            'Id' => $this->getId(),
            'Nome' => $this->getNome(),
            'RazaoSocial' => $this->getRazaoSocial(),
            'Cnpj' => $this->getCnpj(),
        ];
    }

}
