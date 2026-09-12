<?php
if(! function_exists('pelaksana')){
	function pelaksana($d){
		$pelaksana = '';
		if($d->dokter_anestesi!=''){
			$pelaksana = baca_dokter($d->dokter_anestesi);
		}elseif($d->dokter_anak!=''){
			$pelaksana = baca_dokter($d->dokter_anak);
		}elseif($d->dokter_operator1!=''){
			$pelaksana = baca_dokter($d->dokter_operator1);
		}elseif($d->dokter_operator2!=''){
			$pelaksana = baca_dokter($d->dokter_operator2);
		}elseif($d->perawat_ibs1!=''){
			$pelaksana = baca_dokter($d->perawat_ibs1);
		}elseif($d->perawat_ibs2!=''){
			$pelaksana = baca_dokter($d->perawat_ibs2);
		}elseif($d->perawat_ibs3!=''){
			$pelaksana = baca_dokter($d->perawat_ibs3);
		}elseif($d->perawat_ibs4!=''){
			$pelaksana = baca_dokter($d->perawat_ibs4);
		}elseif($d->bidan1!=''){
			$pelaksana = baca_dokter($d->bidan1);
		}elseif($d->bidan2!=''){
			$pelaksana = baca_dokter($d->bidan2);
		}elseif($d->dokter_pelaksana!=''){
			$pelaksana = baca_dokter($d->dokter_pelaksana);
		}elseif($d->poli_tipe=='L'){
			$pelaksana = baca_dokter($d->analis_lab);
		}elseif($d->poli_tipe=="R"){
			$pelaksana = baca_dokter($d->radiografer);
		}elseif($d->dokter_visit!=null){
			$pelaksana = baca_dokter($d->dokter_visit);
		}elseif($d->perawat!=''){
			$pelaksana = baca_dokter($d->perawat);
		}
		return $pelaksana;
	}
}

function mophp($pelayanan,$hargabeli){
	$margin = DB::table('margin_hargaobat')->find(1);
	$harga = 0;
	if($pelayanan=="I"){
		$harga = ($hargabeli + ($hargabeli * $margin->rawatinap / 100));
	}else{
		$harga = ($hargabeli + ($hargabeli * $margin->rawatjalan / 100));
	}
	return (int)$harga;
}

function getTotalTarif($reg,$tarif){
	//var_dump($tarif); exit;
	if(substr($reg->status_reg,0,1) == 'G' || substr($reg->status_reg,0,1) == 'J' || substr($reg->status_reg,0,1) == 'L' || substr($reg->status_reg,0,1) == 'R' || substr($reg->status_reg,0,1) == 'F' || substr($reg->status_reg,0,1) == 'A'){
		return $tarif->tarif_kelas_rj;
	}else{
		if($reg->kelas_id==1){
			return $tarif->tarif_kelas_vip;
		}elseif($reg->kelas_id==2){
			return $tarif->tarif_kelas_1;
		}elseif($reg->kelas_id==3){
			return $tarif->tarif_kelas_2;
		}elseif($reg->kelas_id==4){
			return $tarif->tarif_kelas_3;
		}else{
			return 0;
		}
	}
}

function pemeriksaanIrna($dokter_id, $jenis, $tga, $tgb, $carabayar){
	$pemeriksaan = DB::table('tarifs')->where('mapping_pemeriksaan', 'PM')->get();
	$pm = [];
	foreach ($pemeriksaan as $key => $d) {
		$pm[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach(DB::table('carabayars')->get(['id']) as $d){
		$bayar[] = '' . $d->id . '';
	}
	if($carabayar == '100') {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	}
	// $total = DB::table('folios')->where('dokter_id', $dokter_id)->where('jenis', $jenis)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	return $total;
}

//=========== KINERJA RAJAL / IGD ===============================================
function kinerjaDokter($dokter_id, $poli_id, $jenis, $tga, $tgb, $carabayar) {
	$kinerjaDokter = DB::table('tarifs')->whereIn('mapping_pemeriksaan', ['KS','PM'])->get();
	$kj = [];
	foreach ($kinerjaDokter as $key => $d) {
		$kj[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach(DB::table('carabayars')->get(['id']) as $d){
		$bayar[] = '' . $d->id . '';
	}
	if($carabayar == '100') {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->where('poli_id', $poli_id)->whereIn('tarif_id', $kj)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->where('poli_id', $poli_id)->whereIn('tarif_id', $kj)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	}
	return $total;     
}

function tindakan($dokter_id, $jenis, $tga, $tgb, $carabayar) {
	$tindakan = DB::table('tarifs')->where('mapping_pemeriksaan', 'TN')->get();
	$tn = [];
	foreach ($tindakan as $key => $d) {
		$tn[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach(DB::table('carabayars')->get(['id']) as $d){
		$bayar[] = '' . $d->id . '';
	}
	if($carabayar == '100') {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $tn)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $tn)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	return $total;
}

function konsultasi($dokter_id, $jenis, $tga, $tgb, $carabayar){
	$konsultasi = DB::table('tarifs')->where('mapping_pemeriksaan', 'KS')->get();
	$ks = [];
	foreach ($konsultasi as $key => $d) {
		$ks[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach(DB::table('carabayars')->get(['id']) as $d){
		$bayar[] = '' . $d->id . '';
	}
	if($carabayar == '100') {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $ks)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $ks)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	return $total;
}

function pemeriksaan($dokter_id, $jenis, $tga, $tgb, $carabayar){
	$pemeriksaan = DB::table('tarifs')->where('mapping_pemeriksaan', 'PM')->get();
	$pm = [];
	foreach ($pemeriksaan as $key => $d) {
		$pm[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach(DB::table('carabayars')->get(['id']) as $d){
		$bayar[] = '' . $d->id . '';
	}
	if($carabayar == '100') {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	
	return $total;
}
//================================== END KINERJA ===================================================
function cekVerif($registrasi_id, $tarif_id){
	$verif = DB::table('folios')->where('registrasi_id', $registrasi_id)->where('tarif_id',$tarif_id)->where('verif_kasa', 'Y')->count();
	return $verif;
}

//================================== UPDATE PULANG SEP =============================================
function updateTglPulangSEP($noSep, $tglPulang){
	$ID = config('app.sep_id');
	date_default_timezone_set('UTC');
	$t=time();
	$data = "$ID&$t";
	$secretKey = config('app.sep_key');
	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
	$request = '{
		"request": {    
			"t_sep": {
				"noSep":"'.$noSep.'",
				"tglPulang":"'.$tglPulang.'",
				"user":"'.Auth::user()->name.'"
			}
		}
	}';
			
	$completeurl = config('app.bpjs_url')."/Sep/updtglplg";

	$session = curl_init($completeurl);
	$arrheader =  array(
		'X-cons-id: '.$ID,
		'X-timestamp: '.$t,
		'X-signature: '.$signature,
		'Content-Type: application/x-www-form-urlencoded'
		);
	curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
	curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($session, CURLOPT_POSTFIELDS, $request);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($session);
	$sml = json_decode($response, true);
	$json = json_encode($sml);
	return $json;
}

if (!function_exists('tarif_mapping')) {
	function tarif_mapping($registrasi_id='', $mapping_id='')
	{
		if (!empty($registrasi_id && $mapping_id)) {
			return DB::table('folios')->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
			->where('folios.registrasi_id', $registrasi_id)
			->where('tarifs.mastermapping_id', $mapping_id)
			->sum('folios.total');
		} else {
			return NULL;
		}
	}
}

if (!function_exists('tanggal_eklaim')) {
	function tanggal_eklaim($tanggal='')
	{
		if (!empty($tanggal)) {
			$tg = explode(" ", $tanggal);
			$t = explode("-", $tg[0]);
			return $t[2].'/'.$t[1].'/'.$t[0];
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_carapulang')) {
	function baca_carapulang($id='')
	{
		if (!empty($id)) {
			return DB::table('kondisi_akhir_pasiens')->where('id', $id)->first()->namakondisi;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_diagnosa')) {
	function baca_diagnosa($kode='')
	{
		if (!empty($kode)) {
			return DB::table('icd10s')->where('nomor', $kode)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_prosedur')) {
	function baca_prosedur($kode='')
	{
		if (!empty($kode)) {
			return DB::table('icd9s')->where('nomor', $kode)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('no_rm')) {
	function no_rm($no_rm='')
	{
		$a = substr($no_rm, 0,2);
		$b = substr($no_rm, 2,2);
		$c = substr($no_rm, 4,2);
		return $a.'-'.$b.'-'.$c;
		//$d = substr($no_rm, 6,2);
		//return $a.'-'.$b.'-'.$c.'-'.$d;
	}
}

if (!function_exists('pasien_perpoli')) {
	function pasien_perpoli($tanggal, $poli_id) {
		return DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', $tanggal.'%')->where('poli_id', $poli_id)->count();
	}
}

if ( !function_exists('tanggal')) {
	function tanggal($created_at) {
		if(!empty($created_at)) {
			$tgl = explode(' ', $created_at);
			$t = explode('-', $tgl[0]);
			return $t[2].'-'.$t[1].'-'.$t[0].' '.$tgl[1];
		} else {
			return NULL;
		}
	}
}

if ( !function_exists('baca_icd10')) {
	function baca_icd10($nomor) {
		return DB::table('icd10s')->where('nomor', $nomor)->first()->nama;
	}
}

if ( !function_exists('cek_tindakan')) {
	function cek_tindakan($registrasi_id, $poli_id) {
		return DB::table('folios')->where('registrasi_id', $registrasi_id)->where('poli_id', $poli_id)->count();
	}
}

if( !function_exists('baca_bed')) {
	function baca_bed($id) {
		$bed = DB::table('beds')->where('id', $id)->first();
		if($bed==null){
			return 'Silahkan pilih bed lagi!';
		}else{
			return $bed->nama;
		}
	}
}

if( !function_exists('baca_pegawai')) {
	function baca_pegawai($id) {
		$pegawai_id = DB::table('users')->where('id', $id)->first()->pegawai_id;
		return baca_dokter($pegawai_id);
	}
}



if( !function_exists('baca_kelompok')) {
	function baca_kelompok($id) {
		return DB::table('kelompok_kelas')->where('id', $id)->first()->kelompok;
	}
}

if( !function_exists('baca_kamar')) {
	function baca_kamar($id) {
		if(!empty($id)){
			$kamar = DB::table('kamars')->where('id', $id)->first();
			if($kamar==null){
				return 'Silahkan pilih kamar lagi!';
			}else{
				return $kamar->nama;
			}
		} else {
			return NULL;
		}
		
	}
}

if( !function_exists('baca_kelas')) {
	function baca_kelas($id) {
		if(!empty($id)) {
			$kelas = DB::table('kelas')->where('id', $id)->first();
			if($kelas==null){
				return 'Silahkan pilih kelas lagi!';
			}else{
				return $kelas->nama;
			}
		} else {
			return NULL;
		}
		
	}
}

if (! function_exists('rupiah')) {
	function rupiah($angka) {
	    $d = str_replace('.', '', $angka);
			$r = str_replace(',', '', $d);
			return $r;
	}
}

if (! function_exists('valid_date')) {
	function valid_date($tgl_indo) {
		if($tgl_indo!=null){
			$t = explode('-', $tgl_indo);
			return $t[2].'-'.$t[1].'-'.$t[0];
		}else{
			return '';
		}
	}
}

if (! function_exists('cek_jenispasien')) {
	function cek_jenispasien($registrasi_id) {
	    return DB::table('registrasis')->where('id', '=', $registrasi_id)->first()->bayar;
	}
}

if(! function_exists('tgl_indo')){
	function tgl_indo($tgl)	{
		if($tgl!=null){
			$t = explode('-', $tgl);
			return $t[2].'-'.$t[1].'-'.$t[0];
		}else{
			return '';
		}
	}
}
if(! function_exists('baca_apoteker')){
	function baca_apoteker($id)	{
		return DB::table('apotekers')->where('id', $id)->first()->nama;
	}
}

if(! function_exists('baca_kelurahan')){
	function baca_kelurahan($id){ 
		if(!empty($id)){
			return DB::table('villages')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
		
	}
}

if(! function_exists('baca_kecamatan')){
	function baca_kecamatan($id){
		if(!empty($id)){
			return DB::table('districts')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}

	}
}

if(! function_exists('baca_kabupaten')){
	function baca_kabupaten($id){
		if(!empty($id)){
			return DB::table('regencies')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
		
	}
}

if(! function_exists('baca_propinsi')){
	function baca_propinsi($id){
		if(!empty($id)){
			return DB::table('provinces')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
		
	}
}

if (! function_exists('cek_hasil_lab')){
	function cek_hasil_lab($reg_id){
		return DB::table('hasillabs')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (! function_exists('total_tagihan')){
	function total_tagihan($reg_id,$lunas_true='N'){
		$total_folio 	= DB::table('folios')->where('registrasi_id', '=', $reg_id)->where('lunas', $lunas_true)->sum('total');		
		$hist_kamar = DB::table('histori_rawatinap')->where('registrasi_id', $reg_id)->orderBy('id', 'ASC')->get();
		$total_biaya_kamar = 0;
		$tarif_kamar = 0;
		if($hist_kamar!=null){
			foreach($hist_kamar as $key => $data){
				$date1=strtotime($data->tgl_masuk);
				if($data->tgl_keluar==null){
					$date2=time();
				}else{
					$date2=strtotime($data->tgl_keluar);
				}
				$diff	= $date2-$date1;
				$hari	= floor($diff / (60 * 60 * 24));
				$jam	= floor($diff / (60 * 60)) - ($hari * 24);
				$menit= floor($diff / (60)) - (((($hari * 24) + $jam) * 60));
				
				$tarif_kamar = $data->tarif;
				if($hari == 0 AND $data->tarif!=0){
					$tarif_kamar = $data->tarif;
				}elseif($hari >= 1 AND $data->tarif!=0){
					$tarif_kamar = $data->tarif * ($hari+1);
					if($jam < 2 AND $menit <= 59){
						$tarif_kamar = $tarif_kamar - $data->tarif;
					}
				}
				$total_biaya_kamar += $tarif_kamar;
			}
		}
		
		$total = $total_folio+$total_biaya_kamar;
		$tiga_angka = substr(($total_folio+$total_biaya_kamar),-3);
		if($tiga_angka < 500){
			$hsl_pembulatan = $total - $tiga_angka;
		}else{
			$tiga_angka = 1000 - $tiga_angka;
			$hsl_pembulatan = $total + $tiga_angka;
		}
		$hsl_pembulatan = $total;
		
		return $hsl_pembulatan;
	}
}

if (! function_exists('biaya_kamar')){
	function biaya_kamar($reg_id){
		$hist_kamar = DB::table('histori_rawatinap')->where('registrasi_id', $reg_id)->orderBy('id', 'ASC')->get();
		$total_biaya_kamar = 0;
		$tarif_kamar = 0;
		if($hist_kamar!=null){
			foreach($hist_kamar as $key => $data){
				$date1=strtotime($data->tgl_masuk);
				if($data->tgl_keluar==null){
					$date2=time();
				}else{
					$date2=strtotime($data->tgl_keluar);
				}
				$diff	= $date2-$date1;
				$hari	= floor($diff / (60 * 60 * 24));
				$jam	= floor($diff / (60 * 60)) - ($hari * 24);
				$menit= floor($diff / (60)) - (((($hari * 24) + $jam) * 60));
				
				$tarif_kamar = $data->tarif;
				if($hari == 0 AND $data->tarif!=0){
					$tarif_kamar = $data->tarif;
				}elseif($hari >= 1 AND $data->tarif!=0){
					$tarif_kamar = $data->tarif * ($hari+1);
					if($jam < 2 AND $menit <= 59){
						$tarif_kamar = $tarif_kamar - $data->tarif;
					}
				}
				$total_biaya_kamar += $tarif_kamar;
			}
		}		
		return $total_biaya_kamar;
	}
}

/* if(! function_exists('tarif_kamar')){
	function tarif_kamar($reg_id){
		$hist_kamar 	= DB::table('histori_rawatinap')->where('registrasi_id', $reg_id)->orderBy('id', 'ASC')->get();
		$tarif_kamar = 0;
		if($hist_kamar!=null){
			foreach($hist_kamar as $key => $data){
				$date1=date_create($data->tgl_masuk);
				if($data->tgl_keluar==""){
					$date2=date_create();
				}else{
					$date2=date_create($data->tgl_keluar);
				}
				$diff = date_diff( $date1, $date2 );
				if($diff->d == 0 AND $data->tarif!=0){
					$tarif_kamar = $data->tarif;
				}elseif($diff->d >= 1 AND ($diff->h > 2 OR $diff->i > 1 OR $diff->s > 1) && $data->tarif!=0){
					$tarif_kamar = $data->tarif * ($diff->d+1);
				}
			}
		}
		return $tarif_kamar;
	}
} */

if(! function_exists('baca_poli')){
	function baca_poli($id){
		if(!empty($id)){
			return DB::table('polis')->where('id', '=', $id)->first()->nama;
		}else{
			return '';
		}
	}
}

if(! function_exists('baca_dokter')){
	function baca_dokter($id)	{
		if($id!=null){
			$dokter = DB::table('pegawais')->where('id',$id)->first();
			if($dokter==null){
				return '';
			}else{
				return $dokter->nama;
			}
		} else {
			return null;
		}
	}
}

if(! function_exists('cek_registrasi')){
	function cek_registrasi($antrian_id, $no_loket){
		return DB::table('registrasis')->where('antrian_id', $antrian_id)->where('no_loket', $no_loket)->where('created_at', 'LIKE', date('Y-m-d').'%')->count();
	}
}

/* if(! function_exists('isBayi')){
	function isBayi($reg){
		$lahir = new DateTime($reg->pasien->tgllahir);
		$today = new DateTime();
		$umur = $today->diff($lahir);
		if($umur->y==0 AND $umur->m==0 AND ($umur->d==0 OR $umur->d==1)){
			return true;
		}else{
			return false;
		}
	}
} */

if(! function_exists('hitung_umur')){
	function hitung_umur($tgl, $bln=''){
		$lahir = new DateTime($tgl);
		$today = new DateTime();
		$umur = $today->diff($lahir);
		if(!empty($bln)){
			return $umur->y.' th '.$umur->m.' bl ';
		}else {
			return $umur->y.' th '.$umur->m.' bl '.$umur->d.' hr';
		}
	}
}
if(! function_exists('hitung_umur_tahun')){
	function hitung_umur_tahun($tgl, $bln=''){
		$lahir = new DateTime($tgl);
		$today = new DateTime();
		$umur = $today->diff($lahir);
		if(!empty($bln)){
			return $umur->y;
		}else {
			return $umur->y;
		}
	}
}

if(! function_exists('hitung_umur_rekammedik')){
	function hitung_umur_rekammedik($tgl,$tgl_periksa, $bln=''){
		$lahir = new DateTime($tgl);
		$today = new DateTime($tgl_periksa);
		$umur = $today->diff($lahir);
		if(!empty($bln)){
			return $umur->y.' th '.$umur->m.' bl ';
		}else {
			return $umur->y.' th '.$umur->m.' bl '.$umur->d.' hr';
		}
	}
}

if ( ! function_exists('baca_carabayar')){
	function baca_carabayar($id){
		if(!empty($id)){
			$kat = DB::table('carabayars')->where('id', '=', $id)->first();
			return $kat->carabayar;
		} else {
			return NULL;
		}
		
	}
}

if( ! function_exists('terbilang')){
	function terbilang($satuan)	{
		if(!empty($satuan)){
			$huruf = array("","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh",
			"Delapan","Sembilan","Sepuluh","Sebelas");
			if($satuan<12)
			return " ".$huruf[$satuan];
			elseif($satuan<20)
			return Terbilang($satuan-10)." Belas";
			elseif($satuan<100)
			return Terbilang($satuan/10)." Puluh".
			Terbilang($satuan%10);
			elseif($satuan<200)
			return " Seratus".Terbilang($satuan-100);
			elseif($satuan<1000)
			return Terbilang($satuan/100)." Ratus".
			Terbilang($satuan%100);
			elseif($satuan<2000)
			return "Seribu".Terbilang($satuan-1000);
			elseif($satuan<1000000)
			return Terbilang($satuan/1000)." Ribu".
			Terbilang($satuan%1000);
			elseif($satuan<1000000000)
			return Terbilang($satuan/1000000)." Juta".
			Terbilang($satuan%1000000);
			elseif($satuan<1000000000000)
			return Terbilang($satuan/1000000000)." Milyar".
			Terbilang($satuan%1000000000);
			elseif($satuan>=1000000000000)
			echo"Hasil terbilang tidak dapat di proses, nilai terlalu besar";
		}
	}
}

if( ! function_exists('tanggalkuitansi'))
{
	function tanggalkuitansi($x)
	{
	    if(!empty($x))
	    {
	        $y = explode('-', $x);
	        switch ($y[1])
	        {
	            case '1'  : $b = 'Januari'; break;
	            case '2'  : $b = 'Februari'; break;
	            case '3'  : $b = 'Maret'; break;
	            case '4'  : $b = 'April'; break;
	            case '5'  : $b = 'Mei'; break;
	            case '6'  : $b = 'Juni'; break;
	            case '7'  : $b = 'Juli'; break;
	            case '8'  : $b = 'Agustus'; break;
	            case '9'  : $b = 'September'; break;
	            case '10' : $b = 'Oktober'; break;
	            case '11' : $b = 'Nopember'; break;
	            case '12' : $b = 'Desember'; break;
	        }
	        $z = $y[0].' '.$b.' '.$y[2];
	        return $z;
	    }
	}
}

if(! function_exists('configrs'))
{
	function configrs()
	{
		$cf = DB::table('configs')->where('id', '=', 1)->first();
		return $cf;
	}
}

if(! function_exists('baca_kecamatan_bpjs')){
	function baca_kecamatan_bpjs($id){
		if(!empty($id)){
			return DB::table('districts')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}

if(! function_exists('baca_kabupaten_bpjs')){
	function baca_kabupaten_bpjs($id){
		if(!empty($id)){
			return DB::table('regencies')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}		
	}
}

if(! function_exists('instalasi')){
	function instalasi($code){
		if(!empty($code)){
			$instalasi = '';
			if($code == 'J') {
				$instalasi = 'RJ';
			} elseif ($code == 'G') {
				$instalasi = 'GD';
			} elseif ($code == 'I') {
				$instalasi = 'RI';
			}
			return $instalasi;
		} else {
			return "";
		}		
	}
}