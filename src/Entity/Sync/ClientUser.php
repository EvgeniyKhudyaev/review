<?php

namespace App\Entity\Sync;

use App\Entity\MessageLog;
use App\Enum\Shared\StatusEnum;
use App\Repository\ClientUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientUserRepository::class)]
#[ORM\Table(name: '`client_user`')]
class ClientUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID, unique: true, nullable: false)]
    private ?string $uuid = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $telegram = null;

    #[ORM\Column(type: 'string', length: 20, enumType: StatusEnum::class)]
    private ?StatusEnum $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, ServiceHistory>
     */
    #[ORM\OneToMany(targetEntity: ServiceHistory::class, mappedBy: 'creator', orphanRemoval: true)]
    private Collection $serviceHistories;

    /**
     * @var Collection<int, MessageLog>
     */
    #[ORM\OneToMany(targetEntity: MessageLog::class, mappedBy: 'clientUser')]
    private Collection $messageLogs;

    public function __construct()
    {
        $this->serviceHistories = new ArrayCollection();
        $this->messageLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    public function setTelegram(?string $telegram): static
    {
        $this->telegram = $telegram;

        return $this;
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, ServiceHistory>
     */
    public function getServiceHistories(): Collection
    {
        return $this->serviceHistories;
    }

    public function addServiceHistory(ServiceHistory $serviceHistory): static
    {
        if (!$this->serviceHistories->contains($serviceHistory)) {
            $this->serviceHistories->add($serviceHistory);
            $serviceHistory->setCreator($this);
        }

        return $this;
    }

    public function removeServiceHistory(ServiceHistory $serviceHistory): static
    {
        $this->serviceHistories->removeElement($serviceHistory);

        return $this;
    }

    /**
     * @return Collection<int, MessageLog>
     */
    public function getMessageLogs(): Collection
    {
        return $this->messageLogs;
    }

    public function addMessageLog(MessageLog $messageLog): static
    {
        if (!$this->messageLogs->contains($messageLog)) {
            $this->messageLogs->add($messageLog);
            $messageLog->setClientUser($this);
        }

        return $this;
    }

    public function removeMessageLog(MessageLog $messageLog): static
    {
        if ($this->messageLogs->removeElement($messageLog)) {
            // set the owning side to null (unless already changed)
            if ($messageLog->getClientUser() === $this) {
                $messageLog->setClientUser(null);
            }
        }

        return $this;
    }
}
