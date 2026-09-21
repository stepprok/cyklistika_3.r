<?php

namespace App\Controllers;

use App\Models\Nice;
use App\Models\Stage;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\View\Table;
use Psr\Log\LoggerInterface;
use Override;

class Home extends BaseController
{
    protected $niceModel;
    protected $stage;

    #[Override]
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->niceModel = new Nice();
        $this->stage = new Stage();
    }
    public function index()
    {
        $data_nice = $this->niceModel->select('race_year.*, SUM(fin_stage.distance) as total_distance')->like('race_year.real_name', 'Paris - Nice')->join('stage', 'race_year.id = stage.id_race_year', 'left')->groupBy('race_year.id')->orderBy('race_year.year', 'ASC')->findAll();

        $data = [
            'data_nice' => $data_nice
        ];

        return view('index', $data);
    }

    public function detail($raceYearId)
    {
        $raceYear = $this->niceModel->find($raceYearId);

        if (!$raceYear) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Ročník nebyl nalezen.');
        }

        $stages = $this->stage->select('fin_stage.*, fin_parcour_type.name as parcour_name')
            ->join('fin_parcour_type', 'fin_stage.parcour_type = fin_parcour_type.id', 'left')
            ->where('fin_stage.id_race_year', $raceYearId)
            ->orderBy('fin_stage.number', 'ASC')
            ->findAll();

        $data = [
            'data_nice' => $raceYear,
            'stages'    => $stages
        ];

        return view('detail', $data);
    }
}
