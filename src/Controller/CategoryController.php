<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\CategoryService;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryService $service)
    {
        return $this->render('category/index.html.twig', [
            'categories' => $service->getCategories(),
        ]);
    }

    /**
     * @Route("/newCategory", name="newCategory")
     */
    public function new(Request $request, CategoryService $service)
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->postCategory($form->getData());
            return $this->redirectToRoute("category");
        }
        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updateCategory/{id}", name="updateCategory")
     */
    public function update(Request $request, CategoryService $service, int $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->putCategory($form->getData());
            return $this->redirectToRoute("category");
        }
        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeCategory/{id}", name="removeCategory")
     */
    public function remove(CategoryService $service, $id)
    {
        $service->deleteCategory($id);
        return $this->redirectToRoute("category");
    }
}
