<?php

class Pasien extends Controller {

    function __construct() {
        parent::Controller();
    }

    function index() {
        $this->load->view('data_pasien');
    }

    function profil_pasien(){
        $this->load->view('profil_pasien');
    }

    function profil_kk(){
       $this->load->view('profil_kk');
    }
}