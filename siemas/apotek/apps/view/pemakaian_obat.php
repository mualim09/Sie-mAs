<?php $this->view_header_obat();?>
            <!-- Sub navigation -->
            <div id="subnav">
                <div class="container_12">
                    <div class="grid_12">
                        <ul style="margin-left: 50px;">

                            <li><a href="<?php echo $this->base_url?>index.php/obat/pemakaian_narkotik">Pemakaian Narkotik</a></li>
                            <li><a href="<?php echo $this->base_url?>index.php/obat/Kadaluarsa">Kadaluarsa</a></li>
                            <li id="current"><a href="<?php echo $this->base_url?>index.php/obat/pemakaian_obat">Pemakaian Obat</a></li>
                            <li><a href="<?php echo $this->base_url?>index.php/obat">Daftar Obat</a></li>

                        </ul>


                    </div><!-- End. .grid_12-->
                </div><!-- End. .container_12 -->
                <div style="clear: both;"></div>
            </div> <!-- End #subnav -->
        </div> <!-- End #header -->

		<div class="container_12">

                        <table>
					<tr>
						<td width="100px">
							<p align="right">Tanggal :</p>
						</td>
						<td width="120px">
							<input class="tanggal" type="text" maxlength="255" value="<?php echo $tanggal; ?>" name="tanggal">
						</td>
					</tr>

                                        <tr>
						<td>
							<p align="right">Unit Pelayanan :</p>
						</td>
						<td>
                                                    <select name="unit_layanan" style="width:150px;">
                                                        <option selected="selected">Pilih Unit</option>
                                                        <option value="umum">Umum</option>
                                                        <option value="gigi">Gigi</option>
                                                        <option value="kia">KIA</option>
                                                        <option value="lab">Laboratorium</option>
                                                        <option value="radiologi">Radiologi</option>
                                                        <option value="lainnya">Lainnya</option>
                                                    </select>
						</td>
					</tr>

                                        <tr>
						<td style="vertical-align: top">
							<p align="right">Keterangan :</p>
						</td>
						<td>
							<textarea name="keterangan" rows="3"></textarea>
						</td>
					</tr>
				</table>
		<div class="module" style="width: 473px ;">
                    <h2><span>Data Obat</span></h2>

                        <div class="module-table-body">
                            <table id="resep"><?php $n=1; ?>
                                 <thead>
					<tr>
						<th width="23%" class="align-center">
							id obat
						</th>
						<th width="50%" class="align-center">
							nama obat
						</th>
						<th width="27%" class="align-center">
							jumlah
						</th>
					</tr>
                                  </thead>

                                  <tbody>
                                      <?php for($n=1; $n<=50; $n++){ ?>
					<tr id="tr_<?php echo $n; ?>" <?php if($n > 6) echo 'style="display:none"' ?>>
                                            <td class="align-center"><input type="text" class="ido" name="id_obat[<?php echo $n; ?>]" maxlength="255" size="10"></td>
                                            <td class="align-center"><input type="text" class="autocomplete" name="nama_obat[<?php echo $n; ?>]" maxlength="255" size="30"></td>
                                            <td class="align-center"><input type="text" name="jumlah[<?php echo $n; ?>]" maxlength="255" size="10"></td>
                                        </tr>
                                      <?php } ?>
                                  </tbody>
                                  <tfoot>
					<tr>
                                            <td></td>
                                            <td class="align-center"><input class="submit-green" type="submit" value="Benar"</td>
                                            <td><a href="#" class="button" onclick="tabelFleksibel(); return false;">
                                                <span><img src="<?php echo $this->base_url?>template_files/plus-sma.gif" width="12" height="9" alt="" style="padding:10px 0 0 0;"/> Tambah data</span>
                                                </a></td>
					</tr>
                                  </tfoot>

				</table>
                            </div>
                    </div>


			</div> <!-- End .grid_12 -->


        <!-- Footer -->
        <div id="footer">
        	<div class="container_12">
            	<div class="grid_12">
                	<!-- You can change the copyright line for your own -->
                	<p>&copy; 2011. Siemas.</p>
        		</div>
            </div>
            <div style="clear:both;"></div>
        </div> <!-- End #footer -->
	</body>
        <script type="text/javascript">

            var x = 7;

            function tabelFleksibel() {

                $('#tr_' + x).fadeIn();
                x++;

            }

            var arrayObat = new Array();
                <?php if(isset($list_nama_obat)){ foreach ($list_nama_obat as $list) { ?>
                    arrayObat[<?php echo $list->id_obat; ?>] = "<?php echo $list->nbk_obat; ?>";
                <?php } } ?>

            $('.ido').keyup(function(){

              var id_obat = $(this).val();
              $(this).parent('td').next().find('input').val(arrayObat[id_obat]);

            })

            function aktifinAutokomplit() {
                $(".autocomplete").autocomplete({
                            source: [
                            <?php if(isset($list_nama_obat)){ foreach ($list_nama_obat as $list) { ?>
                            {"value":"<?php echo $list->nbk_obat; ?>","id":"<?php echo $list->id_obat; ?>"},
                            <?php } } ?>
                            {}
                            ],
                            select: function( event, ui ) {
                                    var nama_obat = ui.item.value;
                                    var id_obat = ui.item.id;

                                    $(this).parent('td').prev().find('input').val(id_obat);
                            },
                            delay: 0
                });
            }


        $(document).ready(function(){
            aktifinAutokomplit();
        });



        </script>
</html>
<!-- This document saved from http://www.xooom.pl/work/magicadmin/admin.html? -->

