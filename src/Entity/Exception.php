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
     * @ORM\Column(type="string")
     */
    private string $hash;

    /**
     * @ORM\Column(type="string")
     */
    private string $instance;

    /**
     * @ORM\Column(type="string")
     */
    private string $mode;

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
    private string $exception;
    private ?FlattenException $unserializedException = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $time;

    public function getId(): ?int {
        return $this->id;
    }

    public function getHash(): string {
        return $this->hash;
    }

    public function setHash(string $hash): void {
        $this->hash = $hash;
    }

    public function getInstance(): string {
        return $this->instance;
    }

    public function setInstance(string $instance): void {
        $this->instance = $instance;
    }

    public function getMode(): string {
        return $this->mode;
    }

    public function setMode(string $mode): void {
        $this->mode = $mode;
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

    public function getException(): ?FlattenException {
        if(!$this->unserializedException) {
            $this->unserializedException = unserialize($this->exception);
        }

        return $this->unserializedException;
    }

    public function getTextException(): ?string {
        return $this->exception;
    }

    public function setException(string $exception): self {
        $this->exception = $exception;
        $this->unserializedException = null;

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
