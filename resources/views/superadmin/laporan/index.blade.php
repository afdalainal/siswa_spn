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
            <div class="alert alert-info text-center">
                Tidak ada data laporan untuk ditampilkan pada bulan ini
            </div>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Rank Siswa - {{ $namaBulan }}</h6>
        </div>
        <div class="card-body">
            <div class="mb-5">
                <div id="rankChart"></div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the data passed from controller
    const chartData = @json($chartData);

    // Ambil data semua siswa (sudah diurutkan dari controller berdasarkan rank)
    const allStudents = chartData.rankData;
    const siswaWithRank = allStudents.filter(student => student.rank !== null);

    // Jika tidak ada siswa dengan rank, tampilkan pesan
    if (siswaWithRank.length === 0) {
        document.getElementById('rankChart').innerHTML =
            '<div class="alert alert-info text-center">Tidak ada data rank untuk ditampilkan pada bulan ini</div>';
        return;
    }

    // Prepare data untuk chart (semua siswa)
    const categories = allStudents.map(student => student.name);
    const rankValues = allStudents.map(student => student.rank);

    // Dapatkan rank tertinggi untuk menentukan maksimum Y-axis
    const validRanks = rankValues.filter(rank => rank !== null);
    const maxRank = validRanks.length > 0 ? Math.max(...validRanks) : 1;

    // Konfigurasi ApexCharts Line Chart
    const rankChartOptions = {
        series: [{
            name: 'Peringkat',
            data: rankValues
        }],
        chart: {
            type: 'line',
            height: 450,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        markers: {
            size: function(val, opts) {
                // Siswa tanpa rank tidak ditampilkan markernya
                return rankValues[opts.dataPointIndex] !== null ? 6 : 0;
            },
            strokeWidth: 2,
            strokeColors: '#fff',
            fillOpacity: 1,
            hover: {
                size: 8
            }
        },
        xaxis: {
            categories: categories,
            title: {
                text: 'Siswa',
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            labels: {
                rotate: -45,
                style: {
                    fontSize: '11px'
                },
                trim: true,
                maxHeight: 120
            }
        },
        yaxis: {
            title: {
                text: 'Peringkat',
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            reversed: true, // Rank 1 di atas, rank terburuk di bawah
            min: 1,
            max: maxRank,
            forceNiceScale: true,
            labels: {
                formatter: function(val) {
                    return 'Rank ' + Math.round(val);
                }
            },
            tickAmount: Math.min(maxRank - 1, 10) // Batasi jumlah tick maksimal 10
        },
        tooltip: {
            enabled: true,
            shared: false,
            followCursor: true, // PERBAIKAN: tooltip mengikuti cursor
            intersect: false,
            fixed: {
                enabled: false // PERBAIKAN: tidak fixed position
            },
            custom: function({
                series,
                seriesIndex,
                dataPointIndex,
                w
            }) {
                // Ambil data siswa berdasarkan index
                const studentName = categories[dataPointIndex];
                const studentData = allStudents[dataPointIndex];
                const rankValue = series[seriesIndex][dataPointIndex];

                // Format konten tooltip
                let content = `
                    <div class="custom-tooltip" style="
                        background: #fff; 
                        border: 1px solid #ccc; 
                        border-radius: 6px; 
                        padding: 10px; 
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        font-size: 12px;
                        min-width: 150px;
                    ">
                        <div style="font-weight: bold; margin-bottom: 8px; color: #333; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                            ${studentName}
                        </div>
                `;

                if (rankValue === null || !studentData.memiliki_nilai) {
                    content += `
                        <div style="color: #666; margin-bottom: 4px;">
                            <strong style="color: #f39c12;">Tidak memiliki rank</strong>
                        </div>
                        <div style="color: #666;">
                            Total Nilai: <span style="color: #e74c3c; font-weight: bold;">0</span>
                        </div>
                    `;
                } else {
                    content += `
                        <div style="color: #666; margin-bottom: 4px;">
                            Peringkat: <span style="color: #3B82F6; font-weight: bold;">${rankValue}</span>
                        </div>
                        <div style="color: #666;">
                            Total Nilai: <span style="color: #27ae60; font-weight: bold;">${studentData.total_nilai ? studentData.total_nilai.toLocaleString() : '0'}</span>
                        </div>
                    `;
                }

                content += `</div>`;
                return content;
            },
            // PERBAIKAN: Konfigurasi posisi tooltip
            style: {
                fontSize: '12px'
            },
            theme: 'light'
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        colors: ['#3B82F6'],
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                // Hanya tampilkan label untuk siswa yang memiliki rank
                if (val === null) {
                    return '';
                }
                return 'Rank ' + Math.round(val);
            },
            style: {
                fontSize: '10px',
                colors: ['#fff'],
                fontWeight: 'bold'
            },
            background: {
                enabled: true,
                foreColor: '#3B82F6',
                borderRadius: 3,
                padding: 4,
                opacity: 0.9,
                borderWidth: 1,
                borderColor: '#3B82F6'
            },
            offsetY: -10
        },
    };

    // Render chart
    const rankChart = new ApexCharts(document.querySelector("#rankChart"), rankChartOptions);
    rankChart.render();

    // Responsive handling
    window.addEventListener('resize', function() {
        rankChart.updateOptions({
            chart: {
                height: window.innerWidth < 768 ? 350 : 450
            },
            xaxis: {
                labels: {
                    rotate: window.innerWidth < 768 ? -90 : -45
                }
            }
        });
    });
});
</script>
@endsection