<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CETAK SEP </title>
    <link href="{{ asset('public/css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
      body{
        font-family: sans-serif;
        margin-left: auto;
      }
    </style>
  </head>
  <body>
    <table style="width: 100%;">
      <tr>
        <td style="width:60%;">
          <img src="{{ asset('public/images/logo-bpjs.png') }}"style="width: 200px;">
        </td>
        <td class="text-center" style="width:50%;">
          SURAT ELIGIBILITAS PESERTA <br>
          {{ config('app.name') }}
        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table>
            <tr>
              <td>No. SEP</td><td>: {{ $reg_sep->noSep }}</td>
            </tr>
            <tr>
              <td>Tgl. SEP</td><td>: {{ $reg_sep->tglSep }}</td>
            </tr>
            <tr>
              <td>No. Kartu</td><td>: {{ $reg_sep->peserta->noKartu }}</td>
            </tr>
            <tr>
              <td>Nama Peserta</td><td>: {{ $reg_sep->peserta->nama }}</td>
            </tr>
            <tr>
              <td>Tgl Lahir</td><td>: {{ tgl_indo($reg_sep->peserta->tglLahir) }}</td>
            </tr>
            <tr>
              <td>Jenis Kelamin</td><td>: {{ $reg_sep->peserta->kelamin }}</td>
            </tr>
            <tr>
              <td>Poli Tujuan</td><td>: {{ $reg_sep->poli }}</td>
            </tr>
            <tr>
              <td>Asal Faskes Tk. 1</td><td>: {{ $reg->nama_ppk_rujukan }}</td>
            </tr>
            <tr>
              <td>Diagnosa Awal</td><td>: {{ $reg_sep->diagnosa }}</td>
            </tr>
            <tr>
              <td>Catatan</td><td>:  &nbsp; </td>
            </tr>
            <tr>
              <td colspan="2">
                <p class="text-left small" style="font-size: 60%;">
                  <i>
                  * Saya Menyetujui BPJS Kesehatan menggunakan informasi medis Pasien jika diperlukan. <br>
                  * SEP bukan sebagai bukti penjaminan peserta.
                Cetakan Ke 1
                </i>
              </p>
              </td>
            </tr>
          </table>
        </td>
        <td>
          <table>
            <tr>
              <td>No. RM</td> <td>: <b>{{ $reg_sep->peserta->noMr }}</b></td>
            </tr>
            <tr>
              <td>Peserta</td> <td>: {{ $reg_sep->peserta->jnsPeserta }}</td>
            </tr>
            <tr>
              <td>COB</td> <td>: </td>
            </tr>
            <tr>
              <td>Jenis Rawat</td> <td>: {{ $reg_sep->jnsPelayanan }}</td>
            </tr>
            <tr>
              <td>Kelas Rawat</td> <td>: {{ $reg_sep->kelasRawat }}</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
              <td class="text-center">
              </td>
              <td class="text-center">
                Pasien/Keluarga Pasien <br><br><br><br>_____________________
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
