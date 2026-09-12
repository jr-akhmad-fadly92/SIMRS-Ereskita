@extends('master')
@section('header')
  <h1>Produsen / Supplier</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Produsen / Supplier&nbsp;
        <a href="{{ url('/backoffice/produsen-supplier/createprodusen') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>Id Produsen / Supplier</th>
                <th>Nama Produsen / Supplier</th>
                <th>Alamat Produsen / Supplier</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Website</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach($produsen as $p)
                <tr>  
                  <td>{{$p->id_produsen}}</td>
                  <td>{{$p->nama_produsen}}</td>
                  <td>{{$p->alamat_produsen}}</td>
                  <td>{{$p->telp}}</td>
                  <td>{{$p->email}}</td>
                  <td>{{$p->website}}</td>
                  <td><a href="{{ url('/backoffice/produsen-supplier/kode/'.$p->id_produsen.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                      <a href="{{ url('/backoffice/produsen-supplier/kode/'.$p->id_produsen.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
                <tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
