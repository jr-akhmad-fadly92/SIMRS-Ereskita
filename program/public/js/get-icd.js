$(document).ready(function() {
  //Get ICD9
  $(document).on('click', '.icd9_1', function (e) {
    document.getElementById("icd9_1").value = $(this).attr('data-icd9');
    $('#ICD9').modal('hide');
  });
  
  $(document).on('click', '.icd9_2', function (e) {
    document.getElementById("icd9_2").value = $(this).attr('data-icd9');
    $('#ICD9').modal('hide');
  });
});
