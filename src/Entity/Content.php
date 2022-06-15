<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $entityId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fqcn;

    /**
     * @ORM\Column(type="integer")
     */
    private $languageId;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="contents")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="contents")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Ingridient::class, inversedBy="contents")
     */
    private $ingridients;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class, inversedBy="contents")
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity=Meal::class, inversedBy="contents")
     */
    private $meals;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->ingridients = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->meals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityId(int $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFqcn(): ?string
    {
        return $this->fqcn;
    }

    public function setFqcn(string $fqcn): self
    {
        $this->fqcn = $fqcn;

        return $this;
    }  
    
    public function getLanguageId(): ?int
    {
        return $this->languageId;
    }

    public function setLanguageId(int $languageId): self
    {
        $this->languageId = $languageId;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Ingridient>
     */
    public function getIngridients(): Collection
    {
        return $this->ingridients;
    }

    public function addIngridient(Ingridient $ingridient): self
    {
        if (!$this->ingridients->contains($ingridient)) {
            $this->ingridients[] = $ingridient;
        }

        return $this;
    }

    public function removeIngridient(Ingridient $ingridient): self
    {
        $this->ingridients->removeElement($ingridient);

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->languages->removeElement($language);

        return $this;
    }

    /**
     * @return Collection<int, Meal>
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meal $meal): self
    {
        if (!$this->meals->contains($meal)) {
            $this->meals[] = $meal;
        }

        return $this;
    }

    public function removeMeal(Meal $meal): self
    {
        $this->meals->removeElement($meal);

        return $this;
    }
}
