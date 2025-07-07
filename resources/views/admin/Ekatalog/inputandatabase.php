<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatihan Management</title>
</head>
<body>
    <h1>Pelatihan Management</h1>

    <!-- Form untuk Input Data -->
    <form action="{{ url('pelatihan') }}" method="POST">
        @csrf
        <label for="nama_pelatihan">Nama Pelatihan:</label>
        <input type="text" name="nama_pelatihan" id="nama_pelatihan" required>
        <label for="tahun">Tahun:</label>
        <input type="text" name="tahun" id="tahun" required>
        <button type="submit">Simpan</button>
    </form>

    <h2>Data Pelatihan</h2>

    <!-- Menampilkan Data Pelatihan -->
    <table border="1">
        <thead>
            <tr>
                <th>Nama Pelatihan</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelatihan as $p)
                <tr>
                    <td>{{ $p->nama_pelatihan }}</td>
                    <td>{{ $p->tahun }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Jenis Pelatihan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Jenis Pelatihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jenisPelatihan as $j)
                <tr>
                    <td>{{ $j->nama_jenis_pelatihan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Metode Pelatihan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Metode Pelatihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($metodePelatihan as $m)
                <tr>
                    <td>{{ $m->nama_metode }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Golongan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Golongan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($golongan as $g)
                <tr>
                    <td>{{ $g->nama_golongan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Unit Kerja</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Unit Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unit_Kerja as $u)
                <tr>
                    <td>{{ $u->unit_kerja }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
