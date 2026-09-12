//DATATABLE MASTER OBAT ========================================================
$(function() {
    $('#tableObat').DataTable({
        "language": {
          "url": "/json/obat.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: '/obat/getdata',
        columns: [
					{data: 'rownum', orderable: false, searchable: false},
					{data: 'kode', orderable: false},
					{data: 'nama', orderable: false},
					{data: 'satuan', orderable: false},
					/* {data: 'satuanbeli_id', orderable: false},
					{data: 'satuanjual_id', orderable: false}, */
					{data: 'jenis', orderable: false},
					{data: 'stok', sClass: 'text-center', orderable: false},										{data: 'harga_dasar', sClass: 'text-right', orderable: false},
					{data: 'harga_rj', sClass: 'text-right', orderable: false},
					{data: 'harga_ri', sClass: 'text-right', orderable: false}
					/* {data: 'hargajual_jkn', sClass: 'text-right', orderable: false},
					{data: 'hargabeli', sClass: 'text-right', orderable: false},
					{data: 'edit', orderable: false, searchable: false}, */
        ]
    });
});

//DATATABLE PASIEN =============================================================
$(function() {
    $('#pasienData').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/pasien/getdata-datatable',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'kelamin', orderable: false},
            {data: 'tgllahir', orderable: false},
            {data: 'alamat', orderable: false},
            {data: 'notlp', orderable: false},
            {data: 'edit', orderable: false, searchable: false},
        ]
    });
});

//DATATABLE JADWAL DOKTER===================================================================
$(function() {
    $('#jadwaldokter').DataTable({
        
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
       
        ajax: '/datatablejadwaldokter',
        columns: [
           
            {data: 'poli', orderable: false},
            {data: 'dokter', orderable: false},
            {data: 'hari', orderable: false},
            {data: 'jam', orderable: false, searchable: false},
            {data: 'edit', orderable: false, searchable: false},
        ]
    });
});

//DATATABLE MASTER DIET PASIEN =============================================================
$(function() {
    $('#datadiet').DataTable({
        
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
       
        ajax: 'getdata-diet',
        columns: [
           
            {data: 'kategori_menu', orderable: false},
            {data: 'nama_menu', orderable: false},
            {data: 'energi_kkal', orderable: false},
            {data: 'protein_gr', orderable: false, searchable: false},
            {data: 'edit', orderable: false, searchable: false},
        ]
    });
});
//DATATABLE REKAM MEDIS PASIEN =============================================================
$(function() {
    $('#rekammedispasien').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/pasien/getdata-datatable1',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'no_rm', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'kelamin', orderable: false},
            {data: 'tgllahir', orderable: false},
            {data: 'alamat', orderable: false},
            {data: 'edit', orderable: false, searchable: false},
        ]
    });
});


//DATATABLE ICD9 =============================================================
$(function() {
    $('#icd9View').DataTable({
        /* "language": {
            "url": "/json/pasien.datatable-language.json",
        }, */
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getICD9',
        columns: [
            {data: 'id', orderable: false},
            {data: 'nomor', orderable: false},
            {data: 'nama', orderable: false},
            {data: 'edit', orderable: false, searchable: false},
        ]
    });
});

//DATATABLE ICD10 =============================================================
$(function() {
    $('#ICD10Data').DataTable({
        /* "language": {
            "url": "/json/pasien.datatable-language.json",
        }, */
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getICD10',
        columns: [
            {data: 'id', orderable: false},
            {data: 'nomor', orderable: false},
            {data: 'nama', orderable: false},
            // {data: 'edit', orderable: false, searchable: false},
        ]
    });
});

//DATATABLE BRIDGING E-KLAIM RAWAT JALAN =======================================
$(function() {
    $('#eklaimRJ').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/frontoffice/e-claim/get_dataRawatJalan',
        columns: [
            {data: 'no_rm'},
            {data: 'pasien'},
            {data: 'poli'},
            {data: 'dokter'},
            {data: 'cara_bayar'},
            {data: 'no_sep'},
            {data: 'tgl_registrasi'},
            {data: 'proses', orderable: false, searchable: false},
        ]
    });
});
