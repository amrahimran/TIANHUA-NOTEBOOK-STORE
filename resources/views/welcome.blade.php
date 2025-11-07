<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tian Hua| Login</title>
    @vite('resources/css/app.css')
    <style>
        /* Fullscreen container for slideshow */
        #slideshow-container {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Behind the text */
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        /* Overlay text */
        .overlay {
            position: relative;
            z-index: 10;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
        }
    </style>
</head>
<body style="background-image: url('{{ asset('images/login-img.jpg') }}');"">

    <!-- Slideshow background -->
    <div id="slideshow-container">
        <div class="slide active" style="background-image: url('{{ asset('images/bg1.jpg') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('images/bg2.jpg') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('images/bg3.jpg') }}')"></div>
        <div class="slide" style="background-image: url('{{ asset('images/bg4.jpg') }}')"></div>
    </div>

    <!-- Overlay content -->
    <div class="overlay">
        <img src="{{ asset('images/transparentlogo.png') }}" alt="Tian Hua Logo">
        <h1 class=" text-5xl lg:text-6xl font-semibold mb-6">Welcome to <br> <b class="text-[#49608a] font-semibold">Tian Hua</b></h1>
        <p class="text-lg lg:text-xl mb-8">Discover cute journals, notebooks, and stationery.</p>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="button">Login</a>
            <a href="{{ route('register') }}" class="button">Register</a>
        </div>
    </div>

    <!-- JS for slideshow -->
    <script>
        const slides = document.querySelectorAll('.slide');
        let current = 0;

        setInterval(() => {
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }, 2000); // Change image every 2 seconds
    </script>

</body>
</html>
