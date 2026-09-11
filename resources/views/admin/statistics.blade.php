@extends('admin.layout')
@section('title', 'Statistik pengunjung')
@section('content')
<div class="page-heading"><div><h1>Statistik pengunjung</h1><p class="intro">Aktivitas nyata di halaman frontend. Data mulai tercatat sejak fitur ini diaktifkan.</p></div><form><label class="sr-only" for="days">Rentang waktu</label><select id="days" name="days">@foreach([7,30,90] as $range)<option value="{{ $range }}" @selected($days === $range)>{{ $range }} hari terakhir</option>@endforeach</select><button class="secondary">Tampilkan</button></form></div>
<div class="metrics"><div><span>Tayangan halaman</span><strong>{{ number_format($views) }}</strong><small>Termasuk kunjungan berulang</small></div><div><span>Pengunjung harian</span><strong>{{ number_format($visitors) }}</strong><small>Jumlah estimasi unik setiap hari</small></div><div><span>Permintaan penawaran</span><strong>{{ number_format($leads) }}</strong><small>Formulir berhasil diterima</small></div></div>
<section class="panel"><h2>Tayangan per hari</h2><p class="hint">Periode {{ $timeline->first()['date'] }} – {{ $timeline->last()['date'] }} · WIB</p>
@if($views)
<div class="traffic-chart" role="img" aria-label="Grafik tayangan {{ $days }} hari. Detail tersedia di tabel di bawah.">@foreach($timeline as $point)<div title="{{ $point['date'] }}: {{ $point['views'] }} tayangan" style="height:{{ $point['views'] / max(1,$timeline->max('views')) * 100 }}%"></div>@endforeach</div>
<div class="chart-axis"><span>{{ $timeline->first()['date'] }}</span><span>{{ $timeline->last()['date'] }}</span></div>
@else<p class="empty-search">Belum ada kunjungan pengunjung pada periode ini. Kunjungan admin yang sedang login dan preview CMS tidak dihitung.</p>@endif
<details class="stats-details"><summary>Lihat data harian</summary><div class="table-scroll"><table><thead><tr><th>Tanggal</th><th>Tayangan</th><th>Unik harian</th></tr></thead><tbody>@foreach($timeline->reverse() as $point)<tr><td>{{ $point['date'] }}</td><td>{{ $point['views'] }}</td><td>{{ $point['visitors'] }}</td></tr>@endforeach</tbody></table></div></details>
</section>
<div class="stats-breakdown"><section class="panel"><h2>Sumber kunjungan</h2>@forelse($sources as $source)<div class="breakdown-row"><span>{{ $source->source }}</span><strong>{{ $source->total }}</strong></div>@empty<p class="hint">Sumber akan tercatat dari domain perujuk atau utm_source.</p>@endforelse</section><section class="panel"><h2>Perangkat</h2>@forelse($devices as $device)<div class="breakdown-row"><span>{{ $device->device }}</span><strong>{{ $device->total }}</strong></div>@empty<p class="hint">Belum ada data perangkat.</p>@endforelse</section></div>
<p class="hint">Pengunjung unik diestimasi dari IP dan browser yang di-hash per hari. IP mentah tidak disimpan. Pengunjung yang datang pada hari berbeda dihitung lagi; angka ini bukan jumlah orang unik lintas hari. Bot yang dikenali dikecualikan.</p>
@endsection
