<?php
namespace App\Service;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryService extends AbstractController
{
    /**
     * Retrieves all categories
     */
    public function getCategories()
    {
        return $this->getDoctrine()->getRepository(Category::class)->findAll();
    }

    /**
     * Retrive a category corresponding to a given id
     */
    public function getCategory(int $id)
    {
        return $this->getDoctrine()->getRepository(Category::class)->find($id);
    }
    
    /**
     * Add a category
     */
    public function postCategory(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        return $this->getCategories();
    }

    /**
     * Delete a category
     */
    public function deleteCategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if(!$category){
            $this->createNotFoundException('Objet non trouvé');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->getCategories();
    }

    /**
     * Update a category
     */
    public function putCategory(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        return $this->getCategories();
    }


}
