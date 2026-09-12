$(document).ready(function() {
  //====== BRIDGING SEP ====================================================================================
    $('#no_sep').on('focus', function () {
      $('#modalBridging').modal('show');
      $('.modal-title').text('Bridging SEP');
      $('#hasilBridging').hide();
    });

    $('#tmbSEP').on('click', function () {
      $.ajax({
        url : "{{ url('bridging/cari') }}",
        type : "POST",
        data : $('#BridgingForm').serialize(),

      });
    });

  //SHOW RINCIAN PEMBAYARAN
  $(document).on('click', '#showRincian', function (e){
    var id = $(this).attr('data-id');
    $('#rincianBayar').modal('show');
    $('#dataRincianBayar').load("/kasir/rincian-bayar/"+id+" ");
  });
});
