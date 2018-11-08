<?php

namespace App\Controller;

use App\Command\ExportCvsCommand;
use App\Repository\ContractRepository;
use App\Repository\InterimRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistic")
     */
    public function form(Request $request, InterimRepository $interimRepository, ContractRepository $contractRepository, ExportCvsCommand $cvsCommand)
    {
        /* TODO Création formulaire 2 input date */

        $form = $this->createFormBuilder()
            ->add('startAt', DateType::class, array(
                'placeholder' => array(
                    'année' => 'Year',
                    'mois' => 'Month',
                    'jour' => 'Day'),
                'required'	    => true,
                'label'	    => 'Début'))
            ->add('endAt', DateType::class, array(
                'placeholder' => array(
                    'année' => 'Year',
                    'mois' => 'Month',
                    'jour' => 'Day'),
                'required'	    => true,
                'label'	    => 'Fin'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $cvsCommand->filterDb($request->request->get('form'), $contractRepository);
            return $this->render('statistic/index.html.twig', [
                'formStatistic' => $form->createView(),
                'request' => $request->request->get('form')
            ]);
        }

        return $this->render('statistic/index.html.twig', [
            'formStatistic' => $form->createView(),
            'request' => null
        ]);
    }



}
