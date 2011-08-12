<?php defined('THISPATH') or die('Can\'t access directly!');

class Controller_excel extends Panada {

    public function __construct(){
        parent::__construct();
		$this->db = new library_db();
		$this->session = new Library_session();
    }

    public function index(){
    }

    public function harian(){
        $tanggal_harian = $this->session->get('tanggal_harian');
        $this->session->remove('tanggal_harian');
        $tanggal = 'Tanggal '.$tanggal_harian;
        $data_harian = $this->session->get('data_harian');
        $this->session->remove('data_harian');


        if($data_harian){
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Siemas")
                                     ->setLastModifiedBy("085697977177")
                                     ->setTitle("Rekap Harian Obat")
                                     ->setSubject("Rekap Harian Obat");

        // Set Excel cell
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');

        // column width

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        // header

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:B2')->setCellValueByColumnAndRow(0, 2, "Kecamatan  :  Bogor Tengah");

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3')->setCellValueByColumnAndRow(0, 3, "Kota  :  Bogor");

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4')->setCellValueByColumnAndRow(0, 4, $tanggal);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2')->setCellValueByColumnAndRow(2, 2, "Resep  :");

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:F3')->setCellValueByColumnAndRow(2, 3, "Kasus  :");

        $objPHPExcel->getActiveSheet()->getStyle('A2:F4')->getFont()->setSize(10);

        $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 5, "NO")
                    ->setCellValueByColumnAndRow(1, 5, "Nama Obat")
                    ->setCellValueByColumnAndRow(2, 5, "Sat")
                    ->setCellValueByColumnAndRow(3, 5, "P.Awal")
                    ->setCellValueByColumnAndRow(4, 5, "Terpakai")
                    ->setCellValueByColumnAndRow(5, 5, "Sisa")
                    ->getStyle('A5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        for ($n = 0; $n <= 5; $n++)
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($n, 5)->getFont()->setBold(true);

        // the real data

        $i = 6;
        foreach($data_harian as $data) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, $data['id_obat']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $data['nbk_obat']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $data['satuan_obat']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $data['stok_awal']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $data['terpakai']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $data['stok_akhir']);
            $i++;}
    //    endforeach;

        // border
        $styleThinBlackBorderOutline = array(
                'borders' => array(
                        'outline' => array(
                                'style' => PHPEXCEL_Style_Border::BORDER_THIN,
                                'color' => array('argb' => 'FF000000'),
                        ),
                ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('A6:F' . ($i-1))->applyFromArray($styleThinBlackBorderOutline);

        $objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFill()->setFillType(PHPEXCEL_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDDDDD');

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Harian');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rekap_resep_harian_' . $tanggal_harian . '.xls"');

        $objWriter = PHPEXCEL_IOFactory::createWriter($objPHPExcel, "Excel5");
        $objWriter->save("php://output");
        }
    $this->redirect('index.php/laporan/harian/');
    }

    public function bulanan(){
        $bulan = $this->session->get('bulan_bulanan');
        $this->session->remove('bulan_bulanan');
        $tahun = $this->session->get('tahun_bulanan');
        $this->session->remove('tahun_bulanan');
        $data_bulanan = $this->session->get('data_bulanan');
        if($bulan==1){$namanya='Januari';}
            else if($bulan==2){$namanya='Februari';}
                else if($bulan==3){$namanya='Maret';}
                    else if($bulan==4){$namanya='April';}
                        else if($bulan==5){$namanya='Mei';}
                            else if($bulan==6){$namanya='Juni';}
        else if($bulan==7){$namanya='Juli';}
            else if($bulan==8){$namanya='Agustus';}
                else if($bulan==9){$namanya='September';}
                    else if($bulan==10){$namanya='Oktober';}
                        else if($bulan==11){$namanya='November';}
                            else {$namanya='Desember';}
        $date='Bulan '.$namanya.' '.$tahun;

        if($data_bulanan){
        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();

        // border
        $styleThinBlackBorderOutline = array(
                'borders' => array(
                        'outline' => array(
                                'style' => PHPEXCEL_Style_Border::BORDER_THIN,
                                'color' => array('argb' => 'FF000000'),
                        ),
                ),
        );

        $styleThinBlackBorderAll = array(
                'borders' => array(
                        'allborders' => array(
                                'style' => PHPEXCEL_Style_Border::BORDER_THIN,
                                'color' => array('argb' => 'FF000000'),
                        ),
                ),
        );

        // Align
        $styleAlignHorizontalCenter = array(
                'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
        );

        $styleAlignVerticalCenter = array(
                'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
        );

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Siemas")
                                     ->setLastModifiedBy("085697977177")
                                     ->setTitle("Rekap Harian Obat")
                                     ->setSubject("Rekap Harian Obat");
        $objPHPExcel->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                ->setFitToWidth(1)->setFitToHeight(0);

        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75)
                                                        ->setRight(0.4)
                                                        ->setLeft(0.4)
                                                        ->setBottom(0.75);


        // Set Cell excell
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(5.33);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(5);

        // header
        
        $objPHPExcel->getActiveSheet()->getStyle('A2:F4')->getFont()->setSize(8);

        $objPHPExcel->getActiveSheet()->getStyle('A5:AO273')->getFont()->setSize(9);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:B2')->setCellValueByColumnAndRow(0, 2, "Kecamatan  :  Bogor Tengah");

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3')->setCellValueByColumnAndRow(0, 3, "Kota  :  Bogor");

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4')->setCellValueByColumnAndRow(0, 4, $date);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:F2')->setCellValueByColumnAndRow(2, 2, "Resep  :");

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:F3')->setCellValueByColumnAndRow(2, 3, "Kasus  :");

        $objPHPExcel->getActiveSheet()
                    ->mergeCells('A5:A6')->setCellValueByColumnAndRow(0, 5, "NO")
                    ->mergeCells('B5:B6')->setCellValueByColumnAndRow(1, 5, "Nama Obat")
                    ->mergeCells('C5:C6')->setCellValueByColumnAndRow(2, 5, "Sat")
                    ->mergeCells('D5:F5')->setCellValueByColumnAndRow(3, 5, "Persediaan")
                    ->mergeCells('D5:F5')->setCellValueByColumnAndRow(3, 5, "Persediaan")
                    ->mergeCells('G5:AK5')->setCellValueByColumnAndRow(6, 5, "Jumlah Pemakaian Obat pada Tanggal")
                    ->mergeCells('AL5:AM5')->setCellValueByColumnAndRow(37, 5, "Pemakaian")
                    ->mergeCells('AN5:AN6')->setCellValueByColumnAndRow(39, 5, "Jumlah")
                    ->setCellValueByColumnAndRow(40, 5, "Sisa")
                    ->setCellValueByColumnAndRow(40, 6, "akhir")
                    ->setCellValueByColumnAndRow(3, 6, "P.Awal")
                    ->setCellValueByColumnAndRow(4, 6, "Penam.+")
                    ->setCellValueByColumnAndRow(5, 6, "Juml")
                    ->setCellValueByColumnAndRow(37, 6, "Boteng")
                    ->setCellValueByColumnAndRow(38, 6, "Pemda")
                    ->getStyle('A5:AO5')->applyFromArray($styleAlignHorizontalCenter);
        for($n=1;$n<=31;$n++){$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($n+5, 6, $n);}
        $objPHPExcel->getActiveSheet()->getStyle('G6:AK6')->applyFromArray($styleAlignHorizontalCenter);
        $objPHPExcel->getActiveSheet()->getStyle('AO5:AO6')->applyFromArray($styleAlignHorizontalCenter);
        $objPHPExcel->getActiveSheet()->getStyle('A5:C6')->applyFromArray($styleAlignVerticalCenter);
        $objPHPExcel->getActiveSheet()->getStyle('AN5:AN6')->applyFromArray($styleAlignVerticalCenter);
        $objPHPExcel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('C5:C6')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('D5:F5')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('G5:AK5')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('AL5:AM5')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('AN5:AN6')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('AO5:AO6')->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle('D6:AM6')->applyFromArray($styleThinBlackBorderAll);
        // the real data

        $i = 7;
        foreach($data_bulanan as $data) {
            $active1 = 'A'.$i.':'.'AO'.$i;
            $active2 = 'A'.$i;
            $active3 = 'D'.$i.':'.'AO'.$i;
            $formula1 = '=SUM('.'G'.$i.':AK'.$i.')';
            $formula2 = '=D'.$i.'+E'.$i;
            $formula3 = '=F'.$i.'-AN'.$i;
            $objPHPExcel->getActiveSheet()->getStyle($active1)->applyFromArray($styleThinBlackBorderAll);
            $objPHPExcel->getActiveSheet()->getStyle($active2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($active3)->applyFromArray($styleAlignHorizontalCenter);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, $data['id_obat']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $data['nbk_obat']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $data['satuan_obat']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $data['stok_awal']);
            if(isset($data['tambah'])){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $data['tambah']);}
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(37, $i, $formula1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(39, $i, $formula1);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $formula2);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(40, $i, $formula3);
            $x=5;
            $str=1;
            for($z=1;$z<=31;$z++){
                $t=$x+$z;
                $obatn='obat'.$z;
                if(isset($data[$obatn])){
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($t, $i, $data[$obatn]);}
                $str++;
            }
            $i++;}
    

 //       $objPHPExcel->getActiveSheet()->getStyle('A6:F' . ($i-1))->applyFromArray($styleThinBlackBorderOutline);

        $objPHPExcel->getActiveSheet()->getStyle('A5:AO6')->getFill()->setFillType(PHPEXCEL_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDDDDD');

        // Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('Harian');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rekap_resep_bulanan_' . $namanya . '-' . $tahun . '.xls"');

        $objWriter = PHPEXCEL_IOFactory::createWriter($objPHPExcel, "Excel5");
        $objWriter->save("php://output");
        }
    //$this->redirect('index.php/laporan/bulanan/');
    }
}