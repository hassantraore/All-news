<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Container2xQSl9p\getForm_TypeExtension_CsrfService;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Vich\UploaderBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @Vich\Uploadable
 */
class Post
{
    /**
     * @var int/null
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private  $id;
    /**
     * @var string
     * @ORM\Column
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     */
    private string $title ;

    /*/**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    //private \DateTimeImmutable $publishedDate;


    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     */
    private string $contents;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="post",cascade={"persist", "remove"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post",orphanRemoval=true)
     */
    private  $comments;


    /**
     * @var string|null
     * @ORM\Column
     */

    private ?string $image=null;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     */
    private $authorName;


    /**
     * @Gedmo\Slug(fields={"title"})
     * @var string
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private string $slug;

    /**
     * @Vich\UploadableField(mapping="post_image", fileNameProperty="image")
     * @var File
     */
    private  $imageFile;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @ORM\Column(type="datetime_immutable")
     * @var \DateTimeImmutable()
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @var User
     */
    private User $user;

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->title;

    }


  /**
   * Post constructor.
   */
    public function __construct(){
        $this->publishedAt = new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
        //$this->category = new Category();
        //$this->category = new ArrayCollection();

    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }





    /**
     * @return \DateTimeImmutable
     */
    public function getPublishedAt(): \DateTimeImmutable
    {
        return $this->publishedAt;
    }



    /**
     * @param File $imageFile
     */
    public function setImageFile(?File $image = null)
    {
        $this->imageFile = $image;
        if($image){
            $this->updatedAt = new \DateTime();}
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }



    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }



    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string/null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getContents(): ?string
    {
        return $this->contents;
    }

    /**
     * @return Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Collection $comments
     */
    public function setComments(Collection $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return Category|null
     */

    public function getCategory(): ?Category
    {
        return $this->category;
    }



    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }




    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;

    }

    /**
     * @param string $contents
     */
    public function setContents(string $contents): void
    {
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param mixed $authorName
     */
    public function setAuthorName($authorName): void
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

}
