<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Interim;
use App\Form\ContractFormType;
use App\Repository\ContractRepository;
use App\Repository\InterimRepository;
use Doctrine\Common\Persistence\ObjectManager;
use http\Env\Response;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContractController extends AbstractController
{
    /**
     * @Route("/", name="contract")
     */
    public function index(ContractRepository $contractRepository, InterimRepository $interimRepository)
    {
        $contracts = $contractRepository->findAll();
        $interims = $interimRepository->findAll();

        return $this->render('contract/index.html.twig', [
            'contracts' => $contracts,
            'interims' => $interims
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

        return $this->redirectToRoute('contract');
    }



}
