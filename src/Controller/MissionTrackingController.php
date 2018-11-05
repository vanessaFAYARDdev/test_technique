<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Interim;
use App\Entity\MissionTracking;
use App\Entity\Status;
use App\Form\ContractFormType;
use App\Form\MissionTrackingFormType;
use App\Repository\ContractRepository;
use App\Repository\InterimRepository;
use App\Repository\MissionTrackingRepository;
use App\Repository\StatusRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MissionTrackingController extends AbstractController
{
    /**
     * @Route("/suivi-mission/{id}/add", name="missionTracking_add")
     */
    public function add(Request $request, ObjectManager $objectManager, ValidatorInterface $validator, ContractRepository $contractRepository, $id)
    {
        $missionTracking = new MissionTracking();

        $contract = $contractRepository->findById($id);
        $contract = $contract['0'];

        dump($contract);

        $errors = [];

        $contractId = $contract->getId();
        $interimId = $contract->getInterim()->getId();

        $form = $this->createFormBuilder($missionTracking)
            ->add('score', NumberType::class)
            ->add('contract', EntityType::class, array(
                'class' => Contract::class,
                'query_builder' => function (ContractRepository $er) use ($contractId) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id=:id')
                        ->setParameter('id', $contractId);
                },
                'choice_label' => 'id',
            ))
            ->add('interim', EntityType::class, array(
                'class' => Interim::class,
                'query_builder' => function (InterimRepository $er) use ($interimId) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id=:id')
                        ->setParameter('id', $interimId);
                },
                'choice_label' => 'id',
            ))
            ->add('status', EntityType::class, array(
                'class' => Status::class,
                'query_builder' => function (StatusRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id>3');
                },
                'choice_label' => 'name',
            ))
            ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && !$form->isValid()) {
            $errors =$validator->validate($missionTracking);
            $this->addFlash(
                'danger',
                "Le suivi de mission n'a pas été enregistré"
            );
        }
        if($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($missionTracking);
            $objectManager->flush();

            $this->addFlash(
                'success',
                "Le suivi de mission a bien été enregistré"
            );

            return $this->redirectToRoute('contract');
        }

        return $this->render('mission_tracking/form.html.twig', [
            'formTracking' => $form->createView(),
            'errors' => $errors,
            'contract' => $contract
        ]);
    }

    /**
     * @Route("/suivi-mission/{id}", name="missionTracking_show")
     */
    public function show(MissionTrackingRepository $missionTrackingRepository)
    {
        $missionTracking = $missionTrackingRepository->findAll();
        $missionTracking = $missionTracking['0'];


        return $this->render('mission_tracking/show.html.twig', [
            'missionTracking' => $missionTracking
        ]);
    }
}
