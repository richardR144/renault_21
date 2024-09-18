<?php

namespace App\Entity;
require_once 'vendor/autoload.php';

/**
 * @ORM\Entity()
 * @ORM\Table(name="messagerie")
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */


class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $expediteur;

    /**
     * @ORM\Column(type="integer")
     */
    private $destinataire;

    /**
     * @ORM\Column(type="text")
     */
    private $messageContent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
//************************************************************************************************
    // Getters et setters
//************************************************************************************************
    //Dans mon entité Message.php, j'utilise self pour retourner l’instance actuelle de l’objet ce qui permet de chaîner
    // les appels de méthodes. J'utilise ?int pour indiquer que les méthodes getId, getExpediteur, et getDestinataire
    // peuvent retourner soit un entier, soit null
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setExpediteur(): ?int
    {
        return $this->expediteur;
    }
    public function getExpediteur(int $expediteur): self
    {
        $this->expediteur = $expediteur;
        return $this;
    }
    public function setDestinataire($destinataire): ?int
    {
        $this->destinataire = $destinataire;
        return $this->destinataire;
    }
    public function getDestinataire(int $destinataire): self
    {
        $this->destinataire = $destinataire;
        return $this;
    }
    public function getMessageContent(): ?string
    {
        return $this->messageContent;
    }
    public function setMessageContent(string $messageContent): self
    {
        $this->messageContent = $messageContent;
        return $this;
    }
    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }
    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;
        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
