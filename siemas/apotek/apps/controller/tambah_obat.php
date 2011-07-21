<?php defined('THISPATH') or die('Can\'t access directly!');

class Controller_tambah_obat extends Panada {
    
    public function __construct(){
        parent::__construct();
		$this->db = new library_db();
		$this->session = new Library_session();
                $this->obat = new Model_obat();
    }
    
    public function index(){
        
        $views['page_title']    = 'Tambah Obat - Apotek';
        $list = $this->obat->ambil();
        $views['list'] = $list;
        $views['jumlah'] = $this->obat->jumlah();
        $this->view_tambah_obat($views);
    }
}
