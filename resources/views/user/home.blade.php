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

    .card {
        transition: transform 0.2s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.213);
        border: none;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .news-card {
        background-color: white;
    }

    .news-img {
        border-radius: 15px;
        width: 752.766px;
        height: 426px;
        overflow: hidden;
    }

    .news-content {
        padding: 0 15px;
    }

    .carousel-item {
        background-color: #fff;
        width: 478px;
    }

    .carousel-item img {
        /* bo tròn phía trên */
        border-radius: 15px 15px 0 0;
        height: 318.656px;
    }

    .carousel-item:hover {
        transform: scale(1.05);
    }

    .carousel_caption {
        padding: 15px;
    }

    .carousel_caption h5 {
        font-size: 15px;
    }
</style>

@section('content')
    <ul class="tag-slider slick-slider">
        <div class="slick-list draggable">
            <div class="slick-track" style="opacity: 1; width: auto; transform: translate3d(0px, 0px, 0px);">
                @foreach ($categories as $category)
                    <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                @endforeach
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
                <div class="col-3">
                    <div class="card">
                        <a href="{{ route('course') }}" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card-header d-flex align-items-center" style="background-color: #E7E7E7">
                <h1 class="text-white h5 bg-danger px-3 py-2 m-0 custom-header">
                    Tin tức <i class="fas fa-bell mx-2" style="font-size: 20px"></i>
                </h1>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="news-card d-flex align-items-start">
                        <div class="news-img-container">
                            <img class="news-img"
                                src="https://elearning-hcm-edu-vn.s3.hcm-1.cloud.cmctelecom.vn/h5p/admin-bach-khoa/images/be8c3300-a70c-11ef-9969-83d8c9d000b6.jpeg"
                                alt="Tin tức">
                        </div>
                        <div class="news-content">
                            <h5 class="fw-bold">NGÀY HỘI "GIÁO DỤC STEM - HÀNH TRÌNH CÔNG DÂN SỐ"</h5>
                            <p class="text-muted small">20/11/2024 14:12:22</p>
                            <p>
                                Sáng ngày 2/11 vừa qua, Bách Khoa Technology đã vinh dự đồng hành cùng Phòng Giáo dục & Đào
                                tạo Quận Tân Phú tổ chức Ngày hội Giáo dục STEM với chủ đề “Hành trình Công dân Số”...
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" style="width: 478px;">
                            <div class="carousel-item active">
                                <div class="">
                                    <img src="https://cdnc.lms360.edu.vn/2024-03-16/8d5ef512-dc46-4b73-afb7-e4b1df0ea1ef/content/assets/images/h5p/hinh-video0003.png"
                                        class="d-block w-100" alt="Slide 2">
                                </div>
                                <div class="carousel_caption shadow">
                                    <h5>Học sinh trải nghiệm eLearning</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://cdnc.lms360.edu.vn/2024-03-16/8d5ef512-dc46-4b73-afb7-e4b1df0ea1ef/content/assets/images/h5p/hinh-video0008.png"
                                    class="d-block w-100" alt="Slide 3">
                                <div class="carousel_caption">
                                    <h5>Giáo viên nâng cao kỹ năng số</h5>
                                </div>
                            </div>
                            <!-- Nút điều hướng slider -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel"
                                data-bs-slide="prev">
                                {{-- <span class="carousel-control-prev-icon" aria-hidden="false"></span> --}}
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel"
                                data-bs-slide="next">
                                {{-- <span class="carousel-control-next-icon" aria-hidden="false"></span> --}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card-header d-flex align-items-center" style="background-color: #E7E7E7">
                <h1 class="text-white h5 bg-success px-3 py-2 m-0 custom-header">
                    Khóa Học Được Xem Nhiều Nhất
                </h1>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <a href="#" class="card-link text-decoration-none text-dark">
                            <img class="card-img-top"
                                src="{{ asset('image/Forensic-Disability-1220218285-1500x438-1.jpg') }}"
                                alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tên khóa học</h5>
                                <p class="card-text text-secondary">Tên người tại khóa học</p>
                                <div class="d-flex align-items-center text-secondary">
                                    <p class="card-text m-0">4 nội dung</p>
                                    <i class="fas fa-circle mx-2" style="font-size: 10px"></i>
                                    <p class="card-text">10/01/2024</p>
                                </div>
                            </div>
                        </a>
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
            let intervalId; // Lưu ID của interval

            function showSlides(n) {
                slideIndex = (n + 3) % 3;
                slidesWrapper.style.transform = `translateX(-${slideIndex * 100 / 3}%)`;

                // Cập nhật chấm tròn (nếu có)
                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.remove("active");
                }
                dots[slideIndex]?.classList.add("active");
            }

            window.plusSlides = function(n) {
                showSlides(slideIndex + n);
            };

            window.currentSlide = function(n) {
                showSlides(n);
            };

            function autoplay() {
                intervalId = setInterval(() => {
                    showSlides(slideIndex + 1);
                }, 3000); // Giữ ảnh trong 4 giây trước khi chuyển
            }

            function stopAutoplay() {
                clearInterval(intervalId);
            }

            slidesWrapper.addEventListener("mouseenter", stopAutoplay);
            slidesWrapper.addEventListener("mouseleave", autoplay);

            showSlides(slideIndex);
            autoplay();
        });
    </script>
@endsection
