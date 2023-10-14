<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'budgets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: BudgetEntry::class, cascade: ['persist', 'remove'])]
    private Collection $budgetEntries;

    public function __construct()
    {
        $this->budgetEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, BudgetEntry>
     */
    public function getBudgetEntries(): Collection
    {
        return $this->budgetEntries;
    }

    public function addBudgetEntry(BudgetEntry $budgetEntry): static
    {
        if (!$this->budgetEntries->contains($budgetEntry)) {
            $this->budgetEntries->add($budgetEntry);
            $budgetEntry->setBudget($this);
        }

        return $this;
    }

    public function removeBudgetEntry(BudgetEntry $budgetEntry): static
    {
        if ($this->budgetEntries->removeElement($budgetEntry)) {
            // set the owning side to null (unless already changed)
            if ($budgetEntry->getBudget() === $this) {
                $budgetEntry->setBudget(null);
            }
        }

        return $this;
    }

    public function getTotal(): float
    {
        $entries = $this->getBudgetEntries();
        $total = 0.0;

        foreach ($entries as $entry) {
            $total += $entry->getValue();
        }

        return (float) $total;
    }
}
