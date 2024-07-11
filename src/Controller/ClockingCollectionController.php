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

        // initiate data to show the fields in the form
        $clocking = new Clocking();
        $clockingProject = new ClockingProject();
        $clocking->addClockingProject($clockingProject);

        $form = $this->createForm(CreateClockingOneUserType::class, $clocking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $clocking = $form->getData();
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

        // initiate data to show the fields in the form
        $clocking = new Clocking();
        $user = new User();
        $clocking->setClockingUser($user);

        //let to inject all projects in the form, because no access of projecys in colcking
        $projects = $entityManager->getRepository(Project::class)->findAll();

        $form = $this->createForm(CreateClockingManyUsersType::class, $clocking, ['projects' => $projects]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project = $form->get('project')->getData();
            $date = $form->get('date')->getData();

            //As the fields are mapped = false, they cannot be retreive
            // in the $form->getData(). So i get them in the $request
            $request = $request->request->all();
            $collections = $request['create_clocking_many_users']['clockingUser'];

            foreach($collections as $collection){
                $duration = (int)$collection['duration'];
                $user = $entityManager->getRepository(User::class)->find($collection['user']);
                $clocking = new Clocking();
                $clocking->setDate($date);
                $clocking->setClockingUser($user);
                $clockingProject = new ClockingProject();
                $clockingProject->setProject($project);
                $clockingProject->setDuration($duration);
                $clockingProject->setClocking($clocking);
                $entityManager->persist($clocking);
                $entityManager->persist($clockingProject);
            }

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
