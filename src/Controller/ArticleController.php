<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Service\ArticleService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleService $service)
    {
        return $this->render('article/index.html.twig', [
            'articles' => $service->getArticles(),
        ]);
    }

    /**
     * @Route("/newArticle", name="newArticle")
     */
    public function new(Request $request, ArticleService $service)
    {
        $article = new Article;

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->postArticle($form->getData());
            return $this->redirectToRoute("article");
        }
        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updateArticle/{id}", name="updateArticle")
     */
    public function update(Request $request, ArticleService $service, int $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->putArticle($form->getData());
            return $this->redirectToRoute("article");
        }
        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeArticle/{id}", name="removeArticle")
     */
    public function remove(ArticleService $service, $id)
    {
        $service->deleteArticle($id);
        return $this->redirectToRoute("article");
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(ArticleService $articleService, Request $request, $id)
    {   
        $article = $articleService->getArticle($id);


        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $comment = $form->getData();
            $comment->setArticle($article);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('read',['id'=>$id]);
        }
        return $this->render("article/read.html.twig", [
            'article' => $article,
            'form_comment' => $form->createView()
        ]);
    }
    /**
     * @Route("/tag/{id}", name="byTag")
     */
    public function byTag(ArticleService $articleService, $id)
    {   
        $articles = $articleService->getArticlesByTag($id);
        return $this->render("article/index.html.twig", [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/category/{id}", name="byCategory")
     */
    public function byCategory(ArticleService $articleService, $id)
    {   
        $articles = $articleService->getArticlesByCategory($id);
        return $this->render("article/index.html.twig", [
            'articles' => $articles,
        ]);
    }
}
