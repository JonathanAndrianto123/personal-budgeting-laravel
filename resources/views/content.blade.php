<div class="site-blocks-cover overlay"
    style="background-image: url('{{ asset('finances-master/images/about_2.jpg') }}');" data-aos="fade"
    id="home-section">

    <div class="container">
        <div class="row align-items-center justify-content-center">


            <div class="col-md-10 mt-lg-5 text-center">
                <div class="single-text owl-carousel">
                    <div class="slide">
                        <h1 class="text-uppercase" data-aos="fade-up">Catat<br>Pengeluaranmu</h1>
                        <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">
                            Mulai kelola keuangan harian dengan mudah.<br>Pantau semua pengeluaran dalam satu tempat.
                        </p>
                        <div data-aos="fade-up" data-aos-delay="100">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-primary mr-2 mb-2">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-primary mr-2 mb-2">Register</a>
                            @endguest
                            @auth
                                <a href="#addtransactions-section" class="btn btn-primary mr-2 mb-2 smoothscroll">Tambah Transaksi</a>
                                <a href="#transaction-chart-section" class="btn btn-primary mr-2 mb-2 smoothscroll">Laporan Keuangan</a>
                            @endauth

                        </div>
                    </div>

                    <div class="slide">
                        <h1 class="text-uppercase" data-aos="fade-up">Atur<br>Anggaran Bulanan</h1>
                        <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">Buat rencana anggaran setiap
                            bulan<br>
                            dan pastikan pengeluaran tetap sesuai target yang kamu tetapkan.</p>
                        <div data-aos="fade-up" data-aos-delay="100">
                            <a href="#addtransactions-section" class="btn btn-primary mr-2 mb-2 smoothscroll">Tambah Transaksi</a>
                            <a href="#transaction-chart-section" class="btn btn-primary mr-2 mb-2 smoothscroll">Laporan Keuangan</a>
                        </div>
                    </div>

                    <div class="slide">
                        <h1 class="text-uppercase" data-aos="fade-up">Capaikan Tujuan Finansial</h1>
                        <p class="mb-5 desc" data-aos="fade-up" data-aos-delay="100">Simpan untuk masa depan, liburan,
                            atau dana darurat.<br> Aplikasi kami bantu kamu disiplin mencapai target.
                        </p>
                        </p>
                        <div data-aos="fade-up" data-aos-delay="100">
                            <a href="#addtransactions-section" class="btn btn-primary mr-2 mb-2 smoothscroll">Tambah Transaksi</a>
                            <a href="#transaction-chart-section" class="btn btn-primary mr-2 mb-2 smoothscroll">Laporan Keuangan</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <a href="#dashboard-summary" class="mouse smoothscroll">
        <span class="mouse-icon">
            <span class="mouse-wheel"></span>
        </span>
    </a>
</div>
@auth
    <section class="site-section border-bottom" id="dashboard-summary">
        <div class="container">
            <h2 class="section-title text-center mb-5">Ringkasan Keuanganmu {{ $monthName }} {{ $year }}</h2>

            <div class="alert alert-info text-center fs-5">
                <strong>Saldo Akhir:</strong> Rp{{ number_format($totalBalance, 0, ',', '.') }}
            </div>

            <canvas id="summaryChart" height="100"></canvas>

            <h5 class="mt-5 mb-3">Progress Pengeluaran Kategori (Limit)</h5>
            @foreach ($categorySummaries as $cat)
                @if($cat->type === 'expense' && $cat->limit)
                    @php
                        $percent = min(100, ($cat->total / $cat->limit) * 100);
                    @endphp
                    <div class="mb-2">
                        <strong>{{ $cat->name }}</strong>
                        <div class="progress">
                            <div class="progress-bar bg-{{ $percent >= 100 ? 'danger' : 'success' }}"
                                style="width: {{ $percent }}%;">
                                {{ number_format($percent) }}%
                            </div>
                        </div>
                        <small class="text-muted">Rp{{ number_format($cat->total) }} dari Rp{{ number_format($cat->limit) }}</small>
                    </div>
                @endif
            @endforeach

            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <h5 class="mb-3">Kategori Paling Boros</h5>
                        <p class="mb-0 fw-bold">{{ $mostSpentCategory->name ?? '-' }}</p>
                        <small class="text-muted">Rp{{ number_format($mostSpentCategory->total ?? 0) }} bulan ini</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        @if ($mostFrequentExpenseDay)
                            <p>Hari paling sering belanja:
                                <strong>{{ \Carbon\Carbon::parse($mostFrequentExpenseDay)->format('d M Y') }}</strong>
                                ({{ $mostFrequentExpenseCount }} transaksi)
                            </p>
                        @else
                            <p>Tidak ada transaksi pengeluaran bulan ini.</p>
                        @endif
                    </div>
                </div>
            </div>

            <form class="mt-4 row g-3" method="GET" action="{{ route('transaction.downloadReport') }}">
                <div class="col-md-4">
                    <select name="trx_range" class="form-select">
                        <option value="">-- Semua Waktu --</option>
                        <option value="day">Hari Ini</option>
                        <option value="week">Minggu Ini</option>
                        <option value="month">Bulan Ini</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="format" class="form-select">
                        <option value="pdf">Download PDF</option>
                        <option value="excel">Download Excel</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">Download</button>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('summaryChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($summaryLabels) !!},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: {!! json_encode($summaryIncome) !!},
                            backgroundColor: 'rgba(76, 175, 80, 0.6)'
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($summaryExpense) !!},
                            backgroundColor: 'rgba(244, 67, 54, 0.6)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>
@endauth

</section>