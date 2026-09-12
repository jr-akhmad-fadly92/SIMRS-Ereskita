$(document).ready(function() {
  //REKAM MEDIS=================== ICD9 ==========================================

  $("input[name='icd91']").on('focus', function () {
    $("#dataICD9").DataTable().destroy();
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/1',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false},

        ]
    });

  });

  $(document).on('click', '.add1', function (e) {
    document.getElementById("icd91").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //2
  $("input[name='icd92']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/2',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add2', function (e) {
    document.getElementById("icd92").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //3
  $("input[name='icd93']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/3',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add3', function (e) {
    document.getElementById("icd93").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //4
  $("input[name='icd94']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/4',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add4', function (e) {
    document.getElementById("icd94").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //5
  $("input[name='icd95']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/5',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add5', function (e) {
    document.getElementById("icd95").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //6
  $("input[name='icd96']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/6',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add6', function (e) {
    document.getElementById("icd96").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //7
  $("input[name='icd97']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "/json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/7',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add7', function (e) {
    document.getElementById("icd97").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //8
  $("input[name='icd98']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/8',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add8', function (e) {
    document.getElementById("icd98").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //9
  $("input[name='icd99']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/9',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add9', function (e) {
    document.getElementById("icd99").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //10
  $("input[name='icd910']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/10',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add10', function (e) {
    document.getElementById("icd910").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //11
  $("input[name='icd911']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/11',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add11', function (e) {
    document.getElementById("icd911").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //12
  $("input[name='icd912']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/12',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add12', function (e) {
    document.getElementById("icd912").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //13
  $("input[name='icd913']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/13',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add13', function (e) {
    document.getElementById("icd913").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //14
  $("input[name='icd914']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/14',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add14', function (e) {
    document.getElementById("icd914").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //15
  $("input[name='icd915']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/15',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add15', function (e) {
    document.getElementById("icd915").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //16
  $("input[name='icd916']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/16',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add16', function (e) {
    document.getElementById("icd916").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //17
  $("input[name='icd917']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/17',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add17', function (e) {
    document.getElementById("icd917").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //18
  $("input[name='icd918']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/18',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add18', function (e) {
    document.getElementById("icd918").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //19
  $("input[name='icd919']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/19',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add19', function (e) {
    document.getElementById("icd919").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });

  //20
  $("input[name='icd920']").on('focus', function () {
    $("#dataICD9").DataTable().destroy()
    $("#icd9").modal('show');
    $('#dataICD9').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd9/getData/20',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.add20', function (e) {
    document.getElementById("icd920").value = $(this).attr('data-nomor');
    $('#icd9').modal('hide');
  });


  //REKAM MEDIS=================== ICD10 =========================================
  $("input[name='icd101']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/1',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih1', function (e) {
    document.getElementById("icd101").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //2
  $("input[name='icd102']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/2',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih2', function (e) {
    document.getElementById("icd102").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //3
  $("input[name='icd103']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/3',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih3', function (e) {
    document.getElementById("icd103").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //4
  $("input[name='icd104']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
       /*  "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/4',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih4', function (e) {
    document.getElementById("icd104").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //5
  $("input[name='icd105']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/5',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih5', function (e) {
    document.getElementById("icd105").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //6
  $("input[name='icd106']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/6',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih6', function (e) {
    document.getElementById("icd106").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //7
  $("input[name='icd107']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/7',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih7', function (e) {
    document.getElementById("icd107").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //8
  $("input[name='icd108']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
       /*  "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/8',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih8', function (e) {
    document.getElementById("icd108").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //9
  $("input[name='icd109']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/9',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih9', function (e) {
    document.getElementById("icd109").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //10
  $("input[name='icd1010']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/10',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih10', function (e) {
    document.getElementById("icd1010").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //11
  $("input[name='icd1011']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/11',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih11', function (e) {
    document.getElementById("icd1011").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //12
  $("input[name='icd1012']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/12',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih12', function (e) {
    document.getElementById("icd1012").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //13
  $("input[name='icd1013']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
       /*  "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/13',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih13', function (e) {
    document.getElementById("icd1013").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //14
  $("input[name='icd1014']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/14',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih14', function (e) {
    document.getElementById("icd1014").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //15
  $("input[name='icd1015']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/15',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih15', function (e) {
    document.getElementById("icd1015").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //16
  $("input[name='icd1016']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/16',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih16', function (e) {
    document.getElementById("icd1016").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //17
  $("input[name='icd1017']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/17',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih17', function (e) {
    document.getElementById("icd1017").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //18
  $("input[name='icd1018']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/18',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih18', function (e) {
    document.getElementById("icd1018").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //19
  $("input[name='icd1019']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/19',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih19', function (e) {
    document.getElementById("icd1019").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

  //20
  $("input[name='icd1020']").on('focus', function () {
    $("#dataICD10").DataTable().destroy()
    $("#icd10").modal('show');
    $('#dataICD10').DataTable({
        /* "language": {
            "url": "json/pasien.datatable-language.json",
        }, */

        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/icd10/getData/20',
        columns: [
            // {data: 'rownum', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'add', searchable: false}
        ]
    });
  });

  $(document).on('click', '.pilih20', function (e) {
    document.getElementById("icd1020").value = $(this).attr('data-nomor');
    $('#icd10').modal('hide');
  });

});
