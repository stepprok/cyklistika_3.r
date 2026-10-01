<?php

namespace App\Controllers;

use App\Models\Nice;
use App\Models\RaceModel;
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
    protected $raceModel;

    #[Override]
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->niceModel = new Nice();
        $this->stage = new Stage();
        $this->raceModel = new RaceModel();
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

        $stages = $this->stage->select('
            fin_stage.*, 
            fin_parcour_type.name as parcour_name,
            fin_rider.first_name as winner_first,
            fin_rider.last_name as winner_last,
            fin_rider.photo as winner_photo
        ')
            ->join('fin_parcour_type', 'fin_stage.parcour_type = fin_parcour_type.id', 'left')
            ->join('fin_result', 'fin_result.id_stage = fin_stage.id AND fin_result.rank = 1 AND fin_result.type_result = 1', 'left')
            ->join('fin_rider', 'fin_result.id_rider = fin_rider.id', 'left')
            ->where('fin_stage.id_race_year', $raceYearId)
            ->orderBy('fin_stage.number', 'ASC')
            ->findAll();

        $data = [
            'data_nice' => $raceYear,
            'stages'    => $stages
        ];

        return view('detail', $data);
    }

    public function stageResult($stageId, $typeResult)
    {
        // Načtení informací o etapě
        $stage = $this->stage->find($stageId);
        if (!$stage) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Etapa nebyla nalezena.');
        }

        // Načtení výsledků pro danou etapu a typ výsledku
        $db = \Config\Database::connect();
        $builder = $db->table('fin_result');

        $results = $builder->select('
            fin_result.*, 
            fin_rider.first_name, 
            fin_rider.last_name, 
            fin_rider.photo
        ')
            ->join('fin_rider', 'fin_result.id_rider = fin_rider.id', 'left')
            ->where('fin_result.id_stage', $stageId)
            ->where('fin_result.type_result', $typeResult)
            ->orderBy('fin_result.rank', 'ASC')
            ->get()
            ->getResult();

        $data = [
            'stage'      => $stage,
            'results'    => $results,
            'typeResult' => $typeResult
        ];

        return view('stage_result', $data);
    }

    public function createRaceYear()
    {
        // Výběr závodů přes RaceModel: pouze muži (M) a kategorie E
        $races = $this->niceModel
            ->where('sex', 'M')
            ->where('category', 'E')
            ->like('real_name', 'Paris - Nice')
            ->orderBy('real_name', 'ASC')
            ->findAll();

        $data = [
            'races' => $races
        ];

        return view('race_year_create', $data);
    }

    public function storeRaceYear()
    {
        // Validace vstupů
        $rules = [
            'real_name' => 'required|min_length[3]',
            'id_race'   => 'required|integer',
            'year'      => 'required|integer|exact_length[4]',
            'logo'      => 'uploaded[logo]|is_image[logo]|max_size[logo,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Zpracování loga
        $logoFile = $this->request->getFile('logo');
        $logoName = null;

        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            $logoName = $logoFile->getRandomName();
            $logoFile->move(FCPATH . 'assets/img/logos/', $logoName);
        }

        // Uložení nového ročníku přes $this->niceModel
        $this->niceModel->insert([
            'real_name' => $this->request->getPost('real_name'),
            'id_race'   => $this->request->getPost('id_race'),
            'year'      => $this->request->getPost('year'),
            'logo'      => $logoName
        ]);

        return redirect()->to(base_url())->with('success', 'Nový ročník závodu byl úspěšně přidán.');
    }
}
