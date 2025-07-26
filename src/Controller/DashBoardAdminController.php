<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
final class DashBoardAdminController extends AbstractController
{
    #[Route('/dashboardAdmin', name: 'app_dashboard_admin')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('dash_board_admin/dashboardAdmin.html.twig', [
            'users' => $users,
        ]);
    }

     #[Route('/update/{id}', name: 'app_update_form')]
    public function update(Request $request , EntityManagerInterface $em, $id, UserRepository $repository ): Response
    {
        $crud = $repository->find($id);
        $form = $this -> createForm(RegistrationFormType::class, $crud);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $em->persist($crud);
                $em ->flush();
                $this->addFlash('notice', 'Modification réussie');
                return $this->redirectToRoute('app_home_page');
            }
        return $this->render('crud/update.html.twig', [
            'form' => $form ->createView(),
        ]);
    }
    
    #[Route('/delete/{id}', name:'app_delete_form')]
    
    function delete(Request $request, $id, UserRepository $repository, EntityManagerInterface $em)
    {
        $crud = $repository->find($id);
        $em->remove($crud);
        $em->flush();

        $this->addFlash('notice', 'Supression effectuée avec réussie');
        return $this->redirectToRoute('app_dashboard_admin');

    }



    
}
