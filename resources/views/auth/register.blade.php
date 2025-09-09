<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Aplikasi Laundry Modern</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* Menggunakan CSS yang SAMA PERSIS dengan halaman Login untuk Konsistensi */
        :root {
            --primary-color: #007BFF;
            --primary-hover: #0056b3;
            --secondary-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #333;
            --input-border: #ced4da;
            --input-focus: #80bdff;
            --error-color: #e74c3c;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem 0; /* Menambahkan padding agar tidak terpotong di layar kecil */
            margin: 0;
            background: linear-gradient(135deg, #e0f7fa 0%, #d1e5f0 100%);
        }

        .card {
            background: var(--card-bg);
            padding: 2.5rem 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid #e9ecef;
        }
        
        .app-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23007BFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-3.5 19.5A10 10 0 0 0 12 2z"></path><path d="M22 12c0 5.52-4.48 10-10 10"></path></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .card h2 {
            margin-bottom: 2rem;
            color: var(--text-color);
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.2rem; /* Sedikit mengurangi margin untuk form yang lebih panjang */
            text-align: left;
        }
        
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }

        input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        input.password-field {
            padding-right: 2.5rem;
        }
        
        input:focus {
            outline: none;
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .toggle-password:hover { color: #333; }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 1rem;
        }

        button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
        }

        .error {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .login-link a:hover {
            text-decoration: underline;
            color: var(--primary-hover);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="app-icon"></div>
        <h2>Buat Akun Baru</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap Anda">
                @error('nama') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" required placeholder="Contoh: 08123456789">
                @error('nomor_hp') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="password-field" required placeholder="Buat password Anda">
                    <span class="toggle-password" data-target="password">
                        <svg class="eye-icon-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <svg class="eye-icon-open" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    </span>
                </div>
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="password-field" required placeholder="Ketik ulang password">
                     <span class="toggle-password" data-target="password_confirmation">
                        <svg class="eye-icon-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <svg class="eye-icon-open" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    </span>
                </div>
            </div>

            <button type="submit">Daftar</button>
        </form>
        <div class="login-link">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>

    <script>
        // Membuat fungsionalitas ikon mata bekerja untuk SEMUA input password
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');

        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function () {
                const targetInputId = this.getAttribute('data-target');
                const targetInput = document.getElementById(targetInputId);
                
                const eyeIconClosed = this.querySelector('.eye-icon-closed');
                const eyeIconOpen = this.querySelector('.eye-icon-open');

                // Cek tipe input saat ini
                const type = targetInput.getAttribute('type') === 'password' ? 'text' : 'password';
                targetInput.setAttribute('type', type);

                // Ganti ikon mata berdasarkan tipe input
                if (type === 'password') {
                    eyeIconClosed.style.display = 'block';
                    eyeIconOpen.style.display = 'none';
                } else {
                    eyeIconClosed.style.display = 'none';
                    eyeIconOpen.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>