<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\TagService;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag")
     */
    public function index(TagService $service)
    {
        return $this->render('tag/index.html.twig', [
            'tags' => $service->getTags(),
        ]);
    }

    /**
     * @Route("/newTag", name="newTag")
     */
    public function new(Request $request, TagService $service)
    {
        $form = $this->createForm(TagType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->postTag($form->getData());
            return $this->redirectToRoute("tag");
        }
        return $this->render('tag/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updateTag/{id}", name="updateTag")
     */
    public function update(Request $request, TagService $service, int $id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);
        $form = $this->createForm(TagType::class,$tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->putTag($form->getData());
            return $this->redirectToRoute("tag");
        }
        return $this->render('tag/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeTag/{id}", name="removeTag")
     */
    public function remove(TagService $service, $id)
    {
        $service->deleteTag($id);
        return $this->redirectToRoute("tag");
    }
}
