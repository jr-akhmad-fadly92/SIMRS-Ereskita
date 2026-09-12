$(document).ready(function() {
    $('select[name="province_id"]').on('change', function() {
        var prop_id = $(this).val();
        if(prop_id) {
            $.ajax({
                url: '/pasien/getkota/'+prop_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="regency_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="regency_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[name="regency_id"]').hide();
        }
    });

    $('select[name="ruangan"]').on('change', function() {
        var prop_id = $(this).val();
        if(prop_id) {
            $.ajax({
                url: '/backoffice/getruangan/'+prop_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="lokasi"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="lokasi"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[name="lokasi"]').hide();
        }
    });

    $('select[name="bpjs_province_id"]').on('change', function() {
        var prop_id = $(this).val();
        if(prop_id) {
            $.ajax({
                url: '/sep/get-kota/'+prop_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="bpjs_regency_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="bpjs_regency_id"]').append('<option value="'+ value.kode +'">'+ value.nama +'</option>');
                    });
                }
            });
        }else{
           //$('select[name="bpjs_regency_id"]').hide();
        }
    });

    $('select[name="regency_id"]').on('change', function() {
        var reg_id = $(this).val();
        if(reg_id) {
            $.ajax({
                url: '/pasien/getdistrict/'+reg_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="district_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="district_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[name="district_id"]').empty();
        }
    });

    $('select[name="bpjs_regency_id"]').on('change', function() {
        var reg_id = $(this).val();
        if(reg_id) {
            $.ajax({
                url: '/sep/get-kecamatan/'+reg_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="bpjs_district_id"]').empty();
                    $.each(data, function(key, value) {
                        $('select[name="bpjs_district_id"]').append('<option value="'+ value.kode +'">'+ value.nama +'</option>');
                    });

                }
            });
        }else{
          //$('select[name="bpjs_district_id"]').empty();
        }
    });

    $('select[name="district_id"]').on('change', function() {
        var dis_id = $(this).val();
        if(dis_id) {
            $.ajax({
                url: '/pasien/getdesa/'+dis_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
									$('select[name="village_id"]').empty();
									$.each(data, function(key, value) {
											$('select[name="village_id"]').append('<option value="'+ key +'">'+ value +'</option>');
									});
                }
            });
        }else{
            $('select[name="village_id"]').empty();
        }
    });

    // Tampilkan perusahaan ====================================================
  $('#perusahaan').hide();
  $('select[name="bayar"]').on('change', function() {
      var id = $(this).val();
      if(id == '3'){
        $('#perusahaan').show();
      }else{
        $('#perusahaan').hide();
      }
  });


});
