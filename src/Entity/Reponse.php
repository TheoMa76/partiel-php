<?php

namespace Theo\Entity;

use Theo\Entity\Question;

class Reponse{
    private int $id;
    protected int $idQuestion;
    protected string $reponse;

    public function __construct(int $idQuestion, string $response)
    {
        $this->idQuestion = $idQuestion;
        $this->reponse = $response;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    public function setIdQuestion(int $idQuestion): void
    {
        $this->idQuestion = $idQuestion;
    }

    public function getReponse(): string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): void
    {
        $this->reponse = $reponse;
    }
    
}