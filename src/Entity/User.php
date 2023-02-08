<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $auteurPost;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $auteurComments;

    public function __construct() {
        $this->auteurPost = new ArrayCollection();
        $this->auteurComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getAuteurPost(): Collection
    {
        return $this->auteurPost;
    }

    public function addAuteurPost(Post $auteurPost): self
    {
        if (!$this->auteurPost->contains($auteurPost)) {
            $this->auteurPost->add($auteurPost);
            $auteurPost->setAuteur($this);
        }

        return $this;
    }

    public function removeAuteurPost(Post $auteurPost): self
    {
        if ($this->auteurPost->removeElement($auteurPost)) {
            // set the owning side to null (unless already changed)
            if ($auteurPost->getAuteur() === $this) {
                $auteurPost->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getAuteurComments(): Collection
    {
        return $this->auteurComments;
    }

    public function addAuteurComment(Comment $auteurComment): self
    {
        if (!$this->auteurComments->contains($auteurComment)) {
            $this->auteurComments->add($auteurComment);
            $auteurComment->setAuteur($this);
        }

        return $this;
    }

    public function removeAuteurComment(Comment $auteurComment): self
    {
        if ($this->auteurComments->removeElement($auteurComment)) {
            // set the owning side to null (unless already changed)
            if ($auteurComment->getAuteur() === $this) {
                $auteurComment->setAuteur(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->username;
    }

}
