<?php
namespace App\Service;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserService extends AbstractController
{
    /**
     * Retrieves all users
     */
    public function getUsers()
    {
        return $this->getDoctrine()->getRepository(User::class)->findAll();
    }

    /**
     * Retrive a user corresponding to a given id
     */
    public function findUser(int $id)
    {
        return $this->getDoctrine()->getRepository(User::class)->find($id);
    }
    
    /**
     * Add a user
     */
    public function postUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->getUsers();
    }

    /**
     * Delete a user
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if(!$user){
            $this->createNotFoundException('Objet non trouvé');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->getUsers();
    }

    /**
     * Update a user
     */
    public function putUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->getUsers();
    }
}
