<section class="site-section border-bottom" id="allcategories-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="section-title mb-3" data-aos="fade-up">Semua Kategorimu</h2>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">Semua kategorimu!</p>
            </div>
        </div>

        @php
            $isEdit = session('editCategory');
        @endphp

        <div class="row">
            @forelse ($categories as $category)
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
                    <div class="shadow-sm rounded-3 p-4 h-100 bg-white border transaksi">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-bold text-dark">
                                {{ optional($category)->name ?? 'Kategori tidak ditemukan' }}
                            </h5>
                            <span class="badge {{ optional($category)->type === 'income' ? 'bg-success' : 'bg-danger' }}">
                                {{ optional($category)->type ?? 'Kategori tidak ditemukan' }}
                            </span>
                        </div>
                        @if ($category->type == 'expense')
                            <p class="mb-1 text-dark limit-info">
                                <strong>Limit:</strong> Rp{{ number_format($category->limit, 2, ',', '.') }}
                            </p>
                        @endif
                        <div class="mt-3">
                            <a href="#" data-id="{{ $category->id }}"
                                class="btn btn-outline-primary btn-sm me-2 btn-edit-category">Edit</a>

                            <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                class="d-inline delete-category-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center mt-4">
                    <div class="alert alert-warning shadow-sm" role="alert">
                        Tidak ada kategori ditemukan
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<section class="site-section border-bottom" id="addcategories-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center">
                <h2 class="section-title mb-3" data-aos="fade-up">Tambah Kategorimu</h2>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">Tambah Kategori personalmu!</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="category-form"
                    action="{{ $isEdit ? route('category.update', $isEdit->id) : route('category.store') }}"
                    method="POST" class="bg-white p-4 rounded shadow-sm text-dark">
                    @csrf

                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label text-dark">Nama Kategori</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror text-dark"
                            placeholder="Contoh: Gaji, Belanja" value="{{ old('name', $isEdit->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label text-dark">Tipe Kategori</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="type" id="income" value="income"
                                autocomplete="off" required {{ old('type', $isEdit->type ?? '') == 'income' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="income">Pemasukan</label>

                            <input type="radio" class="btn-check" name="type" id="expense" value="expense"
                                autocomplete="off" required {{ old('type', $isEdit->type ?? '') == 'expense' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="expense">Pengeluaran</label>
                        </div>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="limit-group">
                        <label for="limit" class="form-label text-dark">Limit (Rp)</label>
                        <input type="number" step="0.01" min="0" name="limit" id="limit"
                            class="form-control @error('limit') is-invalid @enderror"
                            value="{{ old('limit') ?? ($isEdit->limit ?? '') }}">
                        @error('limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($isEdit)
                        <div class="d-flex justify-content-start mt-2">
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-to-add-category">Ingin
                                menambah?</button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-sm">{{ $isEdit ? "Edit" : "Simpan" }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('submit', 'form.delete-category-form', function (e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');

            Swal.fire({
                title: 'Yakin?',
                text: "Kategori akan dihapus permanen!",
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
                                text: response.message || 'Kategori dihapus.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function () {
                            Swal.fire('Gagal', 'Tidak dapat menghapus kategori.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '#reset-to-add-category', function () {
            const form = $('#category-form');

            form.trigger('reset');
            form.attr('action', '{{ route('category.store') }}');
            form.find('input[name="_method"]').remove();
            form.find('button[type="submit"]').text('Simpan');

            $('#reset-container-category').remove();
            document.getElementById("addcategories-section").scrollIntoView({ behavior: 'smooth' });
        });

        function toggleLimitField() {
            const selectedType = $('input[name="type"]:checked').val();
            if (selectedType === 'expense') {
                $('#limit-group').show();
                $('#limit').prop('required', true);
            } else {
                $('#limit-group').hide();
                $('#limit').prop('required', false).val('');
            }
        }

        $(document).ready(function () {
            toggleLimitField();

            $('input[name="type"]').on('change', function () {
                toggleLimitField();
            });
        });

    </script>


    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-edit-category', function (e) {
                e.preventDefault();

                const id = $(this).data('id');

                $.ajax({
                    url: `/dashboard/categories/edit/${id}`,
                    type: 'GET',
                    success: function (response) {
                        if (response.edit) {
                            const form = $('#category-form');

                            $('#name').val(response.category.name);
                            $('input[name="type"][value="' + response.category.type + '"]').prop('checked', true);
                            toggleLimitField();
                            $('#limit').val(response.category.limit);

                            form.attr('action', `/dashboard/categories/update/${id}`);
                            if (form.find('input[name="_method"]').length === 0) {
                                form.append('<input type="hidden" name="_method" value="PUT">');
                            } else {
                                form.find('input[name="_method"]').val('PUT');
                            }

                            form.find('button[type="submit"]').text('Edit');

                            if ($('#reset-to-add-category').length === 0) {
                                const resetBtn = `
                                <div class="d-flex justify-content-start mt-2" id="reset-container-category">
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-to-add-category">Ingin
                                menambah?</button>
                        </div>`;
                                form.find('button[type="submit"]').closest('.d-flex').before(resetBtn);
                            }

                            document.getElementById("addcategories-section").scrollIntoView({ behavior: 'smooth' });
                        }
                    },
                    error: function () {
                        Swal.fire('Gagal', 'Gagal mengambil data kategori.', 'error');
                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function () {
            $('#category-form').on('submit', function (e) {
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
                        });

                        let id = response.category.id;
                        let name = response.category.name;
                        let type = response.category.type;
                        let limit = response.category.limit;

                        let form = $('#category-form');
                        let isEdit = form.find('input[name="_method"]').val() === 'PUT';

                        if (isEdit) {
                            let card = $(`.btn-edit-category[data-id="${id}"]`).closest('.transaksi');
                            card.find('h5').text(name);

                            let badge = card.find('.badge');
                            badge.removeClass('bg-success bg-danger')
                                .addClass(type === 'income' ? 'bg-success' : 'bg-danger')
                                .text(type);

                            if (type === 'expense') {
                                let limitText = `<strong>Limit:</strong> Rp${parseFloat(limit).toLocaleString('id-ID', { minimumFractionDigits: 2 })}`;
                                if (card.find('.limit-info').length) {
                                    card.find('.limit-info').html(limitText);
                                } else {
                                    card.find('.badge').after(`<p class="mb-1 text-dark limit-info">${limitText}</p>`);
                                }
                            } else {
                                card.find('.limit-info').remove();
                            }
                        } else {
                            let newCard = `
        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
                    <div class="team-member shadow-sm rounded-3 p-3 h-100 d-flex flex-column justify-content-between bg-white">
                        <div>
                            <h5 class="mb-1" style="color:black;">${name}</h5>
                            <small class="text-muted" style="color:black;">${type}</small>
                            ${type === 'expense' ? `<p class="limit-info mb-0 text-dark"><strong>Limit:</strong> Rp${parseInt(limit).toLocaleString('id-ID', { minimumFractionDigits: 2 })}</p>` : ''}
                        </div>
                        <div class="mt-3">
                            <a href="#" data-id="${res.category.id}" class="btn btn-outline-primary btn-sm me-2 btn-edit-category">Edit</a>
                            <form action="/dashboard/categories/delete/${res.category.id}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                <input type="hidden" name="_token" value="${$('input[name="_token"]').val()}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
    `;

                            $('#allcategories-section .row:last').append(newCard);
                        }


                        form.trigger("reset");
                        form.attr('action', '{{ route('category.store') }}');
                        form.find('input[name="_method"]').remove();
                        form.find('button[type="submit"]').text('Simpan');

                        document.getElementById("allcategories-section").scrollIntoView({ behavior: 'smooth' });
                    }

                    ,
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
    </script>



</section>