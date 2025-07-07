<div class="tab-content" id="rekapTabContent">
    <div class="tab-pane fade show active" id="pelatihan-tab-pane" role="tabpanel" aria-labelledby="pelatihan-tab"
        tabindex="0">
        <div class="table-responsive" id="pelatihan-container">
            @include('dashboard.pelatihan.rekapitulasipendaftaran._pelatihan', [
                'rekapPelatihan' => $rekapPelatihan,
            ])
        </div>
    </div>
    <div class="tab-pane fade" id="opd-tab-pane" role="tabpanel" aria-labelledby="opd-tab" tabindex="0">
        <div class="table-responsive" id="opd-container">
            @include('dashboard.pelatihan.rekapitulasipendaftaran._opd', [
                'rekapOPD' => $rekapOPD,
                'rekapOPDPagination' => $rekapOPDPagination,
            ])
        </div>
    </div>
</div>
