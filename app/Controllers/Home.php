<?php
namespace App\Controllers;

use App\Models\Nice;
use CodeIgniter\View\Table;

class Home extends BaseController
{
    public function index(): string
    {
        $niceModel = new Nice();
        $data_nice = $niceModel->like('real_name', 'Paris - Nice')->findAll();

        $table = new Table();

        $template = [
            'table_open'         => '<table class="table table-bordered table-striped">', 
            'thead_open'         => '<thead>', 
            'thead_close'        => '</thead>', 
            'heading_row_start'  => '<tr>', 
            'heading_row_end'    => '</tr>', 
            'heading_cell_start' => '<th>', 
            'heading_cell_end'   => '</th>', 
            'tbody_open'         => '<tbody>', 
            'tbody_close'        => '</tbody>', 
            'row_start'          => '<tr>', 
            'row_end'            => '</tr>', 
            'cell_start'         => '<td>', 
            'cell_end'           => '</td>', 
            'row_alt_start'      => '<tr>', 
            'row_alt_end'        => '</tr>', 
            'cell_alt_start'     => '<td>', 
            'cell_alt_end'       => '</td>', 
            'table_close'        => '</table>' 
        ];
        
        $table->setTemplate($template);
        $table->setHeading('ID', 'Název závodu');

        foreach ($data_nice as $row) {
            $table->addRow([
                $row->id,
                anchor('zavod/' . $row->id, $row->real_name)
            ]);
        }

        $data = [
            'table_html' => $table->generate()
        ];

        return view('index', $data);
    }
}