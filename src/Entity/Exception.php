<?php

namespace App\Entity;

use App\Repository\ExceptionRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass=ExceptionRepository::class)
 */
class Exception {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Instance", cascade={"persist"})
     */
    private Instance $instance;

    /**
     * @ORM\Column(type="array")
     */
    private ?array $context;

    /**
     * @ORM\Column(type="array")
     */
    private ?array $user;

    /**
     * @ORM\Column(type="text")
     */
    private string $request;
    private ?Request $unserializedRequest = null;

    /**
     * @ORM\Column(type="text")
     */
    private string $exceptions;
    private ?array $unserializedExceptions = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $time;

    public function getId(): ?int {
        return $this->id;
    }

    public function getInstance(): ?Instance {
        return $this->instance;
    }

    public function setInstance(Instance $instance): void {
        $this->instance = $instance;
    }

    public function getContext(): ?array {
        return $this->context;
    }

    public function setContext(?array $context): void {
        $this->context = $context;
    }

    public function getUser(): ?array {
        return $this->user;
    }

    public function setUser(?array $user): void {
        $this->user = $user;
    }

    public function getRequest(): ?Request {
        if(!$this->unserializedRequest) {
            $this->unserializedRequest = unserialize($this->request);
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
            $this->unserializedExceptions = unserialize($this->exceptions);
        }

        return $this->unserializedExceptions;
    }

    public function getFirstException(): ?FlattenException {
        if(!$this->unserializedExceptions) {
            $this->unserializedExceptions = unserialize($this->exceptions);
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

    public function getTime(): ?DateTimeInterface {
        return $this->time;
    }

    public function setTime(DateTimeInterface $time): self {
        $this->time = $time;
        return $this;
    }

}
