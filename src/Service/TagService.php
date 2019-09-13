<?php
namespace App\Service;


use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagService extends AbstractController
{
    /**
     * Retrieves all tags
     */
    public function getTags()
    {
        return $this->getDoctrine()->getRepository(Tag::class)->findAll();
    }

    /**
     * Retrive a tag corresponding to a given id
     */
    public function getTag(int $id)
    {
        return $this->getDoctrine()->getRepository(Tag::class)->find($id);
    }
    
    /**
     * Add a tag
     */
    public function postTag(Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();
        return $this->getTags();
    }

    /**
     * Delete a tag
     */
    public function deleteTag($id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);
        if(!$tag){
            $this->createNotFoundException('Objet non trouvé');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();
        return $this->getTags();
    }

    /**
     * Update a tag
     */
    public function putTag(Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();
        return $this->getTags();
    }
}
