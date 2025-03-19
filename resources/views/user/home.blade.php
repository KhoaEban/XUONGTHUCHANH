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
        width: 1500px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
        height: 438px;
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
</style>

@section('content')
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
    </div>

    <br>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
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


            function autoplay() {
                setInterval(() => {
                    showSlides(slideIndex + 1);
                }, 10000);
            }

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
