@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Laporan Bulanan - {{ $namaBulan }}</h6>
            <div class="card-right d-flex align-items-center">
                <form method="GET" action="{{ route('laporan.index') }}" class="d-flex gap-2">
                    <select name="bulan" class="form-select" required>
                        @foreach($bulanNames as $num => $name)
                        <option value="{{ $num }}" {{ $num == $bulan ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select name="tahun" class="form-select" required>
                        @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++) <option value="{{ $i }}"
                            {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if(count($mingguGroups) > 0)
            <div class="table-responsive">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Nosis</th>
                            @foreach($mingguGroups as $mingguKe => $group)
                            <th>Minggu {{ $mingguKe }}</th>
                            @endforeach
                            <th>Total Nilai</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan as $item)
                        <tr class="{{ $item['memiliki_nilai'] ? '' : 'text-muted' }}">
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item['siswa']->nama }}</td>
                            <td>{{ $item['siswa']->nosis }}</td>
                            @foreach($mingguGroups as $mingguKe => $group)
                            <td>
                                @if(isset($item['nilai_mingguan'][$mingguKe]))
                                {{ number_format($item['nilai_mingguan'][$mingguKe]) }}
                                @if(isset($item['peleton'][$mingguKe]))
                                <br><small class="text-muted">({{ $item['peleton'][$mingguKe] }})</small>
                                @endif
                                @else
                                -
                                @endif
                            </td>
                            @endforeach
                            <td>
                                @if($item['memiliki_nilai'])
                                <strong>{{ number_format($item['total_nilai']) }}</strong>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($item['memiliki_nilai'])
                                {{ $item['rank'] }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                Tidak ada data penugasan untuk bulan {{ $namaBulan }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection