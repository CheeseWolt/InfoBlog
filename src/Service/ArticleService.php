<?php
namespace App\Service;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleService extends AbstractController
{
    /**
     * Retrieves all articles
     */
    public function getArticles()
    {
        return $this->getDoctrine()->getRepository(Article::class)->findAll();
    }

    /**
     * Retrive a article corresponding to a given id
     */
    public function getArticle(int $id)
    {
        return $this->getDoctrine()->getRepository(Article::class)->find($id);
    }

    /**
     * Retrive a article corresponding to a given tag id
     */
    public function getArticlesByTag(int $id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);
        return $tag->getArticles();
    }
    
    /**
     * Retrive a article corresponding to a given category id
     */
    public function getArticlesByCategory(int $id)
    {
        $tag = $this->getDoctrine()->getRepository(Category::class)->find($id);
        return $tag->getArticles();
    }
    
    /**
     * Add a article
     */
    public function postArticle(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $this->getArticles();
    }

    /**
     * Delete a article
     */
    public function deleteArticle($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        if(!$article){
            $this->createNotFoundException('Objet non trouvé');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->getArticles();
    }

    /**
     * Update a article
     */
    public function putArticle(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $this->getArticles();
    }
}
