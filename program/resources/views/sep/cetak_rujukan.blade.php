<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Rujukan</title>
    <link href="{{ asset('public/css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
      body{
        font-family: sans-serif;
        margin-left: auto;
      }
    </style>
  </head>
  <body>
    <table style="width:100%;">
      <tr>
        <td style="width:30%;">
					@if($reg->bayar==1)
						<img src="{{ asset('public/images/logo-bpjs.png') }}" style="width: 200px;">
					@else
						<img src="{{ asset('images/'.configrs()->logo) }}" style="height:40px;">
					@endif
        </td>
        <td class="text-left" style="width:35%;">
          SURAT RUJUKAN<br>
					<b>
					@if($reg->bayar==1)
						{{ $rujukan->response->rujukan->AsalRujukan->nama }}
					@else
						{{ config('app.nama') }}
					@endif
					</b>
        </td>
        <td class="text-left">
          <b>NO. {{$reg->pasien_no_dirujuk}}</b><br>
					@if($reg->bayar==1)
						{{ tgl_indo($rujukan->response->rujukan->tglRujukan) }}
					@else
						{{ date('d-m-Y') }}
					@endif
        </td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
		</table>
    <table style="width:100%;">
      <tr>
        <td>Kepada Yth</td>
        <td>: 
					@if($reg->bayar==1)
						{{$rujukan->response->rujukan->tujuanRujukan->nama}}
					@else
						{{ $rujukan->request->t_rujukan->ppkDirujuk }}
					@endif
				</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td class="text-center">== 
					@if($reg->pasien_tipe_dirujuk==0)
						Rujukan Penuh
					@elseif($reg->pasien_tipe_dirujuk==1)
						Rujukan Partial
					@elseif($reg->pasien_tipe_dirujuk==2)
						Rujuk Balik
					@endif
				 ==</td>
      </tr>
      <tr>
        <td colspan=2>Mohon Pemeriksaan dan Penanganan Lebih Lanjut:</td>
				<td class="text-center">
					@if(substr($reg->status_reg,0,1)=="I")
						Rawat Inap
					@else
						Rawat Jalan
					@endif
				</td>
      </tr>
			@if($reg->bayar==1)
      <tr>
        <td>No. Kartu</td>
        <td>: {{$rujukan->response->rujukan->peserta->noKartu}}</td>
        <td></td>
      </tr>
			@endif
      <tr>
        <td>Nama Peserta</td>
        <td>: 
				@if($reg->bayar==1)
					{{$rujukan->response->rujukan->peserta->nama}} ({{ $rujukan->response->rujukan->AsalRujukan->kelamin }})
				@else
					{{$reg->pasien->nama}} ({{$reg->pasien->kelamin}})
				@endif
				</td>
        <td></td>
      </tr>
      <tr>
        <td>Tgl Lahir</td>
        <td>: 					
					@if($reg->bayar==1)
						{{tgl_indo($rujukan->response->rujukan->peserta->tglLahir)}}
					@else
						{{ ($reg->pasien->tgllahir!=null) ? tgl_indo($reg->pasien->tgllahir) : '' }}
					@endif
				</td>
        <td></td>
      </tr>
      <tr>
        <td>Diagnosa</td>
        <td>: 
					@if($reg->bayar==1)
						{{$rujukan->response->rujukan->diagnosa->kode.' | '.$rujukan->response->rujukan->diagnosa->nama}}
					@else
						{{$rujukan->request->t_rujukan->diagRujukan}} | {{$rujukan->request->t_rujukan->diagRujukanText}}
					@endif
				</td>
        <td></td>
      </tr>
      <tr>
        <td>Keterangan</td>
        <td>: Mohon Pemeriksaan Lebih Lanjut. Terima Kasih</td>
        <td></td>
      </tr>
      <tr>
        <td colspan=3>Demikian atas bantuannya, diucapkan banyak terima kasih.</td>
      </tr>
      <tr>
        <td colspan=3 style="font-size:9px;">
					*Rujukan berlaku sampai dengan 
					@if($reg->bayar==1)
						{{tgl_indo(date('Y-m-d', strtotime("+3 months", strtotime($rujukan->response->rujukan->tglRujukan))))}}
					@else
						{{tgl_indo(date('Y-m-d', strtotime("+3 months", strtotime(date('d-m-Y')))))}}
					@endif
				</td>
      </tr>
      <tr>
        <td colspan=3 style="font-size:9px;">
					*Tanggal rencana berkunjung 
					@if($reg->bayar==1)
						{{tgl_indo($rujukan->response->rujukan->tglRujukan)}}
					@else
						{{date('d-m-Y')}}
					@endif
				</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td class="text-center">Mengetahui,<br><br><br><br>--------------------</td>
      </tr>
      <tr>
        <td colspan=3 style="font-size:8px;">Tgl. cetak {{date('d M Y H:i')}}</td>
      </tr>
    </table>
  </body>
</html>
