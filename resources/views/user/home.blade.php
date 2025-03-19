@extends('layouts.master')

<style>
    * {
        box-sizing: border-box;
    }

    /* Side bar */
    body {
        font-family: Arial, sans-serif;
    }

    .slideshow-container {
        margin: 0 auto;
        position: relative;
        overflow: hidden;
        /* height: 438px; */
    }

    .slides-wrapper {
        display: flex;
        width: 300%;
        transition: transform 0.6s ease-in-out;
    }

    .mySlides {
        width: 100%;
        flex: 1;
    }

    /* Fix chiều cao hình ảnh */
    .mySlides img {
        width: 100%;
        object-fit: cover;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        margin-top: -22px;
        padding: 16px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        z-index: 10;
        text-decoration: none;
    }

    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .active,
    .dot:hover {
        background-color: #717171;
    }

    .custom-header {
        width: fit-content;
        /* Để phần nền xanh chỉ bọc quanh chữ */
        clip-path: polygon(0 0, 95% 0, 100% 50%, 95% 100%, 0 100%);
        /* Tạo góc cắt */
    }
</style>

@section('content')
    <ul class="tag-slider slick-slider">
        <div class="slick-list draggable">
            <div class="slick-track" style="opacity: 1; width: auto; transform: translate3d(0px, 0px, 0px);">
                <li><a href="/ket-qua?c=0&s=28&t=">Hoạt động trải nghiệm</a></li>
                <li><a href="/ket-qua?c=0&s=29&t=">Giáo dục thể chất</a></li>
                <li><a href="/ket-qua?c=0&s=30&t=">Khoa học tự nhiên</a></li>
                <li><a href="/ket-qua?c=0&s=31&t=">Giáo dục quốc phòng</a></li>
                <li><a href="/ket-qua?c=0&s=32&t=">Kinh tế và pháp luật</a></li>
                <li><a href="/ket-qua?c=0&s=35&t=">Lịch sử và Địa lí</a></li>
                <li><a href="/ket-qua?c=0&s=36&t=">Âm nhạc và Mĩ thuật</a></li>
                <li><a href="/ket-qua?c=0&s=37&t=">Tiếng Việt</a></li>
                <li><a href="/ket-qua?c=0&s=38&t=">Giáo dục địa phương</a></li>
                <li><a href="/ket-qua?c=0&s=39&t=">Hướng nghiệp</a></li>
                <li><a href="/ket-qua?c=0&s=40&t=">Thể dục</a></li>
                <li><a href="/ket-qua?c=0&s=33&t=">Môn khác</a></li>
                <li><a href="/ket-qua?c=0&s=37&t=">Tiếng Việt</a></li>
                <li><a href="/ket-qua?c=0&s=38&t=">Giáo dục địa phương</a></li>
                <li><a href="/ket-qua?c=0&s=39&t=">Hướng nghiệp</a></li>
                <li><a href="/ket-qua?c=0&s=40&t=">Thể dục</a></li>
                <li><a href="/ket-qua?c=0&s=33&t=">Môn khác</a></li>
            </div>
        </div>
    </ul>
    <!-- Nút điều hướng slider -->
    <div class="tag-slider-prev">
        <div class="slider-btn"><i class="fas fa-angle-left"></i></div>
    </div>
    <div class="tag-slider-next">
        <div class="slider-btn"><i class="fas fa-angle-right"></i></div>
    </div>

    <div class="slideshow-container">
        <div class="slides-wrapper">
            <div class="mySlides">
                <img class="image" src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}">
            </div>

            <div class="mySlides">
                <img class="image" src="{{ asset('image/Positive-Behaviour-Support-165667163-1500x438-1.jpg') }}">
            </div>

            <div class="mySlides">
                <img class="image" src="{{ asset('image/e-learning-concept-with-online-education-vector-55629215.jpg') }}">
            </div>
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        {{-- <div style="text-align:center">
            <span class="dot" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div> --}}
    </div>
    <br>
    {{-- Hiện thị các khóa học mới --}}
    <div class="">
        <div class="row">
            <div class="col-12">
                <div class="card-header d-flex align-items-center" style="background-color: #E7E7E7">
                    <h1 class="text-white h5 bg-success px-3 py-2 m-0 custom-header">
                        Khóa Học Được Tạo Mới Nhất
                    </h1>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <div class="card shadow">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card shadow">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card shadow">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let slideIndex = 0;
            let slidesWrapper = document.querySelector(".slides-wrapper");
            let dots = document.getElementsByClassName("dot");

            function showSlides(n) {
                slideIndex = (n + 3) % 3;
                slidesWrapper.style.transform = `translateX(-${slideIndex * 100 / 3}%)`;

                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.remove("active");
                }
                dots[slideIndex].classList.add("active");
            }

            window.plusSlides = function(n) {
                showSlides(slideIndex + n);
            };

            window.currentSlide = function(n) {
                showSlides(n);
            };


            // function autoplay() {
            //     setInterval(() => {
            //         showSlides(slideIndex + 1);
            //     }, 8000);
            // }

            slidesWrapper.addEventListener("mouseenter", () => {
                clearInterval();
            });

            slidesWrapper.addEventListener("mouseleave", () => {
                autoplay();
            })

            showSlides(slideIndex);
            autoplay();
        });
    </script>
@endsection
