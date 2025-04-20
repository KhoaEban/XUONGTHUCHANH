<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <title>Thanh toán thành công</title>
</head>

<style>
    body {
        overflow: hidden;
        position: relative;

    }

    .confetti-container {
        position: fixed;
        z-index: -1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #ff0;
        /* Màu sắc của bóng hoa giấy */
        opacity: 0.8;
        animation: fall linear infinite;
    }

    .container {
        z-index: 1;
    }

    .layoutss {
        position: relative;
    }

    .back-btn {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }

    @keyframes fall {
        0% {
            transform: translateY(0) rotate(0);
        }

        100% {
            transform: translateY(100vh) rotate(360deg);
        }
    }
</style>

<body style="background-color: black;">
    <div class="mx-auto mt-5 text-center text-white" style="">
        <div class="layoutss shadow-lg p-3 mb-5 rounded w-25 mx-auto"
            style="background-color: rgba(34, 34, 34, 0.72); height: 500px">
            <div class="">
                <h2>Thành công!</h2>
                @if (session('success'))
                    <p>{{ session('success') }}</p>
                @else
                    <p>Bạn đã đăng ký khóa học thành công.</p>
                @endif

                <div id="lottie-animation" style="width: 200px; height: 200px; margin: 0 auto;"></div>
            </div>
            <a href="{{ url('/') }}" class="back-btn text-white px-3 py-2 text-decoration-none"
                style="background-color: rgb(101, 139, 139)"><i class="fas fa-home me-1"></i> Quay về trang chủ</a>
        </div>
    </div>

    <div class="confetti-container"></div>


    <script>
        const confettiContainer = document.querySelector('.confetti-container');

        const maxConfetti = 20; // Giới hạn số lượng bóng hoa giấy

        function createConfetti() {
            if (confettiContainer.children.length < maxConfetti) { // Kiểm tra số lượng hiện có
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw'; // Vị trí ngẫu nhiên
                confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`; // Màu sắc ngẫu nhiên
                confetti.style.animationDuration = Math.random() * 2 + 2 + 's'; // Thời gian rơi ngẫu nhiên
                confettiContainer.appendChild(confetti);

                // Xóa bóng hoa giấy sau khi hoàn thành hiệu ứng
                confetti.addEventListener('animationend', () => {
                    confetti.remove();
                });
            }
        }

        setInterval(createConfetti, 100); // Tạo bóng hoa giấy mới mỗi 100ms
    </script>
    <script>
        const animationContainer = document.getElementById('lottie-animation');
        const animation = lottie.loadAnimation({
            container: animationContainer, // The DOM element to render the animation
            renderer: 'svg', // Render as SVG (alternatives: 'canvas', 'html')
            loop: true, // Loop the animation
            autoplay: true, // Start playing automatically
            path: '{{ asset('js/Animation - 1745160615871.json') }}' // Path to the Lottie JSON file
        });
        // Adjust playback speed (0.5 = slower, 2 = faster)
        animation.setSpeed(0.5); // Makes the animation take 1.4 seconds per loop
    </script>
</body>

</html>
