<?php

namespace App\Entity;

use App\Repository\InstanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InstanceRepository::class)
 */
class Instance {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $mode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $environment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $locale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $dashboardToken;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $forbiddenPhones;

    public static function from(array $data): ?Instance {
        $instance = new Instance();
        $instance->setName($data["name"]);
        $instance->setMode($data["mode"]);
        $instance->setEnvironment($data["env"]);
        $instance->setLocale($data["locale"]);
        $instance->setClient($data["client"]);
        $instance->setDashboardToken($data["dashboard_token"]);
        $instance->setUrl($data["url"]);
        $instance->setForbiddenPhones($data["forbidden_phones"]);

        return $instance;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getMode(): ?string {
        return $this->mode;
    }

    public function setMode(string $mode): self {
        $this->mode = $mode;

        return $this;
    }

    public function getEnvironment(): ?string {
        return $this->environment;
    }

    public function setEnvironment(string $environment): self {
        $this->environment = $environment;

        return $this;
    }

    public function getLocale(): ?string {
        return $this->locale;
    }

    public function setLocale(string $locale): self {
        $this->locale = $locale;

        return $this;
    }

    public function getClient(): ?string {
        return $this->client;
    }

    public function setClient(string $client): self {
        $this->client = $client;

        return $this;
    }

    public function getDashboardToken(): ?string {
        return $this->dashboardToken;
    }

    public function setDashboardToken(string $dashboardToken): self {
        $this->dashboardToken = $dashboardToken;

        return $this;
    }

    public function getUrl(): ?string {
        return $this->url;
    }

    public function setUrl(string $url): self {
        $this->url = $url;

        return $this;
    }

    public function getForbiddenPhones(): ?string {
        return $this->forbiddenPhones;
    }

    public function setForbiddenPhones(string $forbiddenPhones): self {
        $this->forbiddenPhones = $forbiddenPhones;

        return $this;
    }

}
