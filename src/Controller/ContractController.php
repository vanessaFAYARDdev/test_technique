<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractFormType;
use App\Repository\ContractRepository;
use App\Repository\InterimRepository;
use App\Repository\MissionTrackingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContractController extends AbstractController
{
    /**
     * @Route("/", name="contract")
     */
    public function index(ContractRepository $contractRepository, InterimRepository $interimRepository, MissionTrackingRepository $missionTrackingRepository)
    {
        $contracts = $contractRepository->findAll();
        $interims = $interimRepository->findAll();
        $missionTracking = $missionTrackingRepository->findAll();

        return $this->render('contract/index.html.twig', [
            'contracts' => $contracts,
            'interims' => $interims,
            'missionTracking' => $missionTracking
        ]);
    }

    /**
     * @Route("/ajouter", name="contract_add")
     * @Route("/{{id}}/modifier", name="contract_edit")
     */
    public function form(Request $request, ObjectManager $objectManager, ValidatorInterface $validator, Contract $contract = null)
    {
        if(!$contract) {
            $contract = new Contract();
        }

        $errors = [];

        $form = $this->createForm(ContractFormType::class, $contract);
        $form->handleRequest($request);

        if($form->isSubmitted() && !$form->isValid()) {
            $errors =$validator->validate($contract);
        }
        if($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($contract);
            $objectManager->flush();

            $this->addFlash(
                'success',
                "Le contrat <strong>{$contract->getId()}</strong> a bien été enregistré"
            );

            return $this->redirectToRoute('contract');
        }

        return $this->render('contract/form.html.twig', [
            'formContract' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/{{id}}/supprimer", name="contract_delete")
     *
     */
    public function delete(Request $request, ObjectManager $objectManager, Contract $contract) {
        //$article = $this->getDoctrine()->getRepository(Contract::class)->find($id);
        //$entityManager = $this->getDoctrine()->getManager();
        $objectManager->remove($contract);
        $objectManager->flush();

        $this->addFlash(
            'success',
            "Le contrat <strong>{$contract->getId()}</strong> a bien été supprimé"
        );

        return $this->redirectToRoute('contract');
    }





}
