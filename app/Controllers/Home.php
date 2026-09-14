<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Nice;
use Override;

class Home extends BaseController
{
    protected $nice;

    #[Override]
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->nice = new Nice();
    }

    public function index(): string
    {
        $data_nice = $this->nice->like('default_name', 'Paris-Nice')->findAll();

        $data = [
            "data_nice" => $data_nice
        ];

        return view('index', $data);
    }
}