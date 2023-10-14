<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BudgetController extends AbstractController
{
    #[Route('/budgets', name: 'app_budget')]
    public function index(BudgetRepository $budgetRepository): Response
    {
        $budgets = $budgetRepository->findBy(['user' => $this->getUser()]);

        return $this->render('budget/index.html.twig', [
            'budgets' => $budgets,
        ]);
    }

    #[Route('/budgets/add', name: 'app_budget_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $budget = new Budget();
        $budgetForm = $this->createForm(BudgetType::class, $budget);

        $budgetForm->handleRequest($request);

        if ($budgetForm->isSubmitted() && $budgetForm->isValid()) {
            $budget->setUser($this->getUser());

            $manager->persist($budget);
            $manager->flush();

            return $this->redirectToRoute('app_budget');
        }

        return $this->render('budget/add.html.twig', [
            'budgetForm' => $budgetForm->createView(),
        ]);
    }

    #[Route('/budgets/{id}/edit', name: 'app_budget_single_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Budget $budget = null): Response
    {
        if (null === $budget) {
            return $this->redirectToRoute('app_budget');
        }

        if ($this->getUser() !== $budget->getUser()) {
            return $this->redirectToRoute('app_budget');
        }

        $budgetForm = $this->createForm(BudgetType::class, $budget);

        $budgetForm->handleRequest($request);
        if ($budgetForm->isSubmitted() && $budgetForm->isValid()) {
            $manager->persist($budget);
            $manager->flush();

            return $this->redirectToRoute('app_budget');
        }

        return $this->render('budget/edit.html.twig', [
            'budget' => $budget,
            'budgetForm' => $budgetForm->createView(),
        ]);
    }

    #[Route('/budgets/{id}/remove', name: 'app_budget_single_remove')]
    public function remove(Budget $budget = null, EntityManagerInterface $manager): Response
    {
        if (null === $budget) {
            return $this->redirectToRoute('app_budget');
        }

        if ($this->getUser() !== $budget->getUser()) {
            return $this->redirectToRoute('app_budget');
        }

        $manager->remove($budget);
        $manager->flush();

        return $this->redirectToRoute('app_budget');
    }

    #[Route('/budgets/{id}', name: 'app_budget_single')]
    public function budget(Budget $budget = null): Response
    {
        if (null === $budget) {
            return $this->redirectToRoute('app_budget');
        }
        if ($this->getUser() !== $budget->getUser()) {
            return $this->redirectToRoute('app_budget');
        }

        return $this->render('budget/single.html.twig', [
            'budget' => $budget,
        ]);
    }
}
