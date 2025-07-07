<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKPSDM Surakarta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 900px;
        }

        .header {
            margin-bottom: 30px;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 10px;
        }

        .logo-container img {
            height: auto;
        }

        .logo-container img:first-child {
            width: 100px;
        }

        .logo-container img:last-child {
            width: 200px;
            margin-left: -245px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 80px;
        }

        .header p {
            font-size: 18px;
            color: #666;
            margin-top: 50px;
        }

        .options {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 200px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card i {
            font-size: 40px;
            color: #6a00c7;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 20px;
            color: #333;
        }

        /* Modal Login */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: left;
        }

        .close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            padding: 10px;
            border: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            background: #28a745;
            color: white;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('images/surakarta.png') }}" alt="Logo Surakarta">
                <span class="logo-text">KOTA SURAKARTA</span>
                <img src="{{ asset('images/bkpsdm.png') }}" alt="Logo BKPSDM">
            </div>
            <p>Pilih peran Anda untuk melanjutkan</p>
        </div>
        <div class="options">
            <div class="card" onclick="openModal('alumni')">
                <i class="fa-solid fa-user-graduate"></i>
                <h3>Alumni</h3>
            </div>
            <div class="card" onclick="openModal('atasan')">
                <i class="fa-solid fa-user-tie"></i>
                <h3>Atasan</h3>
            </div>
            <div class="card" onclick="openModal('rekan')">
                <i class="fa-solid fa-users"></i>
                <h3>Rekan Kerja</h3>
            </div>
            </div>
            </div>
            
            <!-- Modal Login -->
            <div class="modal" id="loginModal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3 id="modalTitle">Login</h3>
                    <form id="loginForm">
                        @csrf
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip" required>
                        </div>
                       
                <button type="submit" class="btn">Login</button>
                </form>
        </div>
    </div>

    <script>
        function openModal(role) {
            document.getElementById("modalTitle").innerText = "Login " + role.charAt(0).toUpperCase() + role.slice(1);
            document.getElementById("loginModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("loginModal").style.display = "none";
        }

        $(document).ready(function() {
            $("#loginForm").submit(function(event) {
    event.preventDefault();

    let nip = $("#nip").val();
    let role = $("#modalTitle").text().replace("Login ", "").toLowerCase(); 

    console.log("Mengirim data:", { nip: nip, role: role }); // Debugging

    $.ajax({
        url: "{{ route('auth.login') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            nip: nip,
            role: role
        },
        success: function(response) {
            console.log("Response:", response); // Debugging
            if (response.success) {
                window.location.href = response.redirect;
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText); // Debugging
            alert("Terjadi kesalahan, coba lagi.");
        }
    });
});

});
    </script>
</body>
</html>
