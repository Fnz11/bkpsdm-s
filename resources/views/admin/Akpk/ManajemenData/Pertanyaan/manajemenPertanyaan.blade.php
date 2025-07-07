    @extends('layouts.app')

    @section('content')
        <div class="">
            <!-- Header dengan background biru -->
            <div class="bg-primary text-white p-4 position-relative overflow-hidden bg-primary-section">
                <!-- Elemen dekoratif (seperti roket) di pojok kanan -->
                <div class="position-absolute end-0 top-0 opacity-25">
                    <img src="{{ asset('images/roketDashboard.png') }}" alt="Illustration" height="150">
                </div>
                <!-- Background pattern dots -->
                <div class="position-absolute w-100 h-100 top-0 start-0"
                    style="background-image: radial-gradient(rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 20px 20px;">
                </div>

                <div class="container position-relative">
                    <h4 class="fw-bold mb-2">Pertanyaan Assessment</h4>
                    <p class="mb-0 opacity-75">Data pertanyaan Self Assessment untuk seluruh ASN Kota Surakarta.</p>
                </div>
            </div>
            <div class="mt-4">
                <!-- Filter dan Tombol -->
                <div class="row mb-3 align-items-center">
                    <div class="col-md-2 mt-2">
                        <select class="form-select" id="rumpun">
                            <option selected disabled>Pilih Unit Kerja</option>
                            <option value="BKPSDM">BKPSDM</option>
                            <option value="Kemenkes">Kementerian Kesehatan</option>
                            <option value="Kominfo">Kementerian Komunikasi dan Informasi</option>
                            <option value="Kemenag">Kementerian</option>
                        </select>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari..." id="searchInput">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end mt-2">
                        <button type="button" class="btn me-2" style="box-shadow: 0 0 10px rgba(0, 0, 0, 25%);">
                            <i class="bi bi-cloud-download me-2"></i>Import
                        </button>
                        <button type="button" class="btn btn-outline-success me-2">
                            <i class="fas fa-file-excel me-2"></i>Excel
                        </button>
                        <button type="button" class="btn btn-outline-danger me-2" onclick="cetakPDF()">
                            <i class="fas fa-file-pdf me-2"></i>Cetak PDF
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPertanyaan">
                            <i class="bi bi-plus-lg me-2"></i>Tambah
                        </button>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th class="vertical-align: middle;">No</th>
                                <th>Kategori</th>
                                <th>Tipe</th>
                                <th>Kompetensi</th>
                                <th>Deskripsi</th>
                                <th>Standar Minimum</th>
                                <th>status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itemsPerPage = 10;
                                $currentPage = request()->get('page', 1);
                                $data = $data->toArray();
                                $totalPages = ceil(count($data) / $itemsPerPage);
                                $start = ($currentPage - 1) * $itemsPerPage;
                                $paginateddata = array_slice($data, $start, $itemsPerPage);
                            @endphp

                    @foreach ($paginateddata as $index => $row)
                    <tr>
                        <td>{{ $index + 1 + $start }}</td>
                        <td>{{ $row['kategori'] }}</td>
                        <td>{{ $row['tipe'] }}</td>
                        <td>{{ $row['kompetensi'] }}</td>
                        <td>{{ $row['deskripsi'] }}</td>
                        <td class="text-center">{{ $row['standar_min'] }}</td>
                        <td class="text-center">
                            <div class="form-check form-switch">
                                <input 
                                    class="form-check-input toggle-status" 
                                    type="checkbox" 
                                    data-id="{{ $row['id'] }}" 
                                    data-tipe="{{ $row['tipe'] }}"
                                    {{ $row['status'] === 'aktif' ? 'checked' : '' }}
                                >
                            </div>
                        </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-primary btn-edit-pertanyaan"
                                    title="Edit"
                                    data-id="{{ $row['id'] }}"
                                    data-kategori="{{ $row['kategori'] }}"
                                    data-tipe="{{ $row['tipe'] }}"
                                    data-kompetensi="{{ $row['kompetensi'] }}"
                                    data-deskripsi="{{ $row['deskripsi'] }}"
                                    data-standar="{{ $row['standar_min'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditPertanyaan">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                
                                <button 
                                class="btn btn-sm btn-outline-danger btn-hapus-pertanyaan" 
                                title="Hapus"
                                data-id="{{ $row['id'] }}"
                                data-tipe="{{ $row['tipe'] }}"
                                >
                                <i class="bi bi-trash"></i>
                            </button>
                            
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                                        </tbody>
                                    </table>
                                </div>
                            
                                <!-- Pagination -->
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                                    <a class="page-link" href="?page={{ $currentPage - 1 }}" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo; Previous</span>
                                                    </a>
                                                </li>
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                                    <a class="page-link" href="?page={{ $currentPage + 1 }}" aria-label="Next">
                                                        <span aria-hidden="true">Next &raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('Admin.Akpk.ManajemenData.Pertanyaan.editPertanyaan')
                        @include('Admin.Akpk.ManajemenData.Pertanyaan.tambahPertanyaan')

                    @endsection
                    
                    @section('scripts')
                    
                    <script>
                        // script untuk mengatur status pertanyaan
                        document.querySelectorAll('.toggle-status').forEach(function (checkbox) {
                            checkbox.addEventListener('change', function () {
                                let id = this.getAttribute('data-id');
                                let tipe = this.getAttribute('data-tipe');
                                let status = this.checked ? 'aktif' : 'nonaktif';
                    
                                fetch("{{ route('pertanyaan.toggleStatusDiri') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({ id, tipe, status })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        console.log('Status berhasil diperbarui');
                                    } else {
                                        alert('Gagal memperbarui status');
                                    }
                                });
                            });
                        });
                    </script>

                    <script>
                        //script untuk mengatur kolom yang muncul
                        function toggleFields(formId) {
                            const form = document.querySelector(`#${formId}`);
                            const tipeSoalSelect = form.querySelector('[name="tipe_soal"]');
                            const skalaFields = form.querySelector('#skalaFields');
                            const pertanyaanField = form.querySelector('#pertanyaanField');
                        
                            const updateVisibility = () => {
                                const value = tipeSoalSelect.value;
                                if (value === 'Skala') {
                                    skalaFields.style.display = 'block';
                                    pertanyaanField.style.display = 'none';
                                } else if (value === 'Essai') {
                                    pertanyaanField.style.display = 'block';
                                    skalaFields.style.display = 'none';
                                } else {
                                    skalaFields.style.display = 'none';
                                    pertanyaanField.style.display = 'none';
                                }
                            };
                        
                            tipeSoalSelect.addEventListener('change', updateVisibility);
                            updateVisibility(); // apply once on load
                        }
                    
                        document.addEventListener('DOMContentLoaded', () => {
                            toggleFields('formTambahPertanyaan');
                            toggleFields('formEditPertanyaan');
                        });
                    </script>

                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            document.querySelectorAll('.btn-edit-pertanyaan').forEach(function (btn) {
                                btn.addEventListener('click', function () {
                                    const id = this.getAttribute('data-id');
                                    const kategori = this.getAttribute('data-kategori');
                                    const tipe = this.getAttribute('data-tipe');
                                    const kompetensi = this.getAttribute('data-kompetensi');
                                    const deskripsi = this.getAttribute('data-deskripsi');
                                    const standar = this.getAttribute('data-standar');
                                
                                    // Set tipe soal terlebih dahulu agar toggleFields bekerja
                                    const tipeSelect = document.getElementById('tipeSoal');
                                    tipeSelect.value = tipe;
                                    tipeSelect.dispatchEvent(new Event('change'));
                                
                                    // Isi field sesuai tipe soal
                                    document.getElementById('kategori').value = kategori;
                                
                                    if (tipe === 'Essai') {
                                        document.getElementById('pertanyaan').value = deskripsi;
                                    } else if (tipe === 'Skala') {
                                        document.getElementById('kompetensi').value = kompetensi;
                                        document.getElementById('deskripsi').value = deskripsi;
                                        document.getElementById('standarMinimum').value = standar;
                                    }
                                
                                    // Optional: simpan ID di hidden input untuk update ke backend
                                    let hiddenId = document.getElementById('editPertanyaanId');
                                    if (!hiddenId) {
                                        hiddenId = document.createElement('input');
                                        hiddenId.type = 'hidden';
                                        hiddenId.name = 'id';
                                        hiddenId.id = 'editPertanyaanId';
                                        document.getElementById('formEditPertanyaan').appendChild(hiddenId);
                                    }
                                    hiddenId.value = id;
                                });
                            });
                        });
                    </script>

                    <script>
                        document.querySelectorAll('.btn-hapus-pertanyaan').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                const id = this.getAttribute('data-id');
                                const tipe = this.getAttribute('data-tipe');
                            
                                if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
                                    fetch("{{ route('adminpertanyaandiri.hapus') }}", {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                            "Content-Type": "application/json"
                                        },
                                        body: JSON.stringify({ id, tipe })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Pertanyaan berhasil disembunyikan.');
                                            location.reload();
                                        } else {
                                            alert(data.message || 'Terjadi kesalahan.');
                                        }
                                    });
                                }
                            });
                        });
                    </script>

                    @endsection
                    