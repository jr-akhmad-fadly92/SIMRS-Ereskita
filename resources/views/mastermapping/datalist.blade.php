KETERANGAN TOMBOL:
<br>
<button type="button" class="btn btn-info btn-flat btn-sm">
  <i class="fa fa-edit"></i>
</button> EDIT

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<button type="button" class="btn btn-primary btn-flat btn-sm">
  <i class="fa fa-map"></i>
</button> MAPPING

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<button type="button" class="btn btn-warning btn-flat btn-sm">
  <i class="fa fa-folder-open"></i>
</button> DETAIL
<br>
<br>

<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id="data" name="data">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Mapping</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($mapping as $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->mapping }}</td>
              <td>
                  <div class="btn-group">
                      <button type="button" onclick="editForm('{{ $d->id }}')" class="btn btn-info btn-flat btn-sm">
                          <i class="fa fa-edit"></i>
                      </button>

                      <a href="{{ url('mapping/'.$d->id) }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-map"></i> </a>
                      <button type="button" onclick="detailMapping('{{ $d->id }}')" class="btn btn-warning btn-flat btn-sm">
                          <i class="fa fa-folder-open"></i>
                      </button>

                  </div>

              </td>
            </tr>
        @endforeach

    </tbody>
  </table>
</div>

<div class="modal fade bd-example-modal-lg" id="modalDetailMapping" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
          <div class='table-responsive'>
            <table id='tableDetailMapping' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  
                  <th>Nama</th>
                  <th>kelas_vip</th>
                  <th>kelas_1</th>
                  <th>kelas_2</th>
                  <th>kelas_3</th>
                  <th>RJ</th>
                  
                </tr>
              </thead>
              <tbody class="tagihan"> </tbody>
              
            </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
