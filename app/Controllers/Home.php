<?php
namespace App\Controllers;

use App\Models\Nice;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\View\Table;
use Psr\Log\LoggerInterface;
use Override;

class Home extends BaseController
{
    protected $niceModel;

    #[Override]
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->niceModel = new Nice();
    }
    public function index(): string
    {
        $data_nice = $this->niceModel->like('real_name', 'Paris - Nice')->orderBy('year', 'ASC')->findAll();

        $data = [
            'data_nice' => $data_nice
        ];

        return view('index', $data);
    }

    public function detail($id)
    {
        $data_nice = $this->niceModel->find($id);

        $data = [
            'data_nice' => $data_nice
        ];
        
        return view('detail', $data);
    }
}