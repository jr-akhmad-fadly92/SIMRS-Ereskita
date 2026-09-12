<?php 
     require_once("penghubung.inc.php");
     require_once($ROOT."lib/login.php");
     require_once($ROOT."lib/datamodel.php"); 
     require_once($ROOT."lib/tampilan.php");
     require_once($ROOT."lib/conf/database.php");
     require_once($ROOT."lib/currency.php");
     
           
     $view = new CView($_SERVER['PHP_SELF'],$_SERVER['QUERY_STRING']);
	   $dtaccess = new DataAccess();
	   $enc = new textEncrypt();     
     $auth = new CAuth();
	   $depNama = $auth->GetDepNama();
	   $depId = $auth->GetDepId();
     
     $host="localhost";
     $user=$enc->Decode(DB_USER);
     $password=$enc->Decode(DB_PASSWORD);
     $port="5432";
     $dbname = DB_NAME;
      
     $link = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password);
     
     $sqlcaribed1 = pg_query($link, "select sum(bed_terpakai) as pakai, sum(jml_bed) as total, sum(bed_tersisa) as sisa  
                    from klinik.klinik_rawat_inap_bor_kamar a left join klinik.klinik_kamar b on b.kamar_id=a.id_kamar 
                    where a.id_kelas ='1' ");
     $kelasvip = pg_fetch_assoc($sqlcaribed1);
     
     $sqlcaribed2 = pg_query($link, "select sum(bed_terpakai) as pakai, sum(jml_bed) as total, sum(bed_tersisa) as sisa  
                    from klinik.klinik_rawat_inap_bor_kamar a left join klinik.klinik_kamar b on b.kamar_id=a.id_kamar 
                    where a.id_kelas ='2' ");
     $kelas1 = pg_fetch_assoc($sqlcaribed2);
     
     $sqlcaribed3 = pg_query($link, "select sum(bed_terpakai) as pakai, sum(jml_bed) as total, sum(bed_tersisa) as sisa  
                    from klinik.klinik_rawat_inap_bor_kamar a left join klinik.klinik_kamar b on b.kamar_id=a.id_kamar 
                    where a.id_kelas ='3' ");
     $kelas2 = pg_fetch_assoc($sqlcaribed3);
     
     $sqlcaribed4 = pg_query($link, "select sum(bed_terpakai) as pakai, sum(jml_bed) as total, sum(bed_tersisa) as sisa  
                    from klinik.klinik_rawat_inap_bor_kamar a left join klinik.klinik_kamar b on b.kamar_id=a.id_kamar 
                    where a.id_kelas ='4' ");
     $kelas3 = pg_fetch_assoc($sqlcaribed4);
     
     $sqlcaribed5 = pg_query($link, "select sum(bed_terpakai) as pakai, sum(jml_bed) as total, sum(bed_tersisa) as sisa 
                    from klinik.klinik_rawat_inap_bor_kamar a left join klinik.klinik_kamar b on b.kamar_id=a.id_kamar 
                    where a.id_kelas ='5' ");
     $kelasicu = pg_fetch_assoc($sqlcaribed5);
     
     $sqlbed = pg_query($link, "select count(bed_id) as total from klinik.klinik_kamar_bed where bed_keterangan='n'");
     $bed = pg_fetch_assoc($sqlbed);
     
     $sqlbedPakai = pg_query($link, "select count(bed_id) as pakai from klinik.klinik_kamar_bed where bed_keterangan='n'
                    and bed_reserved='y'");
     $bedPakai = pg_fetch_assoc($sqlbedPakai);

      $xml='<xml>
              <data>
                <kode_ruang>0002</kode_ruang>
                <tipe_pasien>0012</tipe_pasien>
                <total_tt>'.$kelasvip["total"].'</total_tt>
                <terpakai>'.$kelasvip["pakai"].'</terpakai>
                <tgl_update>'.date('Y-m-d H:i:s').'</tgl_update>
              </data>
              <data>
                <kode_ruang>0003</kode_ruang>
                <tipe_pasien>0012</tipe_pasien>
                <total_tt>'.$kelas1["total"].'</total_tt>
                <terpakai>'.$kelas1["pakai"].'</terpakai>
                <tgl_update>'.date('Y-m-d H:i:s').'</tgl_update>
              </data>
              <data>
                <kode_ruang>0004</kode_ruang>
                <tipe_pasien>0012</tipe_pasien>
                <total_tt>'.$kelas2["total"].'</total_tt>
                <terpakai>'.$kelas2["pakai"].'</terpakai>
                <tgl_update>'.date('Y-m-d H:i:s').'</tgl_update>
              </data>
              <data>
                <kode_ruang>0005</kode_ruang>
                <tipe_pasien>0012</tipe_pasien>
                <total_tt>'.$kelas3["total"].'</total_tt>
                <terpakai>'.$kelas3["pakai"].'</terpakai>
                <tgl_update>'.date('Y-m-d H:i:s').'</tgl_update>
              </data>
              <data>
                <kode_ruang>0006</kode_ruang>
                <tipe_pasien>0012</tipe_pasien>
                <total_tt>'.$kelasicu["total"].'</total_tt>
                <terpakai>'.$kelasicu["pakai"].'</terpakai>
                <tgl_update>'.date('Y-m-d H:i:s').'</tgl_update>

              </data>
            </xml>';
     // $xmls=$xml->asXML();
      //echo $xml; //die();
      $url= "http://sirs.buk.depkes.go.id/sirsservice/ranap";
	    $user="123456_asd";
      $pass = "827ccb0eea8a706c4c34a16891f84e7b_asd";
      $process = curl_init($url);
      $arrheader =  array(
			'X-rs-id: '.$user,
			'X-pass: '.$pass,
			'Content-Type: text/xml'
			);
      curl_setopt($process, CURLOPT_HTTPHEADER,$arrheader);
      curl_setopt($process, CURLOPT_POST, true);
      curl_setopt($process, CURLOPT_POSTFIELDS, $xml);
      curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
      $return = curl_exec($process);
      //curl_close($process);
      $respronse = json_decode($return, true);
      print_r($return);
      
?>