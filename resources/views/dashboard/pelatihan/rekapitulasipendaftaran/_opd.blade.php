<table class="table table-hover align-middle mb-0">
    <thead class="bg-light-primary">
        <tr>
            <th class="text-center col-no">No</th>
            <th>OPD</th>
            <th class="text-center col-jumlah">Jumlah Usulan</th>
        </tr>
    </thead>
    <tbody id="opd-table">
        @forelse($rekapOPD as $item)
            <tr class="border-bottom">
                <td class="text-center col-no">
                    {{ ($rekapOPD->currentPage() - 1) * $rekapOPD->perPage() + $loop->iteration }}
                </td>
                <td>{{ $item->opd }}</td>
                <td class="text-center col-jumlah">
                    @php
                        $jumlah = $item->jumlah_usulan;

                        if ($jumlah == 0) {
                            $badgeClass = 'bg-light text-dark'; // 0 usulan
                        } elseif ($jumlah >= 1 && $jumlah <= 25) {
                            $badgeClass = 'bg-primary text-white'; // 1-5 usulan
                        } elseif ($jumlah >= 26 && $jumlah <= 75) {
                            $badgeClass = 'bg-warning text-dark'; // 6-10 usulan
                        } elseif ($jumlah >= 76 && $jumlah <= 200) {
                            $badgeClass = 'bg-warning text-white'; // 11-20 usulan (warna lebih gelap)
                        } elseif ($jumlah >= 201 && $jumlah <= 400) {
                            $badgeClass = 'bg-orange text-white'; // 21-50 usulan
                        } else {
                            $badgeClass = 'bg-danger text-white'; // 51+ usulan
                        }
                    @endphp
                    <span class="badge rounded-pill {{ $badgeClass }}">{{ $jumlah }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center py-4">Tidak ada data OPD.</td>
            </tr>
        @endforelse
    </tbody>

    <!-- Pagination -->
    <tfoot>
        <tr id="loading-spinner" class="d-none">
            <td colspan="3" class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Memuat...</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div id="pagination-wrapper-opd" class="px-5 py-3">
                    {{ $rekapOPD->links('pagination::bootstrap-5') }}
                </div>
            </td>
        </tr>
    </tfoot>
</table>
