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
     * @ORM\Column(type="string", length=255)
     */
    private string $instance;

    /**
     * @ORM\Column(type="text")
     */
    private string $context;

    /**
     * @ORM\Column(type="text")
     */
    private string $exception;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $time;

    public function getId(): ?int {
        return $this->id;
    }

    public function getInstance(): ?string {
        return $this->instance;
    }

    public function setInstance(string $instance): self {
        $this->instance = $instance;

        return $this;
    }

    public function getContext(): ?Request {
        return $this->context ? unserialize($this->context) : null;
    }

    public function getTextContext(): ?string {
        return $this->context;
    }

    public function setContext(string $context): self {
        $this->context = $context;
        return $this;
    }

    public function getException(): ?FlattenException {
        return $this->exception ? unserialize($this->exception) : null;
    }

    public function getTextException(): ?string {
        return $this->exception;
    }

    public function setException(string $exception): self {
        $this->exception = $exception;

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
