<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKPSDM Surakarta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            overflow-x: hidden; Menghilangkan scroll horizontal
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            text-align: center;
        }

        .topbar {
    background: transparent; /* Menghapus background */
    padding: 20px 0;
    font-size: 14px;
    position: absolute;
    width: 100%;
    z-index: 1000;
    margin-left: 800px;
}


        .topbar .contact-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
            font-size: 18px;
        }

        .topbar .social-icons a {
            color: #6c757d;
            margin-left: 30px;
            text-decoration: none;
            font-size: 18px;
        }

        .header {
            padding: 80px 20px;
            background: linear-gradient(135deg, #6a00c7, #b30059);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 50% 20px;
            border-bottom-right-radius: 50% 20px;
        }

        .header::before, .header::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::before {
            top: -50px;
            left: -50px;
        }

        .header::after {
            bottom: -50px;
            right: -50px;
        }

        .header img {
            width: 100px;
            z-index: 2;
        }

        .header h1 {
            font-size: 50px;
            font-weight: bold;
            margin: 10px 0 5px;
            z-index: 2;
            position: relative;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .sub-header {
            font-size: 22px;
            font-weight: 400;
            z-index: 2;
            position: relative;
        }

        .grid-container {
            margin-top: 40px;
        }

        .grid-item {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .grid-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .grid-item i {
            font-size: 40px;
            color: #6a00c7;
            margin-bottom: 15px;
        }

        .grid-item p {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="topbar">
    <!-- <div class="container contact-info">
        <div>
            <i class="fas fa-envelope"></i> bkpsdm@surakarta.go.id
            <i class="fas fa-phone"></i> (0271) 642020 Ext. 465
        </div> -->
    <div class="social-icons">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
</div>
</div>

<div class="header text-center">
        <img src="images/surakarta.png" alt="Dinas Surakarta Logo">
        <h1>BKPSDM</h1>
        <p class="sub-header">KOTA SURAKARTA</p>
    </div>

    <div class="container grid-container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="grid-item"><i class="fas fa-chart-line"></i>
                    <p>AKPK</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item"><i class="fas fa-qrcode"></i>
                    <p>SOLOWASIS</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item"><i class="fas fa-file-alt"></i>
                    <p>IP ASN</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item" onclick="window.location='{{ route('umum.usulan') }}'">
                    <i class="fas fa-folder"></i>
                    <p>USULAN BROSUR</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item" onclick="window.location='{{ route('umum2.ekatalog') }}'">
                    <i class="fas fa-book"></i>
                    <p>E-Katalog Pelatihan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item" onclick="window.location='{{ route('umum3.direktori') }}'">
                    <i class="fas fa-database"></i>
                    <p>DIREKTORI PELATIHAN</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item"><i class="fas fa-box"></i>
                    <p>PBJ</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid-item" onclick="window.location='{{ route('umum4.homepage') }}'">
                    <i class="fas fa-clipboard-check"></i>
                    <p>EVALUASI</p>
                </div>
                </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>