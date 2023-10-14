<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use App\Service\UserAuthorizationChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BudgetController extends AbstractController
{
    public function __construct(private readonly UserAuthorizationChecker $authorizationChecker)
    {
    }

    #[Route('/budgets', name: 'app_budget')]
    public function index(BudgetRepository $budgetRepository): Response
    {
        $user = $this->getUser();

        if (!$this->authorizationChecker->isVerified($user)) {
            return $this->redirectToRoute('app_check_email');
        }

        $budgets = $budgetRepository->findBy(['user' => $user]);

        return $this->render('budget/index.html.twig', ['budgets' => $budgets]);
    }

    #[Route('/budgets/add', name: 'app_budget_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();

        if (!$this->authorizationChecker->isVerified($user)) {
            return $this->redirectToRoute('app_check_email');
        }

        $budget = new Budget();
        $budgetForm = $this->createForm(BudgetType::class, $budget);
        $budgetForm->handleRequest($request);

        if ($budgetForm->isSubmitted() && $budgetForm->isValid()) {
            $budget->setUser($this->getUser());

            $manager->persist($budget);
            $manager->flush();

            $this->addFlash('success', 'Votre budget a bien été créé.');

            return $this->redirectToRoute('app_budget');
        }

        return $this->render('budget/add.html.twig', ['budgetForm' => $budgetForm->createView()]);
    }

    #[Route('/budgets/{id}/edit', name: 'app_budget_single_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Budget $budget = null): Response
    {
        $user = $this->getUser();

        if (!$this->authorizationChecker->isVerified($user)) {
            return $this->redirectToRoute('app_check_email');
        }

        if (!$this->authorizationChecker->checkBudgetAccess($user, $budget)) {
            return $this->redirectToRoute('app_budget');
        }

        $budgetForm = $this->createForm(BudgetType::class, $budget);
        $budgetForm->handleRequest($request);

        if ($budgetForm->isSubmitted() && $budgetForm->isValid()) {
            $manager->persist($budget);
            $manager->flush();

            $this->addFlash('success', 'Votre budget a bien été modifié');

            return $this->redirectToRoute('app_budget');
        }

        return $this->render('budget/edit.html.twig', ['budget' => $budget, 'budgetForm' => $budgetForm->createView()]);
    }

    #[Route('/budgets/{id}/remove', name: 'app_budget_single_delete')]
    public function remove(EntityManagerInterface $manager, Budget $budget = null): Response
    {
        $user = $this->getUser();

        if (!$this->authorizationChecker->isVerified($user)) {
            return $this->redirectToRoute('app_check_email');
        }

        if (!$this->authorizationChecker->checkBudgetAccess($user, $budget)) {
            return $this->redirectToRoute('app_budget');
        }

        $manager->remove($budget);
        $manager->flush();

        $this->addFlash('success', 'Votre budget a bien été supprimé');

        return $this->redirectToRoute('app_budget');
    }

    #[Route('/budgets/{id}', name: 'app_budget_single')]
    public function budget(Budget $budget = null): Response
    {
        $user = $this->getUser();

        if (!$this->authorizationChecker->isVerified($user)) {
            return $this->redirectToRoute('app_check_email');
        }

        if (!$this->authorizationChecker->checkBudgetAccess($user, $budget)) {
            return $this->redirectToRoute('app_budget');
        }

        return $this->render('budget/single.html.twig', ['budget' => $budget]);
    }
}
