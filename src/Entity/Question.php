<?php

namespace Theo\Entity;

class Question{
    private int $id;
    protected string $titre;
    protected string $partageurl;
    protected float $reussite;
    protected string $reponseJuste;
    protected string $messageSuccess;
    protected string $messageError;

    public function __construct(string $titre, string $partageurl,string $reponseJuste,string $messageSuccess,string $messageError, float $reussite = 0)
    {
        $this->titre = $titre;
        $this->partageurl = $partageurl;
        $this->reussite = $reussite;
        $this->reponseJuste = $reponseJuste;
        $this->messageSuccess = $messageSuccess;
        $this->messageError = $messageError;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function getReponseJuste(): string
    {
        return $this->reponseJuste;
    }

    public function setReponseJuste(string $reponseJuste): void
    {
        $this->reponseJuste = $reponseJuste;
    }

    public function getPartageurl(): string
    {
        return $this->partageurl;
    }

    public function setPartageurl(string $partageurl): void
    {
        $this->partageurl = $partageurl;
    }

    public function getReussite(): float
    {
        return $this->reussite;
    }

    public function setReussite(float $reussite): void
    {
        $this->reussite = $reussite;
    }

    public function getMessageSuccess(): string
    {
        return $this->messageSuccess;
    }

    public function setMessageSuccess(string $messageSuccess): void
    {
        $this->messageSuccess = $messageSuccess;
    }

    public function getMessageError(): string
    {
        return $this->messageError;
    }

    public function setMessageError(string $messageError): void
    {
        $this->messageError = $messageError;
    }
    
}