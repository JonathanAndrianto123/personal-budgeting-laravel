<section class="site-section border-bottom" id="alltransactions-section">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-8 text-center">
        <h2 class="section-title mb-3" data-aos="fade-up">Semua Transaksimu</h2>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Semua transaksimu!</p>
      </div>
    </div>

    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <select name="trx_type" class="form-select" onchange="this.form.submit()">
          <option value="">-- Semua Jenis --</option>
          <option value="income" {{ request('trx_type') === 'income' ? 'selected' : '' }}>Pemasukan
          </option>
          <option value="expense" {{ request('trx_type') === 'expense' ? 'selected' : '' }}>
            Pengeluaran</option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="trx_category" id="trx_category" class="form-select" onchange="this.form.submit()">
          <option value="">-- Semua Kategori --</option>
          @foreach ($categories as $category)
        <option value="{{ $category->id }}" data-type="{{ $category->type }}" {{ request('trx_category') == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
        </option>
      @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <select name="trx_range" class="form-select" onchange="this.form.submit()">
          <option value="">-- Semua Waktu --</option>
          <option value="day" {{ request('trx_range') === 'day' ? 'selected' : '' }}>Hari Ini</option>
          <option value="week" {{ request('trx_range') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
          <option value="month" {{ request('trx_range') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
          <option value="year" {{ request('trx_range') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
        </select>
      </div>
    </form>

    @php
    $isEdit = session('editTransaction');
    @endphp

    <div class="row">
      @forelse ($transactions as $transaction)
      <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
      <div class="shadow-sm rounded-3 p-4 h-100 bg-white border transaksi">
        <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0 fw-bold text-dark">
          {{ optional($transaction->category)->name ?? 'Kategori tidak ditemukan' }}
        </h5>
        <span class="badge {{ optional($transaction->category)->type === 'income' ? 'bg-success' : 'bg-danger' }}">
          {{ optional($transaction->category)->type ?? 'Kategori tidak ditemukan' }}
        </span>
        </div>

        <p class="mb-1 text-dark">
        <strong>Jumlah:</strong> Rp{{ number_format($transaction->amount, 2, ',', '.') }}
        </p>
        <p class="mb-1 text-dark">
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
        </p>
        @if($transaction->note)
      <p class="text-muted"><em>"{{ $transaction->note }}"</em></p>
      @endif

        <div class="d-flex justify-content-end mt-3">
        <a href="#" data-id="{{ $transaction->id }}"
          class="btn btn-outline-primary btn-sm me-2 btn-edit-transaction">Edit</a>

        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST"
          class="d-inline delete-transaction-form">
          @csrf
          @method('DELETE')
          <button class="btn btn-outline-danger btn-sm">Hapus</button>
        </form>
        </div>
      </div>
      </div>
    @empty
      <div class="col-12 text-center mt-4">
      <div class="alert alert-warning shadow-sm" role="alert">
        Tidak ada transaksi ditemukan
      </div>
      </div>
    @endforelse
    </div>

  </div>
</section>
<section class="site-section border-bottom" id="addtransactions-section">
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-md-8 text-center">
        <h2 class="section-title mb-3" data-aos="fade-up">Tambah Transaksimu</h2>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Tambah transaksimu!</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <form id="transaction-form"
          action="{{ $isEdit ? route('transaction.update', $isEdit->id) : route('transaction.store') }}" method="POST"
          class="bg-white p-4 rounded shadow-sm text-dark">
          @csrf

          @if($isEdit)
        @method('PUT')
      @endif

          <div class="mb-3">
            <label class="form-label text-dark">Tipe Kategori</label>
            <div class="btn-group w-100 mb-2" role="group">
              <input type="radio" class="btn-check" name="filter_type" id="filter_income" value="income"
                autocomplete="off" checked>
              <label class="btn btn-outline-success" for="filter_income">Pemasukan</label>

              <input type="radio" class="btn-check" name="filter_type" id="filter_expense" value="expense"
                autocomplete="off">
              <label class="btn btn-outline-danger" for="filter_expense">Pengeluaran</label>
            </div>
          </div>

          <div class="mb-3">
            <label for="category_id" class="form-label text-dark">Kategori</label>
            <select name="category_id" id="category_id" class="form-select" required>
              <option value="">-- Pilih Kategori --</option>
              @foreach ($categories as $category)
          <option value="{{ $category->id }}" data-type="{{ $category->type }}"
          data-limit="{{ $category->limit ?? 0 }}" data-total="{{ $category->transactions->sum('amount') ?? 0 }}"
          {{ old('category_id', $isEdit->category_id ?? '') == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
          </option>
          <?php  $test = $category->id ?>
        @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="amount" class="form-label text-dark">Jumlah (Rp)</label>
            <input type="number" step="10000" min="0" name="amount" id="amount"
              class="form-control @error('amount') is-invalid @enderror"
              value="{{ old('amount', $isEdit->amount ?? '') }}" required>
            @error('amount')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>

          <div id="category-limit-progress" style="display: none;">
          </div>

          <div class="mb-3">
            <label for="date" class="form-label text-dark">Tanggal</label>
            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
              value="{{ old('date', isset($isEdit->date) ? $isEdit->date->format('Y-m-d') : '') }}" required>
            @error('date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>

          <div class="mb-3">
            <label for="note" class="form-label text-dark">Catatan (Opsional)</label>
            <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror"
              placeholder="Contoh: Gaji bulan Juni, belanja mingguan, dll.">{{ old('note', $isEdit->note ?? '') }}</textarea>
            @error('note')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
          </div>

          <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary btn-sm">{{ $isEdit ? "Edit" : "Simpan" }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <section class="site-section border-bottom" id="transaction-report-section">
    <div class="container">
      <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
          <h2 class="section-title mb-3" data-aos="fade-up">Laporan Transaksimu</h2>
          <p class="lead" data-aos="fade-up" data-aos-delay="100">Unduh Laporan Transaksimu</p>
        </div>
      </div>
      <form method="GET" action="{{ route('transaction.downloadReport') }}" class="row g-3 mb-4">
        <div class="col-md-3">
          <select name="trx_range" class="form-select">
            <option value="">-- Semua Waktu --</option>
            <option value="day">Hari Ini</option>
            <option value="week">Minggu Ini</option>
            <option value="month">Bulan Ini</option>
          </select>
        </div>
        <div class="col-md-3">
          <select name="format" class="form-select">
            <option value="pdf">Download PDF</option>
            <option value="excel">Download Excel</option>
          </select>
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary">Download</button>
        </div>
      </form>
    </div>
  </section>

  <section class="site-section border-bottom" id="transaction-chart-section">
    <div class="container">
      <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
          <h2 class="section-title mb-3" data-aos="fade-up">Laporan Keuanganmu</h2>
          <p class="lead" data-aos="fade-up" data-aos-delay="100">Analisa Laporan Keuanganmu!</p>
        </div>
      </div>
      <select id="yearFilter" class="form-select">
        @foreach ($years as $year)
      <option value="{{ $year }}" {{ now()->year == $year ? 'selected' : '' }}>
        {{ $year }}
      </option>
    @endforeach
      </select>
      <canvas id="reportChart"></canvas>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const trxTypeSelect = document.querySelector('select[name="trx_type"]');
      const trxCategorySelect = document.getElementById("trx_category");
      const trxAllOptions = Array.from(trxCategorySelect.options);

      function filterTrxCategories(selectedType) {

        trxAllOptions.forEach(option => {
          if (!option.dataset.type || option.dataset.type === selectedType || selectedType === "") {
            trxCategorySelect.appendChild(option);
          }
        });
      }

      trxTypeSelect.addEventListener('change', function () {
        filterTrxCategories(this.value);
      });

      filterTrxCategories(trxTypeSelect.value);
    });

    let reportChart;

    function loadChart(year) {
      fetch(`/chartData?year=${year}`)
        .then(res => res.json())
        .then(data => {
          const labels = data.map(d => d.bulan);
          const pemasukan = data.map(d => d.pemasukan);
          const pengeluaran = data.map(d => d.pengeluaran);

          if (reportChart) reportChart.destroy();

          const ctx = document.getElementById('reportChart').getContext('2d');
          reportChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: labels,
              datasets: [
                {
                  label: 'Pemasukan',
                  borderColor: '#4CAF50',
                  backgroundColor: 'rgba(76, 175, 80, 0.2)',
                  data: pemasukan,
                  tension: 0.4,
                  fill: true
                },
                {
                  label: 'Pengeluaran',
                  borderColor: '#F44336',
                  backgroundColor: 'rgba(244, 67, 54, 0.2)',
                  data: pengeluaran,
                  tension: 0.4,
                  fill: true
                }
              ]
            },
            options: {
              responsive: true,
              plugins: {
                legend: { position: 'top' },
                title: {
                  display: true,
                  text: `Grafik Laporan Keuangan Tahunan ${year}`
                }
              },
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
      const yearSelector = document.getElementById('yearFilter');
      loadChart(yearSelector.value);

      yearSelector.addEventListener('change', function () {
        loadChart(this.value);
      });
    });
  </script>

  <script>
    $(document).on('submit', 'form.delete-transaction-form', function (e) {
      e.preventDefault();
      const form = $(this);
      const url = form.attr('action');

      Swal.fire({
        title: 'Yakin?',
        text: "Transaksi akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
              form.closest('.col-md-6').remove();

              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message || 'Transaksi dihapus.',
                timer: 2000,
                showConfirmButton: false
              });
            },
            error: function () {
              Swal.fire('Gagal', 'Tidak dapat menghapus transaksi.', 'error');
            }
          });
        }
      });
    });

    $(document).on('click', '#reset-to-add-transaction', function () {
      const form = $('#transaction-form');

      form.trigger('reset');
      form.attr('action', '{{ route('transaction.store') }}');
      form.find('input[name="_method"]').remove();
      form.find('button[type="submit"]').text('Simpan');

      $('#reset-container-transaction').remove();
      document.getElementById("addtransactions-section").scrollIntoView({ behavior: 'smooth' });
    });
  </script>

  <script>
    $(document).ready(function () {
      $(document).on('click', '.btn-edit-transaction', function (e) {
        e.preventDefault();

        const id = $(this).data('id');

        $.ajax({
          url: `/dashboard/transactions/edit/${id}`,
          type: 'GET',
          success: function (response) {
            if (response.edit) {
              const form = $('#transaction-form');

              const type = response.transaction.category.type;

              $(`input[name="filter_type"][value="${type}"]`).prop('checked', true).trigger('change');

              setTimeout(() => {
                $('#category_id option').each(function () {
                  if ($(this).val() == response.transaction.category_id) {
                    $(this).prop('selected', true).trigger('change');
                  }
                });
              }, 100);

              $('#amount').val(response.transaction.amount);
              $('#date').val(response.transaction.date);
              $('#note').val(response.transaction.note ?? '');

              form.attr('action', `/dashboard/transactions/update/${id}`);
              if (form.find('input[name="_method"]').length === 0) {
                form.append('<input type="hidden" name="_method" value="PUT">');
              } else {
                form.find('input[name="_method"]').val('PUT');
              }

              form.find('button[type="submit"]').text('Edit');

              if ($('#reset-to-add-transaction').length === 0) {
                const resetBtn = `
                                <div class="d-flex justify-content-start mt-2" id="reset-container-transaction">
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-to-add-transaction">Ingin
                                menambah?</button>
                        </div>`;
                form.find('button[type="submit"]').closest('.d-flex').before(resetBtn);
              }

              const editForm = document.getElementById("addtransactions-section");
              if (editForm) {
                setTimeout(() => {
                  editForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
              }
            }
          },
          error: function () {
            Swal.fire('Gagal', 'Gagal mengambil data transaksi.', 'error');
          }
        });
      });
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const categorySelect = document.getElementById("category_id");
      const progressContainer = document.getElementById("category-limit-progress");
      const amountInput = document.getElementById("amount");

      function updateProgressBar() {
        const amount = parseFloat(amountInput?.value || 0);
        const selected = categorySelect.options[categorySelect.selectedIndex];
        const type = selected.dataset.type;
        const limit = parseFloat(selected.dataset.limit || 0);
        const total = parseFloat(selected.dataset.total || 0);
        const used = total + amount;

        if (type === "expense" && limit > 0) {
          const percent = Math.min(100, (used / limit) * 100);
          const percentRounded = Math.round(percent);
          const color = percent >= 100 ? 'danger' : 'success';

          progressContainer.innerHTML = `
        <div class="mb-2">
          <strong>${selected.text}</strong>
          <div class="progress">
            <div class="progress-bar bg-${color}" style="width: ${percent}%;">
              ${percentRounded}%
            </div>
          </div>
          <small class="text-muted">Rp${used.toLocaleString('id-ID')} dari Rp${limit.toLocaleString('id-ID')}</small>
        </div>
      `;
          progressContainer.style.display = 'block';
        } else {
          progressContainer.style.display = 'none';
          progressContainer.innerHTML = '';
        }
      }

      categorySelect.addEventListener("change", updateProgressBar);

      amountInput.addEventListener("input", updateProgressBar);

      updateProgressBar();
    });

  </script>

  <script>
    $(document).ready(function () {
      $('#transaction-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = form.find('input[name="_method"]').val() || 'POST';

        $.ajax({
          url: url,
          type: method,
          data: form.serialize(),

          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.message,
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
              const target = document.getElementById("alltransactions-section");
              target.scrollIntoView({ behavior: 'smooth' });
            });

            let transaction = response.transaction;
            let badgeClass = transaction.category.type === 'income' ? 'bg-success' : 'bg-danger';

            let form = $('#transaction-form');
            let isEdit = form.find('input[name="_method"]').val() === 'PUT';

            if (isEdit) {
              let card = $(`.btn-edit-transaction[data-id="${transaction.id}"]`).closest('.transaksi');
              card.find('h5').text(transaction.category.name);
              card.find('span.badge').text(transaction.category.type).removeClass('bg-success bg-danger').addClass(badgeClass);
              card.find('p:contains("Jumlah")').html(`<strong>Jumlah:</strong> Rp${parseFloat(transaction.amount).toLocaleString('id-ID', { minimumFractionDigits: 2 })}`);
              card.find('p:contains("Tanggal")').html(`<strong>Tanggal:</strong> ${new Date(transaction.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}`);
            } else {
              let newCard = `<div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
      <div class="shadow-sm rounded-3 p-4 h-100 bg-white border">
        <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0 fw-bold text-dark">
         ${transaction.category.name}
        </h5>
        <span class="badge ${badgeClass}">
          ${transaction.category.type}
        </span>
        </div>

        <p class="mb-1 text-dark">
        <strong>Jumlah:</strong> Rp${parseFloat(transaction.amount).toLocaleString('id-ID', { minimumFractionDigits: 2 })}
        </p>
        <p class="mb-1 text-dark">
        <strong>Tanggal:</strong> ${new Date(transaction.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}
        </p>
        ${transaction.note ? `<p class="text-muted"><em>"${transaction.note}"</em></p>` : ''}

        <div class="d-flex justify-content-end mt-3">
        <a href="#" data-id="${transaction.id}"
          class="btn btn-outline-primary btn-sm me-2 btn-edit-transaction">Edit</a>

        <form action="/dashboard/transactions/${transaction.id}" method="POST"
          class="d-inline delete-transaction-form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="DELETE">
          <button class="btn btn-outline-danger btn-sm">Hapus</button>
        </form>
        </div>
      </div>
      </div>`;
              $('#alltransactions-section .row:last').append(newCard);
            }

            form.trigger("reset");
            form.attr('action', '{{ route('transaction.store') }}');
            form.find('input[name="_method"]').remove();
            form.find('button[type="submit"]').text('Simpan');
          },
          error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMessages = '';
            for (let field in errors) {
              errorMessages += errors[field][0] + '\n';
            }

            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: errorMessages,
            });
          }
        });
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      const typeRadios = document.querySelectorAll('input[name="filter_type"]');
      const categorySelect = document.getElementById("category_id");
      const allOptions = Array.from(categorySelect.options);

      function filterCategories(selectedType) {
        categorySelect.innerHTML = "";
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "-- Pilih Kategori --";
        categorySelect.appendChild(defaultOption);

        allOptions.forEach(option => {
          if (option.dataset.type === selectedType) {
            categorySelect.appendChild(option);
          }
        });
      }

      typeRadios.forEach(radio => {
        radio.addEventListener("change", function () {
          if (this.checked) {
            filterCategories(this.value);
          }
        });
      });

      const selectedOption = categorySelect.querySelector('option[selected]');
      if (selectedOption) {
        filterCategories(selectedOption.dataset.type);
        categorySelect.value = selectedOption.value;
      } else {
        filterCategories("income");
      }
    });
  </script>

</section>