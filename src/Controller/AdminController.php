<?php

namespace App\Controller;

use App\Repository\EcardRepository;
use App\Repository\PaintingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[IsGranted("ROLE_ADMIN")]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ChartBuilderInterface $chartBuilder, EcardRepository $ecardRepository): Response
    {
        $topPaintings = $ecardRepository->createQueryBuilder('e')
            ->select('p.title, COUNT(e.id) as ecardCount')
            ->join('e.painting', 'p')
            ->groupBy('p.id')
            ->orderBy('ecardCount', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        $labels = [];
        $data = [];

        foreach ($topPaintings as $painting) {
            $labels[] = $painting['title'];
            $data[] = $painting['ecardCount'];
        }

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Les oeuvres les plus envoyées',
                    'backgroundColor' => 'rgb(115, 101, 138)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => empty($data) ? 10 : max($data),
                ],
            ],
            'responsive' => true,
        ]);

        return $this->render('admin/index.html.twig', [
            'top' => $topPaintings,
            'chart' => $chart
        ]);
    }
}
