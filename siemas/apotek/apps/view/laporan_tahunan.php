<?php $this->view_header_laporan();?>
            <!-- Sub navigation -->
            <div id="subnav">
                <div class="container_12">
                    <div class="grid_12">
                        <ul>
							
							<li><a href="<?php echo $this->base_url?>index.php/laporan/pemakaian">Pemakaian Obat</a></li>
							<li><a href="<?php echo $this->base_url?>index.php/laporan/pemasukan">Pemasukan Obat</a></li>
							<li id="current"><a href="<?php echo $this->base_url?>index.php/laporan/tahunan">Tahunan</a></li>
							<li><a href="<?php echo $this->base_url?>index.php/laporan/bulanan">Bulanan</a></li>
							<li ><a href="<?php echo $this->base_url?>index.php/laporan/harian">Harian</a></li>
						</ul>
							
							              
                    </div><!-- End. .grid_12-->
                </div><!-- End. .container_12 -->
                <div style="clear: both;"></div>
            </div> <!-- End #subnav -->
        </div> <!-- End #header -->
        
		<div class="container_12">

                    <form method="post"
                                              onsubmit="if(document.getElementById('tahun').value != 'Pilih tahun')
                                                            return confirm('Apakah anda yakin ingin membuat laporan tahun ' + document.getElementById('tahun').value + '?');
                                                            else return false;">
                    <table>
					<tr>
						<td width="120px">
                                                    <select name="tahun" id="tahun" style="width:100px;">
                                                        <option selected="selected">Pilih tahun</option>
                                                        <option value="2011">2011</option>
                                                        <option value="2012">2012</option>
                                                        <option value="2013">2013</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2018">2018</option>
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                    </select>
						</td>
						<td>
							<input type="submit" class="submit-green" value="PILIH">
						</td>
					</tr>
					</table>


					</form>
					

                        <div style="clear: both;"></div>
						
			</div> <!-- End .grid_12 -->
           
           
        <!-- Footer -->
        <div id="footer">
        	<div class="container_12">
            	<div class="grid_12">
                	<!-- You can change the copyright line for your own -->
                	<p>&copy; 2009. Magic Admin.</p>
        		</div>
            </div>
            <div style="clear:both;"></div>
        </div> <!-- End #footer -->
	</body>
</html>
<!-- This document saved from http://www.xooom.pl/work/magicadmin/admin.html? -->
