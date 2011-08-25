<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

class Antrian extends Controller {
    function Antrian() {
        parent::Controller();
        $this->load->model('antrian_m','antrian');
        $this->load->model("Rekam_medik_model", "remed");
        $this->load->model("data_pasien_model", "data");

    }

    function index() {

    }

    function antri() {
        $this->load->view('antrian_view');
    }

    function tabel_antri($id_poli) {
        $ant=$this->antrian->tabel_antrian_a($id_poli);
        $data['a']=$ant;
        $this->load->view('antrian_tabel_antri_view', $data);
    }

    function tabel_diperiksa($id_poli) {
        $ant=$this->antrian->tabel_antrian_sp($id_poli);
        $data['s']=$ant;
        $this->load->view('antrian_tabel_diperiksa_view', $data);
    }

    function tabel_tunda($id_poli) {
        $ant=$this->antrian->tabel_antrian_tunda($id_poli);
        $data['t']=$ant;
        $this->load->view('antrian_tabel_tunda_view', $data);
    }

     function tabel_selesai($id_poli) {
       
        $antrian=$this->antrian->tabel_antrian_selesai($id_poli);
        $data['sel']=$antrian;
        $this->load->view('antrian_selesai',$data);
    }

    function pasien_terisi($id_poli) {
        $antrian=$this->antrian->tabel_antrian_terisi($id_poli);
        $data['terisi']=$antrian;
        $this->load->view('antrian_terisi_view',$data);
    }
    
    function periksa($id_antrian) {
        $this->antrian->ubah_status($id_antrian, 'SEDANG DIPROSES');
    }

    function selesai($id_antrian) {
        $this->antrian->ubah_status($id_antrian, 'SELESAI');
    }

    function lewati($id_antrian) {
        $this->antrian->ubah_status($id_antrian, 'TUNDA');
    }

    function isi_remed_hari_ini($id_pasien = 0, $id_kunjungan = 0, $id_antrian = 0) {

        $remed = array();

        if($id_pasien != 0) {
            $data_pasien_remed=$this->remed->data_pasien_remed($id_pasien);    //model
            $remed['data_pasien']=$data_pasien_remed;
        } else {
            $remed['data_pasien']=null;
        }

        if($this->input->post('submit')) {

            // insert ke tabel remed_poli_gigi
            $data1 = array(
                    'tanggal_kunjungan_gigi' => date("Y-m-d"),
                    'anamnesis'      =>$this->input->post('n_anamnesis'),
                    'diagnosis'      =>$this->input->post('n_diagnosa'),
                    'keterangan'    =>$this->input->post('n_ket'),
                    'id_kunjungan'  => $id_kunjungan, //sementara
                    'id_pasien' => $id_pasien );
            $id_remed=$this->remed->insert_diagnosis($data1);
            $data1['diagnosa'] = $id_remed;
            // insert ke tabel_layanan
            $data2 = array(
                    'id_layanan'   =>$this->input->post('n_layanan'),
                    'id_remed_gigi'=>$id_remed,
            );
            $this->remed->insert_layanan($data2);


            $data3=array(
                    'id_penyakit' =>$this->input->post('n_penyakit'),
                    'id_remed_gigi'=>$id_remed
            );
            $this->remed->insert_penyakit($data3);

            // update ke TERISI
            $this->antrian->ubah_status($id_antrian, 'TERISI');

            redirect('antrian/isi_remed_hari_ini');

        }

        $data_pasien_remed=$this->remed->data_pasien_remed($id_pasien);    //model
        $remed['data_pasien']=$data_pasien_remed;

        $remed_pasien=$this->remed->get_remed_pasien_gigi($id_pasien);
        $remed['remed_gigi']=$remed_pasien;

        $remed_kia=$this->remed->get_remed_pasien_kia($id_pasien);
        $remed['remed_kia']=$remed_kia;

        $remed_umum=$this->remed->get_remed_pasien_umum($id_pasien);
        $remed['remed_umum']=$remed_umum;

        $remed_tbc=$this->remed->remed_poli_umum_tbc($id_pasien);
        $remed['tbc']=$remed_tbc;

        $remed_ispa=$this->remed->remed_poli_umum_ispa($id_pasien);
        $remed['ispa']=$remed_ispa;

        $remed_campak=$this->remed->remed_poli_umum_campak($id_pasien);
        $remed['campak']=$remed_campak;

        $remed_diare=$this->remed->remed_poli_umum_diare($id_pasien);
        $remed['diare']=$remed_diare;

        $data_lay=$this->remed->get_layanan($id_pasien);
        $remed['data_lay']=$data_lay;

        $lab=$this->remed->lab($id_pasien);
        $lab['lab']=$lab;

        $remed['id_pasien']=$id_pasien;

        $data_peny=$this->remed->get_penyakit($id_pasien);
        $remed['data_peny']=$data_peny;

        $this->load->view('isi_remed',$remed);
    }


    function pasien_hari_ini($id_poli) {
        $antrian=$this->antrian->tabel_antrian_terisi($id_poli);
        $data['t']=$antrian;

        $antrian=$this->antrian->tabel_antrian_selesai($id_poli);
        $data['selesai']=$antrian;
        $this->load->view('antrian_tabel_selesai_view',$data);
    }

    function data_pasien($id_pasien) {
        $data_pasien_remed=$this->remed->data_pasien_remed($id_pasien);    //model
        $remed['data_pasien']=$data_pasien_remed;
        $this->load->view('antrian_tabel_remed_view',$remed);
    }

    

}

?>
