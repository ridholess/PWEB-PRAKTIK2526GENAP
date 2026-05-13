<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION["login"])) {
    header("Location: ./dashboard.php");
    exit;
}

$error = false;
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["nama_user"] = $row["nama"];
            header("Location: ./dashboard.php");
            exit;
        }
    }
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" type="image/png"
        href="https://res.cloudinary.com/dsirus0pz/image/upload/v1774681310/uty-campus_i8pc7v.png">
    <!-- Tailwind Css -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Font Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #F7EDE8;
            font-family: 'Montserrat Alternates', sans-serif;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="flex items-center justify-end px-6 py-4">
        <!-- <a href="./" id="btn-close" class="text-black hover:opacity-60 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a> -->

        <span id="btn-daftar"
            class="bg-[#000] text-white text-sm font-semibold px-6 py-3 rounded-md cursor-pointer shadow-[4px_4px_0px_#E8715A] hover:shadow-[0px_0px_0px] transition-all duration-300 ease-in-out">
            Daftar Sekarang
        </span>
    </nav>
    <!-- End of Navbar -->

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center px-4 mt-16">
        <div class="w-full max-w-md">

            <h1 class="text-center text-4xl font-black italic tracking-widest text-black mb-10">
                Loginkan
            </h1>

            <form id="form-login" action="" method="POST" class="space-y-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger font-italic text-center" role="alert">
                        Email / Password salah!
                    </div>
                <?php endif; ?>

                <div>
                    <input id="input-email" type="text" name="username" placeholder="Username" autocomplete="off" required
                        class="w-full bg-white rounded-md border-2 border-[#000] shadow-[4px_4px_0px_0px_rgba(0,0,0,0.80)] active:shadow-[0px_0px_0px] px-5 py-4 pr-14 text-black placeholder-[#000] text-base outline-none transition-all duration-300 ease-in-out" />
                </div>

                <div class="relative">
                    <input id="input-password" type="password" name="password" placeholder="Password" autocomplete="off"
                        required
                        class="w-full bg-white rounded-md border-2 border-[#000] shadow-[4px_4px_0px_0px_rgba(0,0,0,0.80)] active:shadow-[0px_0px_0px] px-5 py-4 pr-14 text-black placeholder-[#000] text-base outline-none transition-all duration-300 ease-in-out" />
                    <button type="button" id="btn-toggle-password" onclick="togglePassword()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#000] hover:text-black transition-colors cursor-pointer"
                        aria-label="Tampilkan password">
                        <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.348-3.879M6.878 6.878A9.96 9.96 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.86 3.048M6.878 6.878L3 3m3.878 3.878l10.243 10.243M3 3l18 18" />
                        </svg>
                    </button>
                </div>

                <div class="text-left">
                    <span id="link-lupa-password"
                        class="text-[#E8715A] text-sm font-semibold hover:underline cursor-pointer">
                        Lupa password?
                    </span>
                </div>

                <div class="pt-2">
                    <button type="submit" name="submit" type="password" id="btn-masuk"
                        class="w-full bg-[#000] text-white font-black text-base tracking-widest py-4 rounded-md cursor-pointer shadow-[6px_6px_0px_#E8715A] hover:shadow-[0px_0px_0px] transition-all duration-300 ease-in-out">
                        Masuk
                    </button>
                </div>

            </form>

            <p class="text-center text-[#7A6E6A] text-sm mt-8 leading-relaxed">
                Dengan masuk ke <span class="italic">Responsi Week 7</span>, anda menyetujui
                <span id="link-syarat" class="text-[#E8715A] font-semibold hover:underline cursor-pointer">Syarat dan
                    Ketentuan</span>
                serta
                <span id="link-privasi" class="text-[#E8715A] font-semibold hover:underline cursor-pointer">Kebijakan
                    Privasi</span>
                kami.
            </p>

        </div>
    </main>
    <!-- End of Main Content -->

    <!-- Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById('input-password');
            const iconEye = document.getElementById('icon-eye');
            const iconEyeOff = document.getElementById('icon-eye-off');

            if (input.type === 'password') {
                input.type = 'text';
                iconEye.classList.add('hidden');
                iconEyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconEye.classList.remove('hidden');
                iconEyeOff.classList.add('hidden');
            }
        }
    </script>
    <!-- End of Script -->

</body>

</html>