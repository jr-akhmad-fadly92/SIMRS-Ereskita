<h3 style="margin:0;">
<div class='table-responsive' style="background:rgba(255,255,255,0.5);">
  <table class='table table-bordered table-condensed' style="font-size:18px; font-weight: bold;">
    <thead>
      <tr>
        <th class="text-center">NO</th>
        <th>KELAS</th>
        <th>KAMAR</th>
        <th class="text-center">KAPASITAS</th>
        <th class="text-center">TERISI</th>
		<th class="text-center">AKAN KOSONG</th>
        <th class="text-center">TERSEDIA</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kelas as $d)
				@php
					$kamar = Modules\Kamar\Entities\Kamar::where('kelas_id', $d->id)->get();
				@endphp
				@foreach ($kamar as $keym => $km)
					@php
						$total = Modules\Bed\Entities\Bed::where('kamar_id', $km->id)->count();
						$terisi = Modules\Bed\Entities\Bed::where('kamar_id', $km->id)->where('reserved', 'Y')->count();
						$akan_pulang = Modules\Bed\Entities\Bed::where('kamar_id', $km->id)->where('reserved', 'AP')->count();
						$tersedia = Modules\Bed\Entities\Bed::where('kamar_id', $km->id)->where('reserved', 'N')->count();
						$bg = '';
						if ($tersedia < 1) {
							$bg = '#F8BBD0';
						} elseif ($tersedia == 2) {
							$bg = '#FFE0B2';
						} elseif ($tersedia > 2) {
							$bg = '#B2EBF2';
						}
					@endphp
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						<td>{{ baca_kelas($d->id) }}</td>
						<td>{{ $km->nama }}</td>
						<td class="text-center">{{ $total }}</td>
						<td class="text-center">{{ $terisi }}</td>
						@if($akan_pulang==0)
						<td class="text-center">{{ $akan_pulang }}</td>
						@else
						<td class="text-center"style="background-color:#FFFF00;">{{ $akan_pulang }}</td>
						@endif
						<td class="text-center" style="background: {{ $bg }};">{{ $tersedia }}</td>
					</tr>
				@endforeach
      @endforeach
    </tbody>
  </table>
</div>
</h3>