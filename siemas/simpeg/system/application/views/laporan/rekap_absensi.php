<?php $this->load->view('header'); ?>

<div class="belowribbon">
    <h1>
        Rekap absensi bulanan
    </h1>
</div>

<?php
$nama_bulan = array(
    "",
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember"
);

$tanggal_libur_bulan_ini = array(3,10,17,24,31);
$tanggal_libur_bp_pemda_bulan_ini = array(3,10,17,24,31,2,9,16,23,30);

?>

<div id="page">

    <div class="grid_6" style="width: 28%">
        <div class="module">
            <h2><span>Pilih bulan</span></h2>
            <div class="module-body">
                    Tahun&nbsp;&nbsp;&nbsp;
                    <select name="tahun" id="tahun">
                        <?php foreach($list_tahun as $t) : ?>
                        <option value='<?php echo $t['tahun']; ?>' <?php if($t['tahun'] == $tahun) echo "selected='selected'"; ?>><?php echo $t['tahun']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    Bulan&nbsp;&nbsp;&nbsp;
                    <select name="bulan" id="bulan">
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php if ($i == $bulan) echo 'selected="selected"'; ?>><?php echo $nama_bulan[$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                    <input type="button" value="Tampilkan" class="submit-green" style="font-size: 11px; height: 23px; overflow: hidden; vertical-align: top" onclick="window.location = 'index.php/absensi/rekap_absensi/' + $('#bulan').val() + '/' + $('#tahun').val()"/>
            </div>
        </div>
    </div>

    <div class="grid_6" style="width: 68%">
        <div class="module">
            <h2><span>Dalam grafik</span></h2>
            <div class="module-body">

            </div>
        </div>
    </div>


    <div style="margin: 0px 1%">
        <div class="module">
            <h2><span>Daftar absensi</span></h2>
            <div class="module-table-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <th colspan="<?php echo $jumlah_hari_bulan_ini + 2 ?>"><h4>Puskesmas Bogor Tengah</h4></th>
                        </tr>
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th style="width: 150px">Nama</th>
                            <?php for($j = 1; $j <= $jumlah_hari_bulan_ini; $j++) {

                                echo "<th style=\"width: 10px;\">$j</th>\n";

                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($absensi_pkm as $a) : ?>
                            <tr <?php if($i%2 == 0) echo 'class="even"' ?>>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo $a['nama']; ?></td>
                                <?php for($j = 1; $j <= $jumlah_hari_bulan_ini; $j++) {

                                    if(in_array($j, $tanggal_libur_pkm)) {

                                        echo "<td style='background-color: #eeeeee'>";
                                        echo "</td>\n";

                                    } else {

                                        echo "<td>";
                                        if ($a['hadir_' . $j] == '1')
                                            echo "<img alt='' src='template/tick-on-.gif'/>";
                                        echo "</td>\n";

                                    }

                                } ?>

                            </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>

                    <thead>
                        <tr>
                            <th colspan="<?php echo $jumlah_hari_bulan_ini + 2 ?>"><h4>BP Pemda</h4></th>
                        </tr>
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th style="width: 150px">Nama</th>
                            <?php for($j = 1; $j <= $jumlah_hari_bulan_ini; $j++) {

                                echo "<th style=\"width: 10px;\">$j</th>\n";

                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($absensi_bp as $a) : ?>
                            <tr <?php if($i%2 == 0) echo 'class="even"' ?>>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo $a['nama']; ?></td>
                                <?php for($j = 1; $j <= $jumlah_hari_bulan_ini; $j++) {

                                    if(in_array($j, $tanggal_libur_bp)) {

                                        echo "<td style='background-color: #eeeeee'>";
                                        echo "</td>\n";

                                    } else {

                                        echo "<td>";
                                        if ($a['hadir_' . $j] == '1')
                                            echo "<img alt='' src='template/tick-on-.gif'/>";
                                        echo "</td>\n";

                                    }

                                } ?>

                            </tr>
                        <?php $i++; endforeach; ?>
                    </tbody>


                </table>

            </div>
        </div>


    </div>
</div>

<?php $this->load->view('footer'); ?>