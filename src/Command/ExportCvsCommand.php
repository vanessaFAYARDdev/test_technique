<?php

namespace App\Command;


use App\Repository\ContractRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExportCvsCommand extends AbstractController
{
    private $data;

    public function filterDb($requestDate, ContractRepository $contractRepository)
    {
        $date1 = "{$requestDate['startAt']['year']}/{$requestDate['startAt']['month']}/{$requestDate['startAt']['day']}";
        $date2 = "{$requestDate['endAt']['year']}/{$requestDate['endAt']['month']}/{$requestDate['endAt']['day']}";

        $csvRepo = $contractRepository->findAllInTimePeriod($date1, $date2);

        dump($csvRepo);

        if(!$csvRepo) {
            $this->addFlash(
                'danger',
                "Il n'y a pas de contrat pour les dates saisies"
            );

            return $this->redirectToRoute('statistic');
        }

        return $this->data = $csvRepo;
    }


    public function exportCSV()
    {
        $data = $this->data;
        $response = new StreamedResponse();
        $response->setCallback(function() use($data) {
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, array('numero de contrat', 'date de debut', 'date de fin', 'nom', 'prenom', 'code postal', 'statut du contrat'), ';');

            foreach ($data as $input) {
                fputcsv(
                    $handle,
                    array(
                        $input['id'],
                        $input['start_at'],
                        $input['end_at'],
                        $input['last_name'],
                        $input['first_name'],
                        $input['zip_code'],
                        $input['name']),
                    ';');
            }

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export-data-contrats.csv"');

        return $response;
    }
}