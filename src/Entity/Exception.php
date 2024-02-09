<?php

namespace App\Entity;

use App\Repository\ExceptionRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExceptionRepository::class)]
class Exception {

    private const REQUEST = "Symfony\Component\HttpFoundation\Request";
    private const FLATTEN_EXCEPTIONS = "Symfony\Component\ErrorHandler\Exception\FlattenException[]";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Instance::class, cascade: ["persist"])]
    private ?Instance $instance = null;

    #[ORM\Column(type: Types::JSON)]
    private ?array $context = null;

    #[ORM\Column(type: Types::JSON)]
    private ?array $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $request = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $exceptions = null;


    private ?array $unserializedRequest = null;
    private ?array $unserializedExceptions = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTime $time = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getInstance(): ?Instance {
        return $this->instance;
    }

    public function setInstance(?Instance $instance): self {
        $this->instance = $instance;
        return $this;
    }

    public function getContext(): ?array {
        return $this->context;
    }

    public function setContext(?array $context): self {
        $this->context = $context;
        return $this;
    }

    public function getUser(): ?array {
        return $this->user;
    }

    public function setUser(?array $user): self {
        $this->user = $user;
        return $this;
    }

    public function getRequest(): ?array {
        if(!$this->unserializedRequest) {
            $this->unserializedRequest = json_decode($this->request, true);
        }

        return $this->unserializedRequest;
    }

    public function getTextRequest(): ?string {
        return $this->request;
    }

    public function setRequest(string $request): self {
        $this->request = $request;
        $this->unserializedRequest = null;

        return $this;
    }

    public function getExceptions(): ?array {
        if(!$this->unserializedExceptions) {
            $this->unserializedExceptions = json_decode($this->exceptions, true);
        }

        return $this->unserializedExceptions;
    }

    public function getFirstException(): ?array {
        if(!$this->unserializedExceptions) {
            $this->unserializedExceptions = json_decode($this->exceptions, true);
        }

        return $this->unserializedExceptions[0];
    }

    public function getTextExceptions(): ?string {
        return $this->exceptions;
    }

    public function setExceptions(string $exceptions): self {
        $this->exceptions = $exceptions;
        $this->unserializedExceptions = null;

        return $this;
    }

    public function getTime(): ?DateTime {
        return $this->time;
    }

    public function setTime(?DateTime $time): self {
        $this->time = $time;
        return $this;
    }

}
