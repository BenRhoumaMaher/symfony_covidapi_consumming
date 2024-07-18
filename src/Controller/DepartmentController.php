<?php
/**
 * DepartmenetController.php
 *
 * This file contains the definition of the DepartmentController class, which handles
 * actions related to departments in the application.
 *
 * @category Controllers
 * @package  App\Controller\Department
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * DepartmentController
 *
 * @category Controllers
 *
 * @package App\Controller\Department
 *
 * @author Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */
class DepartmentController extends AbstractController
{
    #[Route('/department/{department}', name: 'department')]

    /**
     * Index Method to handle each department information
     *
     * @param string                $department     The department identifier.
     * @param CallApiService        $callApiService Service to call APIs.
     * @param ChartBuilderInterface $chartBuilder   Builder for charts.
     * @return Response HTTP response.
     */
    public function index(string $department, CallApiService $callApiService, ChartBuilderInterface $chartBuilder): Response
    {
        $label = [];
        $hospitalization = [];
        $icu = [];

        for ($i = 1; $i <= 7; $i++) {
            $date = new DateTime('20210107');
            $date->modify("-$i day");
            $datas = $callApiService->getAllDataByDate(
                $department,
                $date->format('Ymd')
            );

            $label[] = $datas['date'];
            $hospitalization[] = $datas['hospitalizedCurrently'];
            $icu[] = $datas['inIcuCumulative'];

        }


        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData(
            [
                'labels' => array_reverse($label),
                'datasets' => [
                    [
                        'label' => 'New Hospitalizations',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => array_reverse($hospitalization),
                    ],
                    [
                        'label' => 'New ICU Entries',
                        'borderColor' => 'rgb(46, 41, 78)',
                        'data' => array_reverse($icu),
                    ],
                ],
            ]
        );

        $chart->setOptions([/* ... */]);

        return $this->render(
            'department/index.html.twig',
            [
                'data' => $callApiService->getDepartmentData($department),
                'chart' => $chart,
            ]
        );
    }
}
