<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang di Aplikasi Laundry</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --light-bg: #f8f9fa;
            --dark-text: #212529;
            --white-color: #ffffff;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.07);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            margin: 0;
            line-height: 1.7;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Navigation */
        .navbar {
            background: var(--white-color);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: padding 0.3s ease;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }
        .nav-links a {
            color: var(--secondary-color);
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-links a:hover {
            color: var(--primary-color);
        }

        /* Hero Section */
        .hero {
            background-color: var(--light-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding-top: 60px; /* Offset for fixed navbar */
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-bottom: 2.5rem;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero .logo {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .actions a {
            text-decoration: none;
            color: #fff;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }
        .btn-login {
            background-color: var(--primary-color);
            margin-right: 1rem;
        }
        .btn-login:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
        }
        .btn-register {
            background-color: var(--success-color);
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2);
        }
        .btn-register:hover {
            background-color: #157347;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(25, 135, 84, 0.3);
        }

        /* Section Styling */
        .section {
            padding: 80px 0;
        }
        .section-title {
            text-align: center;
            margin-bottom: 60px;
            font-size: 2.5rem;
            font-weight: 700;
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            text-align: center;
        }
        .feature-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .feature-card .icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* How it Works Section */
        #how-it-works {
            background-color: var(--light-bg);
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            text-align: center;
        }
        .step-card .step-number {
            width: 70px;
            height: 70px;
            background-color: var(--primary-color);
            color: #fff;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        /* Testimonials Section */
        .testimonial-card {
            background: var(--white-color);
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            margin: 0 15px;
        }
        .testimonial-text {
            font-style: italic;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }
        .author-info h4 {
            margin: 0;
            font-size: 1.1rem;
        }
        .author-info p {
            margin: 0;
            color: var(--secondary-color);
        }


        /* Footer */
        .footer {
            background-color: var(--dark-text);
            color: #f8f9fa;
            padding: 40px 0;
            text-align: center;
        }
        .footer p {
            margin: 0;
            color: #adb5bd;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="nav-brand"><i class="fas fa-tshirt"></i> SIMANDI</a>
            <div class="nav-links">
                <a href="#features">Fitur</a>
                <a href="#how-it-works">Cara Kerja</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container">
            <div class="logo">
                <i class="fas fa-tshirt"></i>
            </div>
            <h1>Aplikasi Laundry Modern</h1>
            <p>Solusi terbaik untuk cucian bersih dan rapi tanpa repot. Lacak pesanan Anda secara real-time dan nikmati kemudahan dalam genggaman.</p>

            @if (Route::has('login'))
                <div class="actions">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-register">Daftar Sekarang</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="section">
        <div class="container">
            <h2 class="section-title">Kenapa Memilih Kami?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-mobile-alt"></i></div>
                    <h3>Pemesanan Mudah</h3>
                    <p>Pesan layanan laundry kapan saja dan di mana saja langsung dari aplikasi modern kami.</p>
                </div>
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
                    <h3>Lacak Real-Time</h3>
                    <p>Pantau status cucian Anda, dari penjemputan, proses cuci, hingga pengantaran kembali.</p>
                </div>
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Kualitas Terjamin</h3>
                    <p>Kami menggunakan deterjen premium dan proses yang higienis untuk hasil terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section id="how-it-works" class="section">
        <div class="container">
            <h2 class="section-title">4 Langkah Mudah</h2>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Buat Pesanan</h3>
                    <p>Pilih layanan yang Anda butuhkan melalui aplikasi dalam hitungan detik.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Kami Jemput</h3>
                    <p>Tim kami akan menjemput cucian kotor Anda sesuai jadwal yang ditentukan.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Kami Proses</h3>
                    <p>Pakaian Anda dicuci, dikeringkan, dan disetrika oleh tim profesional kami.</p>
                </div>
                 <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Kami Antar</h3>
                    <p>Cucian bersih dan wangi kami antar kembali langsung ke depan pintu Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="section">
        <div class="container">
            <h2 class="section-title">Apa Kata Pelanggan Kami</h2>
            <div class="features-grid">
                 <div class="testimonial-card">
                    <p class="testimonial-text">"Aplikasinya sangat membantu! Saya bisa pesan laundry sambil kerja dan lacak prosesnya. Hasilnya juga selalu bersih dan wangi. Recommended!"</p>
                    <div class="testimonial-author">
                        <img src="https://i.pravatar.cc/150?img=1" alt="Author">
                        <div class="author-info">
                            <h4>Budi Santoso</h4>
                            <p>Karyawan Swasta</p>
                        </div>
                    </div>
                </div>
                 <div class="testimonial-card">
                    <p class="testimonial-text">"Sebagai ibu rumah tangga, aplikasi ini benar-benar penyelamat. Tidak perlu lagi repot antar-jemput laundry. Semuanya jadi praktis."</p>
                    <div class="testimonial-author">
                         <img src="https://i.pravatar.cc/150?img=5" alt="Author">
                        <div class="author-info">
                            <h4>Siti Aminah</h4>
                            <p>Ibu Rumah Tangga</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} LaundryKita. Dibuat dengan ❤️ untuk Ujikom.</p>
        </div>
    </footer>

</body>
</html>

