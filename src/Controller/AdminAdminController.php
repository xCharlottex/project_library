<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdminController extends AbstractController {

    // je fais une route pour afficher la liste de mes utilisateurs
    // + le nom de la route
    /**
     * @Route("/admin/admins", name="admin_list_admins")
     */
    // je crée ma methode, definir la variable admin en utilisant une instance de la classe userRepository
    // findAll => recup l'ensemble des elements de ma table user
    public function listAdmins(UserRepository $userRepository){
        $admins = $userRepository->findAll();

        // je retourne la variable admins qui contient tout mes elements dans le fichier twig
        return $this->render('admin/admins.html.twig',[
            'admins' => $admins
        ]);
    }


    /**
     * @Route("/admin/create", name="admin_create_admin")
     */
    public function createAdmin(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager){

        // ma variable user contient une nouvelle entrée de la table user
        $user = new User();
        // definir le role Admin de cette nouvelle entrée avec le setter
        $user->setRoles(["ROLE_ADMIN"]);

        // stock dans une variable form le modele du formulaire
        $form = $this->createForm(UserType::class, $user);
        // recuperer les informations qui vont etre remplies dans le formulaire
        $form->handleRequest($request);

        // condition if, est ce que le formulaire a été soumis et valide
        if ($form->isSubmitted() && $form->isValid()){
            // je recup depuis le formulaire le MDP qui a été tapé
            $plainPassword = $form->get('password')->getData();
            // je le crypte a l'aide de l'instance de classe UserPasswordHasherInterface
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            // je defini le MDP de cette nouvelle entrée avec le MDP crypté
            $user->setPassword($hashedPassword);

            // inscription dans la BDD
            // persist enregistrement
            $entityManager->persist($user);
            // flush incription BDD physiquement
            $entityManager->flush();

            $this->addFlash('sucess', 'JP ici');

            return $this->redirectToRoute("admin_list_admins");
        }
        return $this->render('admin/insert_admin.html.twig', [
           'form' => $form->createView()
        ]);
    }

}