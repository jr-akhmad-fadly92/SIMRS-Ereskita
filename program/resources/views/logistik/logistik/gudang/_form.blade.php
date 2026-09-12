
<div class="col-md-6">
    <div class="form-group{{ $errors->has('id_obat') ? ' has-error' : '' }}">
        {!! Form::label('id_obat', 'Kode Obat', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('id_obat', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('id_obat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nama_obat') ? ' has-error' : '' }}">
        {!! Form::label('nama_obat', 'Nama Obat', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('nama_obat', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nama_obat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('no_batch') ? ' has-error' : '' }}">
        {!! Form::label('no_batch', 'No Batch', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('no_batch', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('no_batch') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nomor_registrasi') ? ' has-error' : '' }}">
        {!! Form::label('nomor_registrasi', 'Nomor Registrasi', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('nomor_registrasi', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nomor_registrasi') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('barcode') ? ' has-error' : '' }}">
        {!! Form::label('barcode', 'Barcode', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('barcode', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('barcode') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kode_binfar') ? ' has-error' : '' }}">
        {!! Form::label('kode_binfar', 'Kode Binfar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('kode_binfar', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kode_binfar') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('satuan') ? ' has-error' : '' }}">
        {!! Form::label('satuan', 'Satuan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('satuan', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('satuan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('satuan_besar') ? ' has-error' : '' }}">
        {!! Form::label('satuan_besar', 'Satuan Besar', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('satuan_besar', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('satuan_besar') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('satuan_besar_unit') ? ' has-error' : '' }}">
        {!! Form::label('satuan_besar_unit', 'Satuan Besar Unit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('satuan_besar_unit', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('satuan_besar_unit') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('satuanjual') ? ' has-error' : '' }}">
        {!! Form::label('satuanjual', 'Satuan Jual', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('satuanjual', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('satuanjual') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('satuan_jual_unit') ? ' has-error' : '' }}">
        {!! Form::label('satuan_jual_unit', 'Satuan Jual Unit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('satuan_jual_unit', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('satuan_jual_unit') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('satuanbeli') ? ' has-error' : '' }}">
        {!! Form::label('satuanbeli', 'Satuan Beli', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('satuanbeli', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('satuanbeli') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('tipe_sediaan') ? ' has-error' : '' }}">
        {!! Form::label('tipe_sediaan', 'Tipe Sediaan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('tipe_sediaan', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('tipe_sediaan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('kemasan_unit') ? ' has-error' : '' }}">
        {!! Form::label('kemasan_unit', 'Kemasan unit', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('kemasan_unit', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kemasan_unit') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('gol_obat') ? ' has-error' : '' }}">
        {!! Form::label('gol_obat', 'Golongan Obat', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('gol_obat', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('gol_obat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('komposisi') ? ' has-error' : '' }}">
        {!! Form::label('komposisi', 'Komposisi', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('komposisi', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('komposisi') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('indikasi') ? ' has-error' : '' }}">
        {!! Form::label('indikasi', 'Indikasi', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('indikasi', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('indikasi') }}</small>
        </div>
    </div>
</div>
<div class="col-md-6">
<div class="form-group{{ $errors->has('dosis') ? ' has-error' : '' }}">
    {!! Form::label('dosis', 'Dosis', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('dosis', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('dosis') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('supplier') ? ' has-error' : '' }}">
    {!! Form::label('supplier', 'Supplier', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('supplier', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('supplier') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('stok') ? ' has-error' : '' }}">
    {!! Form::label('stok', 'Stok all', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('stok', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('stok') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('stokmax') ? ' has-error' : '' }}">
    {!! Form::label('stokmax', 'Stok Maximum', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('stokmax', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('stokmax') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('stokmin') ? ' has-error' : '' }}">
    {!! Form::label('stokmin', 'Stok Minimum', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('stokmin', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('stokmin') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('katagori_obat') ? ' has-error' : '' }}">
    {!! Form::label('katagori_obat', 'Kategori Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('katagori_obat', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('katagori_obat') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('jenis_obat') ? ' has-error' : '' }}">
    {!! Form::label('jenis_obat', 'Jenis Obat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('jenis_obat', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis_obat') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('kategori_objek') ? ' has-error' : '' }}">
    {!! Form::label('kategori_objek', 'Kategori Objeck', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('kategori_objek', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kategori_objek') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('hargajual') ? ' has-error' : '' }}">
    {!! Form::label('hargajual', 'Harga Jual', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('hargajual', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('hargajual') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('hargajual_jkn') ? ' has-error' : '' }}">
    {!! Form::label('hargajual_jkn', 'Harga Jual JKN', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('hargajual_jkn', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('hargajual_jkn') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('hargabeli') ? ' has-error' : '' }}">
    {!! Form::label('hargabeli', 'Harga Beli', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('hargabeli', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('hargabeli') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    {!! Form::label('status', 'Status', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('status', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('experied_date') ? ' has-error' : '' }}">
    {!! Form::label('experied_date', 'Experied Date', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('experied_date', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('experied_date') }}</small>
    </div>
</div><div class="form-group{{ $errors->has('Jenis') ? ' has-error' : '' }}">
    {!! Form::label('jenis', 'Jenis', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('jenis', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('aktif') ? ' has-error' : '' }}">
    {!! Form::label('aktif', 'Aktif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::text('aktif', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('aktif') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/master-obat-all') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
</div>