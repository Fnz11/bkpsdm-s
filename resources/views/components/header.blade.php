<header class="header text-white d-flex justify-content-between align-items-center py-3 shadow-sm">
    <div class="user-info fw-semibold ps-2">
        @auth
            @if (auth()->user()->latestUserPivot->unitKerja->unitkerja->unitkerja === null)
                {{ auth()->user()->refPegawai->name }} ({{ ucfirst(auth()->user()->role) }})
            @else
                {{ auth()->user()->refPegawai->name }} -
                {{ auth()->user()->latestUserPivot->unitKerja->unitkerja->unitkerja ?? '-' }} ({{ ucfirst(auth()->user()->role) }})
            @endif
        @endauth
    </div>

    @auth
        <form action="{{ route('logout') }}" method="POST" class="logout-form mb-0">
            @csrf
            <button type="submit" class="btn btn-light rounded-pill px-3 py-2">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    @endauth
</header>

<!-- Spacer untuk memberi ruang di bawah header tetap -->
<div style="height: 64px;"></div>

<style>
    .header {
        position: fixed;
        top: 0;
        left: 280px;
        width: calc(100% - 280px);
        z-index: 1040;
        transition: all 0.3s ease;
        height: 64px;
        padding: 15px 20px 15px 40px;
        background: linear-gradient(135deg, #1083ff, #30499c);
    }

    .header.expanded {
        left: 60px;
        width: calc(100% - 60px);
    }

    @media (max-width: 768px) {
        .header {
            left: 60px;
            width: calc(100% - 60px);
        }
    }
</style>
