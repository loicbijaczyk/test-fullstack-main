<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Entity\Project;
use App\Entity\User;
use App\Form\CreateClockingManyUsersType;
use App\Form\CreateClockingOneUserType;
use App\Repository\ClockingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Clock\Clock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clockings')]
class ClockingCollectionController extends
    AbstractController
{

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/createOneUser', name: 'app_Clocking_One_User_create', methods: [
        'GET',
        'POST',
    ])]
    public function createClockingOneUser(
        EntityManagerInterface $entityManager,
        Request                $request,
    ) : Response {

        // $user = new User();
        $clocking = new Clocking();
        $clockingProject = new ClockingProject();
        $clocking->addClockingProject($clockingProject);
        // $user->addClocking($clocking);

        $form = $this->createForm(CreateClockingOneUserType::class, $clocking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $clocking = $form->getData();
            // $date = $form->get('date')->getData();
// dd($clocking);
// $userDatabase = $entityManager->getRepository(User::class)->findBy(['firstName'=> $user->getFirstName(), 'lastName'=> $user->getLastName()]);
// if($userDatabase == null) {
//     $userDatabase = $entityManager->getRepository(User::class)->find(1);
// }
// foreach ($user->getclockings() as $clocking){
// $clocking->setDate($date);
// $entityManager->persist($clocking);
// }

            $entityManager->persist($clocking);
            $entityManager->flush();

            return $this->redirectToRoute('app_Clocking_list');
        }

        $formView = $form->createView();

        return $this->render('app/Clocking/createOneUser.html.twig', [
            'form' => $formView,
        ]);
    }

/**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/createManyUsers', name: 'app_Clocking_Many_Users_create', methods: [
        'GET',
        'POST',
    ])]
    public function createClockingManyUsers(
        EntityManagerInterface $entityManager,
        Request                $request,
    ) : Response {


        // $clockingProject = new ClockingProject();
        $clocking = new Clocking();
        $projects = $entityManager->getRepository(Project::class)->findAll();
        // dd($projects);
        // $clockingProject->setClocking($clocking);

        $form = $this->createForm(CreateClockingManyUsersType::class, $clocking, ['projects' => $projects]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $clocking = $form->getData();

            $entityManager->persist($clocking);
            $entityManager->flush();

            return $this->redirectToRoute('app_Clocking_list');
        }

        $formView = $form->createView();

        return $this->render('app/Clocking/createManyUsers.html.twig', [
            'form' => $formView,
        ]);
    }


    /**
     * @param \App\Repository\ClockingRepository $clockingRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/', name: 'app_Clocking_list', methods: ['GET'])]
    public function listClockings(ClockingRepository $clockingRepository) : Response
    {
        $clockings = $clockingRepository->findAll();

        return $this->render('app/Clocking/list.html.twig', [
            'clockings' => $clockings,
        ]);
    }
}
