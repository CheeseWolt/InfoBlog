<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(UserService $service)
    {
        return $this->render('user/index.html.twig', [
            'users' => $service->getUsers(),
        ]);
    }

    /**
     * @Route("/newUser", name="newUser")
     */
    public function new(Request $request, UserService $service)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->postUser($form->getData());
            return $this->redirectToRoute("user");
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updateUser/{id}", name="updateUser")
     */
    public function update(Request $request, UserService $service, int $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->putUser($form->getData());
            return $this->redirectToRoute("user");
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeUser/{id}", name="removeUser")
     */
    public function remove(UserService $service, $id)
    {
        $service->deleteUser($id);
        return $this->redirectToRoute("user");
    }
}
