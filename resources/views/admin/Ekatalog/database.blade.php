@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif





<!-- Include Bootstrap JS (after jQuery, if using jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session("error") }}',  <!-- Mengganti tanda kutip dalam session -->
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") }}',  <!-- Mengganti tanda kutip dalam session -->
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif
<script>
    function checkNumber(input) {
        // Cek apakah input bukan angka
        if (isNaN(input.value)) {
            document.getElementById('errorKode').style.display = 'block';
            input.setCustomValidity('Kode hanya bisa berupa angka!');
        } else {
            document.getElementById('errorKode').style.display = 'none';
            input.setCustomValidity('');
        }
    }
</script>


<div class="custom-table-container">
    <div class="custom-table" style="width: 100%; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h1>Pelatihan Management</h1>
        <form method="GET" action="{{ route('Admin.ekatalog.database') }}" style="width: 100%; margin-bottom: 20px;">
        </form>

        <!-- Button to Open Modal for Pelaksanaan -->
        <button type="button" class="btn btn-primary" onclick="openModal('pelaksanaan')">
            Add New Pelaksanaan
        </button>

        <!-- The Modal for Pelaksanaan -->
        <div id="pelaksanaanModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('pelaksanaan')">&times;</span>
                <h2>Tambah Pelaksanaan Baru</h2>

                <!-- Form inside the Modal -->
                <form id="pelaksanaanForm" action="{{ route('pelatihan.store', ['type' => 'pelaksanaan']) }}" method="POST" onsubmit="return validateForm(this)">
                    @csrf
                    <div class="form-group">
                        <label for="kode_pelaksanaanpelatihan">Kode Pelaksanaan</label>
                        <input type="text" id="kode_pelaksanaanpelatihan" name="kode_pelaksanaanpelatihan" class="form-control" required pattern="^\d{1,11}$" maxlength="11" title="Harap masukkan angka dengan panjang maksimal 11 karakter">
                    </div>

                    <div class="form-group">
                        <label for="pelaksanaan_pelatihan">Pelaksanaan</label>
                        <input type="text" id="pelaksanaan_pelatihan" name="pelaksanaan_pelatihan" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>

 


        <!-- Button to Open Modal for Jenis Pelatihan -->
        <button type="button" class="btn btn-primary" onclick="openModal('jenis')">
            Add New Jenis Pelatihan
        </button>

        <!-- The Modal for Jenis Pelatihan -->
        <div id="jenisModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal('jenis')">&times;</span>
        <h2>Add New Jenis Pelatihan</h2>

        <!-- Form inside the Modal -->
        <form id="jenisForm" action="{{ route('pelatihan.store', ['type' => 'jenis']) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kode_jenispelatihan">Kode Pelatihan</label>
                <input type="text" id="kode_jenispelatihan" name="kode_jenispelatihan" class="form-control" required pattern="^\d{1,11}$" maxlength="11" title="Harap masukkan angka dengan panjang maksimal 11 karakter">
            </div>

            <div class="form-group">
                <label for="jenis_pelatihan">Jenis Pelatihan</label>
                <input type="text" id="jenis_pelatihan" name="jenis_pelatihan" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>

<script>
    // Function to open modal
    function openModal(modalType) {
        let modal = document.getElementById(modalType + 'Modal');
        modal.style.display = 'block';
    }

    // Function to close modal
    function closeModal(modalType) {
        let modal = document.getElementById(modalType + 'Modal');
        modal.style.display = 'none';
    }
</script>


        <!-- Button to Open Modal for Metode Pelatihan -->
        <button type="button" class="btn btn-primary" onclick="openModal('metode')">
            Add New Metode Pelatihan
        </button>

        <!-- The Modal for Metode Pelatihan -->
        <div id="metodeModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('metode')">&times;</span>
                <h2>Add New Metode Pelatihan</h2>

                <!-- Form inside the Modal -->
                <form id="metodeForm" action="{{ route('pelatihan.store', ['type' => 'metode']) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode_metodepelatihan">Kode Metode</label>
                        <input type="text" id="kode_metodepelatihan" name="kode_metodepelatihan" class="form-control" required>
                    </div>

                        <div class="form-group">
                            <label for="metode_pelatihan">Metode Pelatihan</label>
                            <input type="text"  id="metode_pelatihan" name="metode_pelatihan" class="form-control" required>                            
                        </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

        <!-- Button to Open Modal for Golongan -->
        <button type="button" class="btn btn-primary" onclick="openModal('golongan')">
            Add New Golongan
        </button>

        <!-- The Modal for Golongan -->
        <div id="golonganModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('golongan')">&times;</span>
                <h2>Add New Golongan</h2>

                <!-- Form inside the Modal -->
                <form id="golonganForm" action="{{ route('pelatihan.store', ['type' => 'golongan']) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode_golongan">Kode Golongan</label>
                        <input type="text" id="kode_golongan" name="kode_golongan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="golongan">Golongan</label>
                        <input type="text" id="golongan" name="golongan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="pangkat">Pangkat</label>
                        <input type="text" id="pangkat" name="pangkat" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

        <!-- Button to Open Modal for Jabatan -->
        <button type="button" class="btn btn-primary" onclick="openModal('jabatan')">
            Add New Jabatan
        </button>

        <!-- The Modal for Unit Kerja -->
        <div id="jabatanModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('jabatan')">&times;</span>
                <h2>Add New Jabatan</h2>

                <!-- Form inside the Modal -->
                <form id="jabatanForm" action="{{ route('pelatihan.store', ['type' => 'jabatan']) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode_kategorijabatan">Kode Unit Kerja</label>
                        <input 
                            type="text" 
                            id="kode_kategorijabatan" 
                            name="kode_kategorijabatan" 
                            class="form-control" 
                            required 
                            pattern="^\d{1,11}$" 
                            maxlength="11"
                            title="Harap masukkan angka dengan panjang maksimal 11 karakter">
                    </div>

                    <div class="form-group">
                        <label for="kategori_jabatan">Jabatan</label>
                        <input type="text" id="kategori_jabatan" name="kategori_jabatan" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

        <!-- Button to Open Modal for Unit Kerja -->
        <button type="button" class="btn btn-primary" onclick="openModal('unitkerja')">
            Add New Unit Kerja
        </button>

        <!-- The Modal for Unit Kerja -->
        <div id="unitkerjaModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('unitkerja')">&times;</span>
                <h2>Add New Unit Kerja</h2>

                <!-- Form inside the Modal -->
                <form id="unitKerjaForm" action="{{ route('pelatihan.store', ['type' => 'unitkerja']) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode_unitkerja">Kode Unit Kerja</label>
                        <input 
                            type="text" 
                            id="kode_unitkerja" 
                            name="kode_unitkerja" 
                            class="form-control" 
                            required 
                            pattern="^\d{1,11}$" 
                            maxlength="11"
                            title="Harap masukkan angka dengan panjang maksimal 11 karakter">
                    </div>

                    <div class="form-group">
                        <label for="sub_unitkerja">Sub Unit Kerja</label>
                        <input type="text" id="sub_unitkerja" name="sub_unitkerja" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="unit_kerja">Unit Kerja</label>
                        <input type="text" id="unit_kerja" name="unit_kerja" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="singkatan">Singkatan</label>
                        <input type="text" id="singkatan" name="singkatan" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Pelaksanaan Pelatihan -->
<div class="accordion"  id="databaseAccordion">

    <!-- Pelaksanaan Pelatihan -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingPelaksanaan">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePelaksanaan" aria-expanded="true" aria-controls="collapsePelaksanaan">
                <i class="bi bi-calendar-check"></i> Pelaksanaan Pelatihan 
                <span class="badge bg-primary ms-2">{{ $pelaksanaanPelatihan->count() }}</span>
            </button>
        </h2>
        <div id="collapsePelaksanaan" class="accordion-collapse collapse show" aria-labelledby="headingPelaksanaan" data-bs-parent="#databaseAccordion">
            <div class="accordion-body">
                <table class="table table-hover table-bordered shadow-sm">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Kode Pelaksanaan</th>
                            <th>Pelaksanaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelaksanaanPelatihan as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->kode_pelaksanaanpelatihan }}</td>
                                <td>{{ $item->pelaksanaan_pelatihan }}</td>
                                <td class="text-center">
                                    <form action="{{ route('deletedata', ['model' => 'PelaksanaanPelatihan', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No data found for Pelaksanaan Pelatihan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Jenis Pelatihan -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingJenis">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJenis" aria-expanded="false" aria-controls="collapseJenis">
                <i class="bi bi-tags-fill"></i> Jenis Pelatihan 
                <span class="badge bg-primary ms-2">{{ $jenisPelatihan->count() }}</span>
            </button>
        </h2>
        <div id="collapseJenis" class="accordion-collapse collapse" aria-labelledby="headingJenis" data-bs-parent="#databaseAccordion">
            <div class="accordion-body">
                <table class="table table-hover table-bordered shadow-sm">
                    <thead class="table-warning text-center">
                        <tr>
                            <th>#</th>
                            <th>Kode Pelatihan</th>
                            <th>Jenis Pelatihan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jenisPelatihan as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->kode_jenispelatihan }}</td>
                                <td>{{ $item->jenis_pelatihan }}</td>
                                <td class="text-center">
                                    <form action="{{ route('deletedata', ['model' => 'JenisPelatihan', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No data found for Jenis Pelatihan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Metode Pelatihan -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingMetode">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMetode" aria-expanded="false" aria-controls="collapseMetode">
                <i class="bi bi-diagram-3-fill"></i> Metode Pelatihan 
                <span class="badge bg-primary ms-2">{{ $metodePelatihan->count() }}</span>
            </button>
        </h2>
        <div id="collapseMetode" class="accordion-collapse collapse" aria-labelledby="headingMetode" data-bs-parent="#databaseAccordion">
            <div class="accordion-body">
                <table class="table table-hover table-bordered shadow-sm">
                    <thead class="table-success text-center">
                        <tr>
                            <th>#</th>
                            <th>Kode Metode</th>
                            <th>Metode Pelatihan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($metodePelatihan as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->kode_metodepelatihan }}</td>
                                <td>{{ $item->metode_pelatihan }}</td>
                                <td class="text-center">
                                    <form action="{{ route('deletedata', ['model' => 'MetodePelatihan', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No data found for Metode Pelatihan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Golongan -->
<div class="accordion-item">
    <h2 class="accordion-header" id="headingGolongan">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGolongan" aria-expanded="false" aria-controls="collapseGolongan">
            <i class="bi bi-award-fill"></i> Golongan 
            <span class="badge bg-primary ms-2">{{ $golongan->count() }}</span>
        </button>
    </h2>
    <div id="collapseGolongan" class="accordion-collapse collapse" aria-labelledby="headingGolongan" data-bs-parent="#databaseAccordion">
        <div class="accordion-body">
            <table class="table table-hover table-bordered shadow-sm">
                <thead class="table-danger text-center">
                    <tr>
                        <th>#</th>
                        <th>Kode Golongan</th>
                        <th>Golongan</th>
                        <th>Pangkat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($golongan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->kode_golongan }}</td>
                            <td>{{ $item->golongan }}</td>
                            <td>{{ $item->pangkat }}</td>
                            <td class="text-center">
                                <form action="{{ route('deletedata', ['model' => 'Golongan', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No data found for Golongan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Jabatan -->
    <div class="accordion-item">
    <h2 class="accordion-header" id="headingJabatan">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseJabatan" aria-expanded="false" aria-controls="collapseJabatan">
            <i class="bi bi-award-fill"></i> Jabatan 
            <span class="badge bg-primary ms-2">{{ $jabatan->count() }}</span>
        </button>
    </h2>
    <div id="collapseJabatan" class="accordion-collapse collapse" aria-labelledby="headingJabatan" data-bs-parent="#databaseAccordion">
        <div class="accordion-body">
            <table class="table table-hover table-bordered shadow-sm">
                <thead class="table-danger text-center">
                    <tr>
                        <th>#</th>
                        <th>Kode Jabatan</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jabatan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->kode_kategorijabatan }}</td>
                            <td>{{ $item->kategori_jabatan }}</td>
                            <td class="text-center">
                                <form action="{{ route('deletedata', ['model' => 'Jabatan', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No data found for Jabatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Unit Kerja -->
<div class="accordion-item">
    <h2 class="accordion-header" id="headingUnitKerja">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUnitKerja" aria-expanded="false" aria-controls="collapseUnitKerja">
            <i class="bi bi-briefcase-fill"></i> Unit Kerja 
            <span class="badge bg-primary ms-2">{{ $unit_Kerja->count() }}</span>
        </button>
    </h2>
    <div id="collapseUnitKerja" class="accordion-collapse collapse" aria-labelledby="headingUnitKerja" data-bs-parent="#databaseAccordion">
        <div class="accordion-body">
            <table class="table table-hover table-bordered shadow-sm">
                <thead class="table-info text-center">
                    <tr>
                        <th>#</th>
                        <th>Kode Unit Kerja</th>
                        <th>Sub Unit Kerja</th>
                        <th>Unit Kerja</th>
                        <th>Singkatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($unit_Kerja as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->kode_unitkerja }}</td>
                            <td>{{ $item->sub_unitkerja }}</td>
                            <td>{{ $item->unit_kerja }}</td>
                            <td>{{ $item->singkatan }}</td>
                            <td class="text-center">
                                <form action="{{ route('deletedata', ['model' => 'UnitKerja', 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No data found for Unit Kerja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<script>
    // Function to open the modal
function openModal(type) {
    document.getElementById(type + 'Modal').style.display = 'flex';
}

// Function to close the modal
function closeModal(type) {
    document.getElementById(type + 'Modal').style.display = 'none';
}

// Close modal if clicked outside the modal
window.onclick = function(event) {
    var modalTypes = ['pelaksanaan', 'jenis', 'metode', 'golongan', 'unitkerja','jabatan'];
    modalTypes.forEach(function(type) {
        var modal = document.getElementById(type + 'Modal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
}
</script>
<script>
    // Function to handle form validation before submitting
    function validateForm(form) {
        // Example for checking if the 'kode_jabatan' input is valid
        let kodeInput = form.querySelector('#kode_kategorijabatan');
        let validKode = /^[\d]{1,11}$/.test(kodeInput.value);
        
        if (!validKode) {
            // If invalid input, prevent the form submission and show an error message
            alert("Harap masukkan angka dengan panjang maksimal 11 karakter.");
            return false; // Prevent the form from being submitted
        }

        return true; // Allow form submission
    }

    // Handle modal open and close
    function openModal(modalType) {
        let modal = document.getElementById(modalType + 'Modal');
        modal.style.display = 'block';
    }

    function closeModal(modalType) {
        let modal = document.getElementById(modalType + 'Modal');
        modal.style.display = 'none';
    }
</script>


<style>
    /* Modal */
.modal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    display: none;
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    border-radius: 8px;
    max-height: 90vh; /* Modal tidak melebihi 90% tinggi layar */
    overflow-y: auto;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

/* Container Tabel (dengan scrollbar horizontal jika diperlukan) */
.table-container {
    width: 100%;
    overflow-x: auto;
}

/* Tabel */
.table {
    width: 100%;
    min-width: 500px;  /* Lebar minimum tabel */
    max-width: 100%;
    min-height: 200px; /* Tinggi minimum tabel */
    max-height: 500px; /* Tinggi maksimum tabel */
    overflow-y: auto;
    display: block; /* Agar scrollbar aktif */
    border-collapse: collapse;
}

/* Accordion */
.accordion, .accordion-body {
    width: 85%;
}

/* Header Tabel */
.table th {
    background-color: #343a40;  /* Sama dengan warna sidebar */
    color: white;
    padding: 8px;
    text-align: left;
}

/* Sel Tabel */
.table td {
    padding: 8px;
    border-top: 1px solid #ddd;
}

/* Baris Ganjil & Genap */
.table tr:nth-child(odd) {
    background-color: #f8f9fa;
}

.table tr:nth-child(even) {
    background-color: #ffffff;
}

</style>
@endsection
