<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontaswesome.min.css') }}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <!-- Nice Select  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <!-- Style Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Responsive Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">


</head>

<body>

    <!-- ===================================================================================
                                 Header Area Start
   =====================================================================================-->
    <header>
        <div class="header-area">
            <div class="container">
                <div class="header-main">
                    <div class="header-menu">
                        <div class="header-logo">
                            <a href="index.html"><img src="assets/images/Logo.png" alt="logo-img" /></a>
                        </div>
                        <div class="header-nav">
                            <nav>
                                <ul>
                                    <li><a href="#doctor">Find Doctors</a></li>
                                    <li><a href="#service">Services</a></li>
                                    <li><a href="#consult">Consult Online</a></li>
                                    <li><a href="#about">About</a></li>
                                    <li><a href="#contact">Contact</a></li>
                                    @auth
                                        @php
                                            $role = auth()->user()->role;
                                        @endphp

                                        @if ($role === 0)
                                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        @elseif ($role === 1)
                                            <li><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                                        @elseif ($role === 2)
                                            <li><a href="{{ route('patient.dashboard') }}">Dashboard</a></li>
                                        @elseif ($role === 3)
                                            <li><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                        @endif
                                    @else
                                        <li><a href="{{ route('login') }}">Log in</a></li>
                                    @endauth

                                    <li class="mobile-headerbtn"><a class="tele" href="tel:1800-123-4567"><svg
                                                width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.6667 11.28V13.28C14.6675 13.4657 14.6294 13.6494 14.555 13.8195C14.4807 13.9897 14.3716 14.1424 14.2348 14.2679C14.0979 14.3934 13.9364 14.489 13.7605 14.5485C13.5847 14.6079 13.3983 14.63 13.2134 14.6133C11.1619 14.3904 9.19137 13.6894 7.46004 12.5667C5.84926 11.5431 4.48359 10.1774 3.46004 8.56665C2.33336 6.82745 1.6322 4.84731 1.41337 2.78665C1.39671 2.60229 1.41862 2.41649 1.4777 2.24107C1.53679 2.06564 1.63175 1.90444 1.75655 1.76773C1.88134 1.63102 2.03324 1.52179 2.20256 1.447C2.37189 1.37221 2.55493 1.33349 2.74004 1.33332H4.74004C5.06357 1.33013 5.37723 1.4447 5.62254 1.65567C5.86786 1.86664 6.02809 2.15961 6.07337 2.47998C6.15779 3.12003 6.31434 3.74847 6.54004 4.35332C6.62973 4.59193 6.64915 4.85126 6.59597 5.10057C6.5428 5.34988 6.41928 5.57872 6.24004 5.75998L5.39337 6.60665C6.34241 8.27568 7.72434 9.65761 9.39337 10.6067L10.24 9.75998C10.4213 9.58074 10.6501 9.45722 10.8994 9.40405C11.1488 9.35088 11.4081 9.37029 11.6467 9.45998C12.2516 9.68568 12.88 9.84224 13.52 9.92665C13.8439 9.97234 14.1396 10.1355 14.3511 10.385C14.5625 10.6345 14.6748 10.953 14.6667 11.28Z"
                                                    stroke="#627384" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg> 1800-123-4567</a>
                                    </li>
                                    <li class="mobile-headerbtn"><a class="custom_btn" href="#"><svg
                                                width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.33337 1.33331V3.99998" stroke="white" stroke-width="1.33333"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.6666 1.33331V3.99998" stroke="white" stroke-width="1.33333"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M12.6667 2.66669H3.33333C2.59695 2.66669 2 3.26364 2 4.00002V13.3334C2 14.0697 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0697 14 13.3334V4.00002C14 3.26364 13.403 2.66669 12.6667 2.66669Z"
                                                    stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M2 6.66669H14" stroke="white" stroke-width="1.33333"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg> Book Appointment</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-button">
                            <a class="custom_btn" href="#"><svg width="16" height="16" viewBox="0 0 16 16"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33337 1.33331V3.99998" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6666 1.33331V3.99998" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.6667 2.66669H3.33333C2.59695 2.66669 2 3.26364 2 4.00002V13.3334C2 14.0697 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0697 14 13.3334V4.00002C14 3.26364 13.403 2.66669 12.6667 2.66669Z"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 6.66669H14" stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>Book Appointment</a>

                            <a class="tele" href="tel:1800-123-4567"><svg width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.6667 11.28V13.28C14.6675 13.4657 14.6294 13.6494 14.555 13.8195C14.4807 13.9897 14.3716 14.1424 14.2348 14.2679C14.0979 14.3934 13.9364 14.489 13.7605 14.5485C13.5847 14.6079 13.3983 14.63 13.2134 14.6133C11.1619 14.3904 9.19137 13.6894 7.46004 12.5667C5.84926 11.5431 4.48359 10.1774 3.46004 8.56665C2.33336 6.82745 1.6322 4.84731 1.41337 2.78665C1.39671 2.60229 1.41862 2.41649 1.4777 2.24107C1.53679 2.06564 1.63175 1.90444 1.75655 1.76773C1.88134 1.63102 2.03324 1.52179 2.20256 1.447C2.37189 1.37221 2.55493 1.33349 2.74004 1.33332H4.74004C5.06357 1.33013 5.37723 1.4447 5.62254 1.65567C5.86786 1.86664 6.02809 2.15961 6.07337 2.47998C6.15779 3.12003 6.31434 3.74847 6.54004 4.35332C6.62973 4.59193 6.64915 4.85126 6.59597 5.10057C6.5428 5.34988 6.41928 5.57872 6.24004 5.75998L5.39337 6.60665C6.34241 8.27568 7.72434 9.65761 9.39337 10.6067L10.24 9.75998C10.4213 9.58074 10.6501 9.45722 10.8994 9.40405C11.1488 9.35088 11.4081 9.37029 11.6467 9.45998C12.2516 9.68568 12.88 9.84224 13.52 9.92665C13.8439 9.97234 14.1396 10.1355 14.3511 10.385C14.5625 10.6345 14.6748 10.953 14.6667 11.28Z"
                                        stroke="#627384" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg> 1800-123-4567</a>

                        </div>
                    </div>
                    <div class="mobile-menu">
                        <div id="nav-icon" class="menu_icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ===================================================================================
                                 Header Area End
   =====================================================================================-->
    <!-- ===================================================================================
                                 Banner Area Start
   =====================================================================================-->
    <section class="banner-area">
        <div class="container">
            <div class="banner-content">
                <div class="banner-left">
                    <p class="banner-alert mb-4"><img src="assets/images/banner-alert-icon.svg"
                            alt="">Trusted by 10 Lakh+ Patients</p>
                    <h1 class="heading1 mb-4">Book Doctor <br> <span>Appointments</span> <br> Instantly</h1>
                    <p class="font20 mb-4">Find trusted doctors, clinics, and hospitals near you. Online & in-clinic
                        consultations available 24/7.</p>

                    <div class="banner-form mb-4">
                        <form>
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" class="form-control" id="location">
                                    <label for="location" class="form-label"><img src="assets/images/location.svg"
                                            alt=""></label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="consulant">
                                    <label for="consulant" class="form-label"><img src="assets/images/consulant.svg"
                                            alt=""></label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="search">
                                    <label for="search" class="form-label"><img src="assets/images/search-gray.svg"
                                            alt=""></label>
                                </div>
                                <div>
                                    <button type="submit" class="btn-search"> <img
                                            src="assets/images/search-white.svg" alt=""> Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex gap-3 flex-wrap flex-md-nowrap mb-4">
                        <button type="submit" class="btn-search lg"> <img src="assets/images/search-white.svg"
                                alt=""> Search Doctors</button>
                        <button type="submit" class="btn-outline "> <img src="assets/images/online-video.svg"
                                alt=""> Consult Online</button>
                    </div>

                    <div class="analysis-content">
                        <div class="single-analysis">
                            <h3 class="heading3 d-flex align-items-center gap-1"><img src="assets/images/varifid.svg"
                                    alt=""> 50K+</h3>
                            <p class="font14">Verified Doctors</p>
                        </div>
                        <div class="single-analysis">
                            <h3 class="heading3 d-flex align-items-center gap-1"><img src="assets/images/ratting.svg"
                                    alt=""> 50K+</h3>
                            <p class="font14">Verified Doctors</p>
                        </div>
                        <div class="single-analysis">
                            <h3 class="heading3 d-flex align-items-center gap-1"><img src="assets/images/time.svg"
                                    alt=""> 50K+</h3>
                            <p class="font14">Verified Doctors</p>
                        </div>
                    </div>
                </div>

                <div class="banner-right">
                    <div class="banner-img">
                        <img src="assets/images/banner-img.png" alt="">
                        <span class="banner-img-alert">🎉 Free First Consultation</span>
                        <div class="banner-flash-message">
                            <div class="d-flex align-items-center gap-2">
                                <img src="assets/images/banner-alert-icon.svg" alt="">
                                <div class="flash-text">
                                    <p class="font16_bold">Secure & Confidential</p>
                                    <p class="font14">Your health data is 100% protected</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================================================================================
                                 Banner Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 Booking Area Start
   =====================================================================================-->

    <div class="top-title-wrap my-4" id="doctor">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            FIND DOCTORS
        </span>
        <span class="line right"></span>
    </div>


    <section class="booking-area section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="heading2 mb-2">Find & Book Top Doctors</h2>
                <p class="font18px">Search from 50,000+ verified doctors across all specialities. Book appointment
                    instantly.</p>
            </div>

            <!-- Filters -->
            <div class="row mb-4 g-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="filter-select">
                        <select class="nice-select">
                            <option data-icon="assets/images/filter-icon.svg">All Filters</option>
                            <option>Item 1</option>
                            <option>Item 2</option>
                            <option>Item 3</option>
                            <option>Item 4</option>
                            <option>Item 5</option>
                        </select>
                    </div>
                    <div>
                        <select class="nice-select">
                            <option>Speciality</option>
                            <option>Cardiologist</option>
                            <option>Dermatologist</option>
                        </select>
                    </div>
                    <div>
                        <select class="nice-select">
                            <option>Location</option>
                            <option>Bangalore</option>
                            <option>Mumbai</option>
                        </select>
                    </div>
                    <div>
                        <select class="nice-select">
                            <option>Availability</option>
                            <option>Today</option>
                            <option>Tomorrow</option>
                        </select>
                    </div>
                    <div>
                        <select class="nice-select">
                            <option>Consultation Type</option>
                            <option>Item 1</option>
                            <option>Item 2</option>
                            <option>Item 3</option>
                            <option>Item 4</option>
                            <option>Item 5</option>
                        </select>
                    </div>
                    <div>
                        <select class="nice-select">
                            <option>Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div>
                        <select class="nice-select">
                            <option>Fee Range</option>
                            <option>Item 1</option>
                            <option>Item 2</option>
                            <option>Item 3</option>
                            <option>Item 4</option>
                            <option>Item 5</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Doctor Card -->
            <div class="doctor-card-main">
                <div class="card border-0 doctor-card mb-4">
                    <div
                        class="card-body p-4 d-flex align-items-stretch justify-content-between flex-md-nowrap flex-wrap gap-4">
                        <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                            <div class="d-flex flex-column justify-content-between">
                                <img src="assets/images/doctors/doctor1.png" class="doctor-img" alt="">
                                <div><span class="badge bg-success"><img src="assets/images/avaiable-time-icon.svg"
                                            alt=""> Available Today</span></div>
                            </div>
                            <div>
                                <h4 class="heading4">Dr. Rajesh Kumar</h4>
                                <p class="font16_bold">General Physician</p>
                                <p class="font14 mb-3">15+ years Experience</p>
                                <div class="d-flex align-items-center gap-2"><span class="doctor-review-badge"><i
                                            class="fa-solid fa-star"></i> 4.9</span> <span class="font14">(2847
                                        reviews)</span></div>
                                <a href="#" class="font14 mb-2 mt-2 d-flex align-items-center gap-2"><i
                                        class="fa-solid fa-location-dot"></i> Apollo Clinic, Koramangala, Bangalore</a>
                                <a href="#"
                                    class="d-inline-flex align-items-center btn-outline-primary-light"><img
                                        src="assets/images/video-icon-primary.svg" alt=""> Video Consultation
                                    Available</a>
                            </div>
                        </div>
                        <div class="text-start text-md-end d-flex flex-column justify-content-between">
                            <div>
                                <p class="font14">Consultation Fee</p>
                                <p class="font20 mb-3 mb-md-0">₹500</p>
                            </div>
                            <a class="custom_btn mt-auto" href="#"><svg width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33337 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6666 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.6667 2.66663H3.33333C2.59695 2.66663 2 3.26358 2 3.99996V13.3333C2 14.0697 2.59695 14.6666 3.33333 14.6666H12.6667C13.403 14.6666 14 14.0697 14 13.3333V3.99996C14 3.26358 13.403 2.66663 12.6667 2.66663Z"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 6.66663H14" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card border-0 doctor-card mb-4">
                    <div
                        class="card-body p-4 d-flex align-items-stretch justify-content-between flex-md-nowrap flex-wrap gap-4">
                        <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                            <div class="d-flex flex-column justify-content-between">
                                <img src="assets/images/doctors/doctor2.png" class="doctor-img" alt="">
                                <div><span class="badge bg-success"><img src="assets/images/avaiable-time-icon.svg"
                                            alt=""> Available Today</span></div>
                            </div>
                            <div>
                                <h4 class="heading4">Dr. Rajesh Kumar</h4>
                                <p class="font16_bold">General Physician</p>
                                <p class="font14 mb-3">15+ years Experience</p>
                                <div class="d-flex align-items-center gap-2"><span class="doctor-review-badge"><i
                                            class="fa-solid fa-star"></i> 4.9</span> <span class="font14">(2847
                                        reviews)</span></div>
                                <a href="#" class="font14 mb-2 mt-2 d-flex align-items-center gap-2"><i
                                        class="fa-solid fa-location-dot"></i> Apollo Clinic, Koramangala, Bangalore</a>
                                <a href="#"
                                    class="d-inline-flex align-items-center btn-outline-primary-light"><img
                                        src="assets/images/video-icon-primary.svg" alt=""> Video Consultation
                                    Available</a>
                            </div>
                        </div>
                        <div class="text-start text-md-end d-flex flex-column justify-content-between">
                            <div>
                                <p class="font14">Consultation Fee</p>
                                <p class="font20 mb-3 mb-md-0">₹500</p>
                            </div>
                            <a class="custom_btn mt-auto" href="#"><svg width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33337 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6666 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.6667 2.66663H3.33333C2.59695 2.66663 2 3.26358 2 3.99996V13.3333C2 14.0697 2.59695 14.6666 3.33333 14.6666H12.6667C13.403 14.6666 14 14.0697 14 13.3333V3.99996C14 3.26358 13.403 2.66663 12.6667 2.66663Z"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 6.66663H14" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card border-0 doctor-card mb-4">
                    <div
                        class="card-body p-4 d-flex align-items-stretch justify-content-between flex-md-nowrap flex-wrap gap-4">
                        <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                            <div class="d-flex flex-column justify-content-between">
                                <img src="assets/images/doctors/doctor3.png" class="doctor-img" alt="">
                                <div><span class="badge bg-success"><img src="assets/images/avaiable-time-icon.svg"
                                            alt=""> Available Today</span></div>
                            </div>
                            <div>
                                <h4 class="heading4">Dr. Rajesh Kumar</h4>
                                <p class="font16_bold">General Physician</p>
                                <p class="font14 mb-3">15+ years Experience</p>
                                <div class="d-flex align-items-center gap-2"><span class="doctor-review-badge"><i
                                            class="fa-solid fa-star"></i> 4.9</span> <span class="font14">(2847
                                        reviews)</span></div>
                                <a href="#" class="font14 mb-2 mt-2 d-flex align-items-center gap-2"><i
                                        class="fa-solid fa-location-dot"></i> Apollo Clinic, Koramangala, Bangalore</a>
                                <a href="#"
                                    class="d-inline-flex align-items-center btn-outline-primary-light"><img
                                        src="assets/images/video-icon-primary.svg" alt=""> Video Consultation
                                    Available</a>
                            </div>
                        </div>
                        <div class="text-start text-md-end d-flex flex-column justify-content-between">
                            <div>
                                <p class="font14">Consultation Fee</p>
                                <p class="font20 mb-3 mb-md-0">₹500</p>
                            </div>
                            <a class="custom_btn mt-auto" href="#"><svg width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33337 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6666 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.6667 2.66663H3.33333C2.59695 2.66663 2 3.26358 2 3.99996V13.3333C2 14.0697 2.59695 14.6666 3.33333 14.6666H12.6667C13.403 14.6666 14 14.0697 14 13.3333V3.99996C14 3.26358 13.403 2.66663 12.6667 2.66663Z"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 6.66663H14" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card border-0 doctor-card mb-4">
                    <div
                        class="card-body p-4 d-flex align-items-stretch justify-content-between flex-md-nowrap flex-wrap gap-4">
                        <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                            <div class="d-flex flex-column justify-content-between">
                                <img src="assets/images/doctors/doctor4.png" class="doctor-img" alt="">
                                <div><span class="badge bg-success"><img src="assets/images/avaiable-time-icon.svg"
                                            alt=""> Available Today</span></div>
                            </div>
                            <div>
                                <h4 class="heading4">Dr. Rajesh Kumar</h4>
                                <p class="font16_bold">General Physician</p>
                                <p class="font14 mb-3">15+ years Experience</p>
                                <div class="d-flex align-items-center gap-2"><span class="doctor-review-badge"><i
                                            class="fa-solid fa-star"></i> 4.9</span> <span class="font14">(2847
                                        reviews)</span></div>
                                <a href="#" class="font14 mb-2 mt-2 d-flex align-items-center gap-2"><i
                                        class="fa-solid fa-location-dot"></i> Apollo Clinic, Koramangala, Bangalore</a>
                                <a href="#"
                                    class="d-inline-flex align-items-center btn-outline-primary-light"><img
                                        src="assets/images/video-icon-primary.svg" alt=""> Video Consultation
                                    Available</a>
                            </div>
                        </div>
                        <div class="text-start text-md-end d-flex flex-column justify-content-between">
                            <div>
                                <p class="font14">Consultation Fee</p>
                                <p class="font20 mb-3 mb-md-0">₹500</p>
                            </div>
                            <a class="custom_btn mt-auto" href="#"><svg width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33337 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6666 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.6667 2.66663H3.33333C2.59695 2.66663 2 3.26358 2 3.99996V13.3333C2 14.0697 2.59695 14.6666 3.33333 14.6666H12.6667C13.403 14.6666 14 14.0697 14 13.3333V3.99996C14 3.26358 13.403 2.66663 12.6667 2.66663Z"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 6.66663H14" stroke="white" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Hidden Content Item Here  -->
                <!-- <div>
               hello content
             </div> -->

                <div class="d-flex justify-content-center view-all-doctors">
                    <a href="#" class="btn btn-outline-primary">View All Doctors</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================================================================================
                                 Booking Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 Profile Area Start
   =====================================================================================-->
    <div class="top-title-wrap my-4">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            Doctor Profile
        </span>
        <span class="line right"></span>
    </div>

    <section class="profile-area section-padding">
        <div class="container">
            <div class="card border-0 doctor-card mb-4">
                <div
                    class="card-body p-4 d-flex align-items-stretch justify-content-between gap-4 flex-wrap flex-md-nowrap">
                    <div class="d-flex gap-2 flex-wrap flex-sm-nowrap">
                        <div class="d-flex flex-column align-items-center">
                            <img src="assets/images/doctors/doctor1.png" class="doctor-img" alt="">
                            <div><span class="badge bg-success"><img src="assets/images/Verified.svg" alt="">
                                    Verified</span></div>
                        </div>
                        <div>
                            <h4 class="heading4">Dr. Rajesh Kumar</h4>
                            <p class="font16_bold mb-3">General Physician</p>
                            <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap"><span
                                    class="doctor-review-badge d-flex align-items-center gap-2"><i
                                        class="fa-solid fa-star"></i> 4.9 <span class="font14">(2847
                                        reviews)</span></span> <a href="#"
                                    class="d-inline-flex align-items-center btn-outline-primary-light"><img
                                        src="assets/images/video-icon-primary.svg" alt="">Video Consult</a>
                            </div>

                            <div class="d-flex gap-2 mt-1 flex-wrap flex-md-nowrap">
                                <div>
                                    <p class="font14 mb-2 mt-2 d-flex align-items-center gap-2"><svg width="16"
                                            height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.28 7.28137C14.3993 7.22872 14.5006 7.14221 14.5713 7.03257C14.6419 6.92293 14.6789 6.79496 14.6775 6.66453C14.6762 6.53409 14.6366 6.40692 14.5637 6.29876C14.4908 6.1906 14.3877 6.10621 14.2673 6.05603L8.55332 3.45337C8.37961 3.37413 8.19091 3.33313 7.99999 3.33313C7.80906 3.33313 7.62036 3.37413 7.44665 3.45337L1.73332 6.05337C1.61463 6.10535 1.51366 6.19079 1.44277 6.29924C1.37187 6.4077 1.33411 6.53446 1.33411 6.66403C1.33411 6.79361 1.37187 6.92037 1.44277 7.02882C1.51366 7.13728 1.61463 7.22272 1.73332 7.2747L7.44665 9.88003C7.62036 9.95927 7.80906 10.0003 7.99999 10.0003C8.19091 10.0003 8.37961 9.95927 8.55332 9.88003L14.28 7.28137Z"
                                                stroke="#0DA2E7" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M14.6667 6.66663V10.6666" stroke="#0DA2E7" stroke-width="1.33333"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M4 8.33337V10.6667C4 11.1971 4.42143 11.7058 5.17157 12.0809C5.92172 12.456 6.93913 12.6667 8 12.6667C9.06087 12.6667 10.0783 12.456 10.8284 12.0809C11.5786 11.7058 12 11.1971 12 10.6667V8.33337"
                                                stroke="#0DA2E7" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        MBBS, MD - General Medicine
                                    </p>
                                    <p class="font14 mt-2 d-flex align-items-center gap-2">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.33334 5.33337L7.33334 9.33337" stroke="#0DA2E7"
                                                stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M2.66666 9.33337L6.66666 5.33337L7.99999 3.33337" stroke="#0DA2E7"
                                                stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1.33334 3.33337H9.33334" stroke="#0DA2E7" stroke-width="1.33333"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4.66666 1.33337H5.33332" stroke="#0DA2E7" stroke-width="1.33333"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14.6667 14.6667L11.3333 8L8 14.6667" stroke="#0DA2E7"
                                                stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M9.33334 12H13.3333" stroke="#0DA2E7" stroke-width="1.33333"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        English, Hindi, Kannada
                                    </p>
                                </div>

                                <div>
                                    <p class="font14 mb-2 mt-2 d-flex align-items-center gap-2"><svg width="16"
                                            height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.318 8.59338L11.328 14.2774C11.3393 14.3443 11.3299 14.4131 11.3011 14.4746C11.2723 14.536 11.2253 14.5872 11.1666 14.6212C11.1079 14.6553 11.0402 14.6706 10.9726 14.6652C10.9049 14.6597 10.8405 14.6338 10.788 14.5907L8.40135 12.7994C8.28613 12.7133 8.14617 12.6668 8.00235 12.6668C7.85853 12.6668 7.71857 12.7133 7.60335 12.7994L5.21268 14.5901C5.16023 14.633 5.09593 14.6589 5.02835 14.6644C4.96077 14.6699 4.89313 14.6546 4.83446 14.6206C4.77579 14.5867 4.72887 14.5356 4.69996 14.4743C4.67106 14.4129 4.66154 14.3443 4.67268 14.2774L5.68202 8.59338"
                                                stroke="#0DA2E7" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M8 9.33337C10.2091 9.33337 12 7.54251 12 5.33337C12 3.12424 10.2091 1.33337 8 1.33337C5.79086 1.33337 4 3.12424 4 5.33337C4 7.54251 5.79086 9.33337 8 9.33337Z"
                                                stroke="#0DA2E7" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        15+ Years Experience
                                    </p>
                                    <a href="#" class="font14 mt-2 d-flex align-items-center gap-2">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.3334 6.66671C13.3334 9.99537 9.64069 13.462 8.40069 14.5327C8.28517 14.6196 8.14455 14.6665 8.00002 14.6665C7.85549 14.6665 7.71487 14.6196 7.59935 14.5327C6.35935 13.462 2.66669 9.99537 2.66669 6.66671C2.66669 5.25222 3.22859 3.89567 4.22878 2.89547C5.22898 1.89528 6.58553 1.33337 8.00002 1.33337C9.41451 1.33337 10.7711 1.89528 11.7713 2.89547C12.7715 3.89567 13.3334 5.25222 13.3334 6.66671Z"
                                                stroke="#0DA2E7" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M8 8.66663C9.10457 8.66663 10 7.7712 10 6.66663C10 5.56206 9.10457 4.66663 8 4.66663C6.89543 4.66663 6 5.56206 6 6.66663C6 7.7712 6.89543 8.66663 8 8.66663Z"
                                                stroke="#0DA2E7" stroke-width="1.33333" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        Koramangala, Bangalore
                                    </a>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div
                        class="text-start text-md-end d-flex flex-column justify-content-between border-md-start ps-4">
                        <div>
                            <p class="font14">Consultation Fee</p>
                            <p class="font20 mb-3 mb-md-0">₹500</p>
                        </div>
                        <a class="custom_btn mt-auto" href="#"><svg width="16" height="16"
                                viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.33337 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10.6666 1.33337V4.00004" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M12.6667 2.66663H3.33333C2.59695 2.66663 2 3.26358 2 3.99996V13.3333C2 14.0697 2.59695 14.6666 3.33333 14.6666H12.6667C13.403 14.6666 14 14.0697 14 13.3333V3.99996C14 3.26358 13.403 2.66663 12.6667 2.66663Z"
                                    stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M2 6.66663H14" stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Book Appointment
                        </a>
                        <div>
                            <a href="#" class="btn-outline mt-3"><img src="assets/images/online-video.svg"
                                    alt=""> Call Clinic</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row g-4">

                <!-- LEFT COLUMN -->
                <div class="col-lg-8">

                    <!-- Clinic Card -->
                    <div class="card border-0 mb-4 clinic-card">
                        <div class="card-body p-4">
                            <h6 class="font18px text-dark mb-3 fw-bold">Clinic & Hospital</h6>
                            <div class="d-flex gap-3 flex-wrap flex-sm-nowrap">
                                <img src="assets/images/Clinic.png" class="clinic-img" alt="">
                                <div>
                                    <h6 class="font16 text-dark fw-bold mb-1">Apollo Clinic</h6>
                                    <a href="#" class="font14 mb-2"><i class="fa-solid fa-location-dot"></i>
                                        &nbsp; 123, 4th Cross, Koramangala, Bangalore - 56003</a>
                                    <p class="font14"><i class="fa-regular fa-clock"></i> &nbsp; Mon - Sat: 9:00 AM -
                                        6:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Slots -->
                    <div class="card border-0 mb-4">
                        <div class="card-body p-4">
                            <h6 class="font18px fw-bold text-dark mb-3">Available Time Slots - Today</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="time-slot active">9:00 AM</span>
                                <span class="time-slot disabled">9:30 AM</span>
                                <span class="time-slot active">10:00 AM</span>
                                <span class="time-slot active">10:30 AM</span>
                                <span class="time-slot disabled">11:00 AM</span>
                                <span class="time-slot active">11:30 AM</span>
                                <span class="time-slot active">2:00 PM</span>
                                <span class="time-slot active">2:30 PM</span>
                                <span class="time-slot disabled">3:00 PM</span>
                                <span class="time-slot active">3:30 PM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="card border-0">
                        <div class="card-body p-4">
                            <h6 class="font18px fw-bold text-dark mb-3">Patient Review</h6>

                            <div class="review-item">
                                <div class="avatar">A</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 font16 fw-bold text-dark">Amit Patel</h6>
                                        <div class="stars">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                        </div>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                    <p class="mt-2 font14">Excellent doctor! Very patient and thorough in examination.
                                        Explained everything clearly. Highly recommended for anyone looking for
                                        genuine and caring physician.</p>
                                </div>
                            </div>
                            <hr>

                            <div class="review-item">
                                <div class="avatar">S</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 font16 fw-bold text-dark">Sneha Gupta</h6>
                                        <div class="stars">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                        </div>
                                    </div>
                                    <small class="text-muted">1 week ago</small>
                                    <p class="mt-2 font14">Excellent doctor! Very patient and thorough in examination.
                                    </p>
                                </div>
                            </div>
                            <hr>

                            <div class="review-item">
                                <div class="avatar">V</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 font16 fw-bold text-dark">Vikram Singh</h6>
                                        <div class="stars">
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                            <span><i class="fa-solid fa-star"></i></span>
                                        </div>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                    <p class="mt-2 font14">Excellent doctor! Very patient and thorough in examination.
                                        Explained everything clearly. Highly recommended for anyone looking for
                                        genuine and caring physician.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">

                    <!-- Quick Actions -->
                    <div class="card primary-bg-light border-0 mb-4">
                        <div class="card-body p-4">
                            <h6 class="font18px fw-bold text-dark mb-3">Quick Actions</h6>
                            <a class="custom_btn w-100 mb-2" href="#">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.6666 8.66676L14.1486 10.9881C14.1988 11.0215 14.2571 11.0407 14.3174 11.0435C14.3776 11.0464 14.4375 11.0329 14.4906 11.0045C14.5438 10.976 14.5882 10.9337 14.6192 10.8819C14.6502 10.8302 14.6666 10.7711 14.6666 10.7108V5.24676C14.6666 5.18811 14.6512 5.13049 14.6218 5.07973C14.5924 5.02896 14.5502 4.98684 14.4993 4.95763C14.4485 4.92841 14.3908 4.91313 14.3322 4.91333C14.2735 4.91353 14.2159 4.9292 14.1653 4.95876L10.6666 7.0001"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9.33337 4H2.66671C1.93033 4 1.33337 4.59695 1.33337 5.33333V10.6667C1.33337 11.403 1.93033 12 2.66671 12H9.33337C10.0698 12 10.6667 11.403 10.6667 10.6667V5.33333C10.6667 4.59695 10.0698 4 9.33337 4Z"
                                        stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Start Video Consultation
                            </a>
                            <button class="btn btn-outline-secondary w-100 mb-2">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.33337 1.33325V3.99992" stroke="#1D2630" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6666 1.33325V3.99992" stroke="#1D2630" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12.6667 2.66675H3.33333C2.59695 2.66675 2 3.2637 2 4.00008V13.3334C2 14.0698 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0698 14 13.3334V4.00008C14 3.2637 13.403 2.66675 12.6667 2.66675Z"
                                        stroke="#1D2630" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2 6.66675H14" stroke="#1D2630" stroke-width="1.33333"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Schedule for Later
                            </button>
                            <button class="btn btn-outline-secondary w-100">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.9254 10.6135V12.6135C13.9261 12.7991 13.8881 12.9829 13.8137 13.153C13.7393 13.3232 13.6302 13.4759 13.4934 13.6014C13.3566 13.7269 13.1951 13.8225 13.0192 13.8819C12.8433 13.9414 12.657 13.9635 12.472 13.9468C10.4206 13.7239 8.45004 13.0229 6.7187 11.9001C5.10792 10.8766 3.74226 9.51093 2.7187 7.90015C1.59202 6.16095 0.890866 4.18081 0.672037 2.12015C0.655377 1.93579 0.677287 1.74999 0.736371 1.57456C0.795454 1.39914 0.890418 1.23794 1.01521 1.10123C1.14001 0.964515 1.29191 0.855286 1.46123 0.780494C1.63056 0.705702 1.8136 0.666987 1.9987 0.666813H3.9987C4.32224 0.663628 4.6359 0.778198 4.88121 0.989168C5.12652 1.20014 5.28676 1.49311 5.33204 1.81348C5.41645 2.45352 5.573 3.08196 5.7987 3.68681C5.8884 3.92543 5.90781 4.18476 5.85464 4.43407C5.80147 4.68338 5.67795 4.91222 5.4987 5.09348L4.65204 5.94015C5.60107 7.60918 6.98301 8.99111 8.65204 9.94015L9.4987 9.09348C9.67996 8.91424 9.90881 8.79071 10.1581 8.73754C10.4074 8.68437 10.6668 8.70378 10.9054 8.79348C11.5102 9.01918 12.1387 9.17573 12.7787 9.26015C13.1025 9.30583 13.3983 9.46895 13.6097 9.71848C13.8211 9.968 13.9335 10.2865 13.9254 10.6135Z"
                                        stroke="#1D2630" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                                Request Callback
                            </button>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="card border-0">
                        <div class="card-body p-4">
                            <h6 class="font18px fw-bold text-dark mb-3">Services Offered</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="service-badge">General Check-up</span>
                                <span class="service-badge">Fever Treatment</span>
                                <span class="service-badge">Diabetes Care</span>
                                <span class="service-badge">Blood Pressure</span>
                                <span class="service-badge">Health Screenings</span>
                                <span class="service-badge">Vaccinations</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- ===================================================================================
                                 Profile Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 Book Appointment Area Start
   =====================================================================================-->
    <div class="top-title-wrap my-4">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            Book Appointment
        </span>
        <span class="line right"></span>
    </div>

    <section class="appointment-section section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="heading2 mb-2">Book Your Appointment</h2>
                <p class="font18px"> Quick, easy, and secure booking. Your appointment is just a few clicks away.</p>
            </div>

            <!-- Steps -->
            <div class="steps-wrapper mb-5">
                <div class="steps-progress"></div>

                <div class="steps d-flex justify-content-between">
                    <div class="step active" data-step="0">
                        <div class="icon-box">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.66666 1.66675V5.00008" stroke="white" stroke-width="1.66667"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13.3333 1.66675V5.00008" stroke="white" stroke-width="1.66667"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M15.8333 3.33325H4.16667C3.24619 3.33325 2.5 4.07944 2.5 4.99992V16.6666C2.5 17.5871 3.24619 18.3333 4.16667 18.3333H15.8333C16.7538 18.3333 17.5 17.5871 17.5 16.6666V4.99992C17.5 4.07944 16.7538 3.33325 15.8333 3.33325Z"
                                    stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M2.5 8.33325H17.5" stroke="white" stroke-width="1.66667"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="step-title">
                            <span>Select Date</span>
                        </div>
                    </div>
                    <div class="step" data-step="1">
                        <div class="icon-box">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 18.3334C14.6024 18.3334 18.3334 14.6025 18.3334 10.0001C18.3334 5.39771 14.6024 1.66675 10 1.66675C5.39765 1.66675 1.66669 5.39771 1.66669 10.0001C1.66669 14.6025 5.39765 18.3334 10 18.3334Z"
                                    stroke="#627384" stroke-width="1.66667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M10 5V10L13.3333 11.6667" stroke="#627384" stroke-width="1.66667"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="step-title">
                            <span>Choose Time</span>
                        </div>

                    </div>
                    <div class="step" data-step="2">
                        <div class="icon-box">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.8334 17.5V15.8333C15.8334 14.9493 15.4822 14.1014 14.857 13.4763C14.2319 12.8512 13.3841 12.5 12.5 12.5H7.50002C6.61597 12.5 5.76812 12.8512 5.143 13.4763C4.51788 14.1014 4.16669 14.9493 4.16669 15.8333V17.5"
                                    stroke="#627384" stroke-width="1.66667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M10 9.16667C11.841 9.16667 13.3334 7.67428 13.3334 5.83333C13.3334 3.99238 11.841 2.5 10 2.5C8.15907 2.5 6.66669 3.99238 6.66669 5.83333C6.66669 7.67428 8.15907 9.16667 10 9.16667Z"
                                    stroke="#627384" stroke-width="1.66667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="step-title">
                            <span>Your Details</span>
                        </div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="icon-box">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1675 8.33332C18.548 10.2011 18.2768 12.1428 17.399 13.8348C16.5212 15.5268 15.0899 16.8667 13.3437 17.6311C11.5976 18.3955 9.64215 18.5381 7.80354 18.0353C5.96494 17.5325 4.35429 16.4145 3.24019 14.8678C2.12609 13.3212 1.5759 11.4394 1.68135 9.53615C1.7868 7.63294 2.54153 5.8234 3.81967 4.4093C5.09781 2.9952 6.82211 2.06202 8.70502 1.76537C10.5879 1.46872 12.5156 1.82654 14.1666 2.77916"
                                    stroke="#627384" stroke-width="1.66667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M7.5 9.16659L10 11.6666L18.3333 3.33325" stroke="#627384"
                                    stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="step-title">
                            <span>Confirm</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Card -->
            <div class="appointment-card mx-auto">
                <!-- STEP 1 -->
                <div class="step-content active" data-step="0">
                    <h6 class="fw-bold mb-4 font20 text-start text-dark">Select Date</h6>

                    <div class="text-start mb-4">
                        <label class="mb-2 d-block font16_bold text-dark">Consultation Type</label>
                        <div class="d-flex gap-3 flex-wrap flex-md-nowrap">
                            <div class="form-check">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    <div class="consult-box active">
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault1" checked>
                                            <span>
                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15 1.66675H5.00001C4.07954 1.66675 3.33334 2.41294 3.33334 3.33341V16.6667C3.33334 17.5872 4.07954 18.3334 5.00001 18.3334H15C15.9205 18.3334 16.6667 17.5872 16.6667 16.6667V3.33341C16.6667 2.41294 15.9205 1.66675 15 1.66675Z"
                                                        stroke="#0DA2E7" stroke-width="1.66667"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M7.5 18.3333V15H12.5V18.3333" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M6.66666 5H6.67499" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M13.3333 5H13.3417" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M10 5H10.0083" stroke="#0DA2E7" stroke-width="1.66667"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M10 8.33325H10.0083" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M10 11.6667H10.0083" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M13.3333 8.33325H13.3417" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M13.3333 11.6667H13.3417" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M6.66666 8.33325H6.67499" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M6.66666 11.6667H6.67499" stroke="#0DA2E7"
                                                        stroke-width="1.66667" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <p class="font16 text-dark fw-medium">In-Clinic Visit</p>
                                            <span class="font14">Visit doctor at clinic</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">

                                <label class="form-check-label" for="flexRadioDefault2">
                                    <div class="consult-box">
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault2">
                                            <span>
                                                <svg width="20" height="20" viewBox="0 0 20 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.3333 10.8334L17.6858 13.7351C17.7486 13.7768 17.8215 13.8008 17.8967 13.8044C17.972 13.808 18.0469 13.7911 18.1133 13.7555C18.1798 13.7199 18.2353 13.667 18.2741 13.6024C18.3128 13.5377 18.3333 13.4638 18.3333 13.3884V6.55839C18.3333 6.48508 18.314 6.41306 18.2773 6.3496C18.2406 6.28614 18.1878 6.23349 18.1242 6.19697C18.0606 6.16045 17.9885 6.14136 17.9152 6.1416C17.8419 6.14185 17.77 6.16144 17.7066 6.19839L13.3333 8.75006"
                                                        stroke="#1ABC9C" stroke-width="1.66667"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M11.6667 5H3.33335C2.41288 5 1.66669 5.74619 1.66669 6.66667V13.3333C1.66669 14.2538 2.41288 15 3.33335 15H11.6667C12.5872 15 13.3334 14.2538 13.3334 13.3333V6.66667C13.3334 5.74619 12.5872 5 11.6667 5Z"
                                                        stroke="#1ABC9C" stroke-width="1.66667"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <p class="font16 text-dark fw-medium">Video Consultation</p>
                                            <span class="font14">Consult from home</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-start mb-4">
                        <label class="fw-semibold mb-2 d-block font16_bold text-dark">Select Date</label>
                        <div class="d-flex gap-2 flex-wrap" id="dateContainer">

                        </div>
                    </div>


                </div>
                <!-- STEP 2 -->
                <div class="step-content" data-step="1">
                    <h6 class="fw-bold mb-4 font20 text-start text-dark">Choose Time</h6>

                    <div class="text-start">
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="date-box">09:00 AM</div>
                            <div class="date-box">10:30 AM</div>
                        </div>
                    </div>
                </div>
                <!-- STEP 3 -->
                <div class="step-content" data-step="2">
                    <h6 class="fw-bold mb-4 font20 text-start text-dark">Your Details</h6>
                    <form class="contact-form">
                        <div class="row gx-3">
                            <div class="col-md-6 mb-3">
                                <label class="font14 text-dark fw-medium mb-2">Your Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font14 text-dark fw-medium mb-2">Email Address</label>
                                <input type="email" class="form-control">
                            </div>
                        </div>
                        <div class="row gx-3">
                            <div class="col-md-6 mb-3">
                                <label class="font14 text-dark fw-medium mb-2">Phone</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font14 text-dark fw-medium mb-2">Address</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <button class="custom_btn justify-content-center border-0">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.69067 14.4572C9.716 14.5203 9.76003 14.5742 9.81685 14.6116C9.87368 14.6489 9.94057 14.668 10.0086 14.6663C10.0766 14.6646 10.1424 14.6421 10.1972 14.6018C10.2521 14.5616 10.2933 14.5055 10.3153 14.4412L14.6487 1.77454C14.67 1.71547 14.6741 1.65154 14.6604 1.59024C14.6467 1.52894 14.6159 1.4728 14.5715 1.42839C14.5271 1.38398 14.4709 1.35314 14.4096 1.33947C14.3483 1.3258 14.2844 1.32987 14.2253 1.35121L1.55867 5.68454C1.49433 5.7066 1.43829 5.74782 1.39805 5.80266C1.35781 5.85749 1.33532 5.92332 1.33357 5.99131C1.33183 6.05931 1.35093 6.1262 1.38831 6.18303C1.42568 6.23985 1.47955 6.28388 1.54267 6.30921L6.82934 8.42921C6.99646 8.49612 7.1483 8.59618 7.27571 8.72336C7.40312 8.85054 7.50346 9.0022 7.57067 9.16921L9.69067 14.4572Z"
                                    stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M14.5693 1.43115L7.276 8.72382" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Submit
                        </button>
                    </form>
                </div>
                <!-- STEP 4 -->
                <div class="step-content" data-step="3">
                    <h6 class="fw-bold mb-4 font20 text-center text-dark">Confirm</h6>
                    <p class="text-center mb-4">Review your appointment and submit.</p>
                </div>
                <button class="btn btn-primary w-100 mt-3" id="nextBtn">
                    Continue
                </button>
            </div>

        </div>
    </section>
    <!-- ===================================================================================
                                 Book Appointment Area End
   =====================================================================================-->
    <!-- ===================================================================================
                                 Services Area Start
   =====================================================================================-->
    <div class="top-title-wrap my-4" id="service">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            SERVICES
        </span>
        <span class="line right"></span>
    </div>
    <section class="services-section section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="heading2 mb-2">Our Healthcare Services</h2>
                <p class="font18px"> Complete healthcare solutions at your fingertips. From consultations to healt
                    records.</p>
            </div>

            <div class="card border-0 mb-5 rounded-16px" id="consult">
                <div class="row align-items-center g-0 rounded-3">
                    <!-- Left content -->
                    <div class="col-lg-6 p-4">
                        <span class="badge bg-success-light mb-3 d-inline-flex align-items-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.6667 8.66652L14.1487 10.9879C14.1989 11.0213 14.2572 11.0404 14.3174 11.0433C14.3776 11.0462 14.4375 11.0327 14.4907 11.0042C14.5438 10.9758 14.5883 10.9334 14.6193 10.8817C14.6502 10.83 14.6666 10.7708 14.6667 10.7105V5.24652C14.6667 5.18787 14.6512 5.13025 14.6219 5.07948C14.5925 5.02872 14.5502 4.9866 14.4994 4.95738C14.4485 4.92817 14.3909 4.91289 14.3322 4.91309C14.2735 4.91329 14.216 4.92896 14.1653 4.95852L10.6667 6.99985"
                                    stroke="#1ABC9C" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M9.33334 4H2.66667C1.93029 4 1.33334 4.59695 1.33334 5.33333V10.6667C1.33334 11.403 1.93029 12 2.66667 12H9.33334C10.0697 12 10.6667 11.403 10.6667 10.6667V5.33333C10.6667 4.59695 10.0697 4 9.33334 4Z"
                                    stroke="#1ABC9C" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            &nbsp; Most Popular
                        </span>

                        <h3 class="mt-3 mb-4 heading3">Video Consultation with Top Doctor</h3>
                        <p class="font16 mb-4">
                            Connect with verified specialists from anywhere. Get prescriptions, follow-ups, and medica
                            advice without leaving your home. Available 24/7 for emergencies.
                        </p>

                        <ul class="service-list mb-4 text-dark">
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="20" height="20" rx="10" fill="#E7F9ED" />
                                    <rect x="6" y="6" width="8" height="8" rx="4" fill="#22C35D" />
                                </svg>
                                Instant connection with doctors
                            </li>
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="20" height="20" rx="10" fill="#E7F9ED" />
                                    <rect x="6" y="6" width="8" height="8" rx="4" fill="#22C35D" />
                                </svg>
                                Digital prescriptions
                            </li>
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="20" height="20" rx="10" fill="#E7F9ED" />
                                    <rect x="6" y="6" width="8" height="8" rx="4" fill="#22C35D" />
                                </svg>
                                Follow-up consultations included
                            </li>
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="20" height="20" rx="10" fill="#E7F9ED" />
                                    <rect x="6" y="6" width="8" height="8" rx="4" fill="#22C35D" />
                                </svg>
                                100% secure & confidential
                            </li>
                        </ul>

                        <a href="#" class="btn btn-success">
                            Start Video Consultation &nbsp; <svg width="16" height="16" viewBox="0 0 16 16"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.33334 8H12.6667" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 3.3335L12.6667 8.00016L8 12.6668" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>

                    <!-- Right image -->
                    <div class="col-lg-6 p-4 text-center">
                        <img src="assets/images/Video-consultation.png" class="img-fluid rounded-16px"
                            alt="Video Consultation">
                    </div>
                </div>
            </div>


            <!-- Service Cards -->
            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="service-card h-100">
                        <img src="assets/images/service-icons/service-icon1.svg" alt="">
                        <h4 class="heading4 mt-3 mb-2">In-Clinic Appointment</h4>
                        <p class="font14">Book appointments at clinics & hospitals near you. Visit doctors
                            in person for comprehensive consultations.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card h-100">
                        <img src="assets/images/service-icons/service-icon2.svg" alt="">
                        <h4 class="heading4 mt-3 mb-2">Online Video Consultation</h4>
                        <p class="font14">Consult with top doctors from the comfort of your home.
                            Available 24/7 for your convenience.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card h-100">
                        <img src="assets/images/service-icons/service-icon3.svg" alt="">
                        <h4 class="heading4 mt-3 mb-2">Lab Test Booking</h4>
                        <p class="font14">Book diagnostic tests and health checkups. Home sample
                            collection available across 100+ cities.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card h-100">
                        <img src="assets/images/service-icons/service-icon4.svg" alt="">
                        <h4 class="heading4 mt-3 mb-2">Health Check Packages</h4>
                        <p class="font14">Comprehensive health packages for preventive care. Full body
                            checkups starting at ₹999.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card h-100">
                        <img src="assets/images/service-icons/service-icon5.svg" alt="">
                        <h4 class="heading4 mt-3 mb-2">Medicine Reminders</h4>
                        <p class="font14">Never miss your medication. Get timely reminders and track
                            your health routine easily.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card h-100">
                        <img src="assets/images/service-icons/service-icon6.svg" alt="">
                        <h4 class="heading4 mt-3 mb-2">Digital Health Records</h4>
                        <p class="font14">Store and access your medical records securely. Share reports
                            with doctors instantly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================================================================================
                                 Services Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 Specialities Area Start
   =====================================================================================-->
    <div class="top-title-wrap my-4">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            Specialities
        </span>
        <span class="line right"></span>
    </div>
    <section class="services-section section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="heading2 mb-2">Browse by Speciality</h2>
                <p class="font18px"> Find the right specialist for your health needs. 25+ medical specialities
                    covered.</p>
            </div>

            <!-- Service Cards -->
            <div class="row g-4 row-cols-lg-5 row-cols-md-4 row-cols-sm-3 row-cols-1">
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon1.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">General Physician</h4>
                        <p class="font14 mb-2">Cold, fever, infections & mor</p>
                        <p class="text-primary">5,000+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon2.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Dentist</h4>
                        <p class="font14 mb-2">Dental care & oral health</p>
                        <p class="text-primary">3,200+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon3.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Dermatologist</h4>
                        <p class="font14 mb-2">Skin, hair & nail problems</p>
                        <p class="text-primary">2,800+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon4.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Gynecologist</h4>
                        <p class="font14 mb-2">Women's health & pregnancy</p>
                        <p class="text-primary">2,500+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon5.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Pediatrician</h4>
                        <p class="font14 mb-2">Child health specialists</p>
                        <p class="text-primary">2,100+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon6.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Orthopedic</h4>
                        <p class="font14 mb-2">Bone & joint specialists</p>
                        <p class="text-primary">1,800+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon7.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Cardiologist</h4>
                        <p class="font14 mb-2">Heart & cardiovascular</p>
                        <p class="text-primary">1,500+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon8.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Psychiatrist</h4>
                        <p class="font14 mb-2">Mental health & wellness</p>
                        <p class="text-primary">1,200+ doctors</p>
                    </div>
                </div>
                <div class="col">
                    <div class="Specialities-card h-100">
                        <img src="assets/images/Specialities-icons/Specialities-icon9.svg" alt="">
                        <h4 class="heading4 mt-3 mb-1">Ophthalmologist</h4>
                        <p class="font14 mb-2">Eye care & vision</p>
                        <p class="text-primary">900+ doctors</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-5">
                <a href="#" class="btn btn-outline-primary">View All Specialities &nbsp; <svg width="16"
                        height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.33331 8H12.6666" stroke="#0DA2E7" stroke-width="1.33333"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 3.3335L12.6667 8.00016L8 12.6668" stroke="#0DA2E7" stroke-width="1.33333"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- ===================================================================================
                                 Specialities Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 About Area Start
   =====================================================================================-->
    <div class="top-title-wrap my-4" id="about">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            About Us
        </span>
        <span class="line right"></span>
    </div>
    <section class="about-section section-padding">
        <div class="container">

            <div class="section-title text-center mb-5">
                <h2 class="heading2 mb-2">About MediCare</h2>
                <p class="font18px"> India's most trusted healthcare platform, connecting patients with quality
                    healthcare</p>
            </div>

            <!-- Stats -->
            <div class="row g-4 mb-5">
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="stat-card text-center">
                        <img src="assets/images/about-icons/about-icon1.svg" alt="">
                        <h3 class="heading3 mb-1 mt-3">50,000+</h3>
                        <p class="font14">Verified Doctors</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="stat-card text-center">
                        <img src="assets/images/about-icons/about-icon2.svg" alt="">
                        <h3 class="heading3 mb-1 mt-3">10 Lakh+</h3>
                        <p class="font14">Appointments Booked</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="stat-card text-center">
                        <img src="assets/images/about-icons/about-icon3.svg" alt="">
                        <h3 class="heading3 mb-1 mt-3">100+</h3>
                        <p class="font14">Cities Covered</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6">
                    <div class="stat-card text-center">
                        <img src="assets/images/about-icons/about-icon4.svg" alt="">
                        <h3 class="heading3 mb-1 mt-3">4.8★</h3>
                        <p class="font14">Patient Rating</p>
                    </div>
                </div>
            </div>

            <!-- Mission -->
            <div class="row align-items-center pt-lg-5 pt-md-3 gx-lg-5 gx-md-3">
                <div class="col-md-6 mb-4 mb-md-0 about-left">
                    <div class="about-img">
                        <img src="assets/images/about.png" alt="Doctors">
                    </div>
                    <div class="about-left-content">
                        <p class="font20 mb-1">Our Team of Healthcare Experts</p>
                        <p class="font14">Dedicated to your health and wellness</p>
                    </div>
                </div>

                <div class="col-md-6 mission-content">
                    <h3 class="heading3 mb-3">Our Mission</h3>
                    <p class="font16">
                        We believe everyone deserves access to quality healthcare. Our mission is to make
                        healthcare accessible, affordable, and convenient for all Indians. Through technology and
                        innovation, we're bridging the gap between patients and healthcare providers.
                    </p>

                    <ul class="mission-list mt-4 pt-2">
                        <li class="d-flex gap-3">
                            <img src="assets/images/mission-icons/mission-icon1.svg" alt="">
                            <div>
                                <p class="font16_bold text-dark fw-bold">Patient-First Approach</p>
                                <p class="font14">Every decision we make is guided by what's best for our patients'
                                    health and wellbeing.</p>
                            </div>
                        </li>
                        <li class="d-flex gap-3">
                            <img src="assets/images/mission-icons/mission-icon2.svg" alt="">
                            <div>
                                <p class="font16_bold text-dark fw-bold">Trust & Transparency</p>
                                <p class="font14">Verified doctors, genuine reviews, and transparent pricing. No
                                    hidden charges ever.</p>
                            </div>
                        </li>
                        <li class="d-flex gap-3">
                            <img src="assets/images/mission-icons/mission-icon3.svg" alt="">
                            <div>
                                <p class="font16_bold text-dark fw-bold">Quality Healthcare</p>
                                <p class="font14">Partnered with top hospitals and experienced doctors to deliver the
                                    best care possible.</p>
                            </div>
                        </li>
                    </ul>

                    <a href="#" class="custom_btn d-inline-flex">Learn More About Us <svg width="16"
                            height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.33331 8H12.6666" stroke="white" stroke-width="1.33333"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 3.3335L12.6667 8.00016L8 12.6668" stroke="white" stroke-width="1.33333"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================================================================================
                                 About Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 Contact Area Start
   =====================================================================================-->
    <div class="top-title-wrap my-4" id="contact">
        <span class="line left"></span>
        <span class="top-title" id="topTitle">
            Contact Us
        </span>
        <span class="line right"></span>
    </div>
    <section class="contact-section section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="heading2 mb-2">Contact Us</h2>
                <p class="font18px"> Have questions? We're here to help. Reach out to our support team anytime</p>
            </div>

            <!-- Contact Form -->
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="contact-card card border-0 py-4 px-3 h-100">
                        <div class="card-body">
                            <h5 class="mb-4 font20 fw-bold text-dark">Send us a Message</h5>
                            <form class="contact-form">
                                <div class="row gx-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="font14 text-dark fw-medium mb-2">Your Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="font14 text-dark fw-medium mb-2">Email Address</label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="font14 text-dark fw-medium mb-2">Phone Number</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="font14 text-dark fw-medium mb-2">Your Message</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                </div>
                                <button class="custom_btn justify-content-center border-0 w-100">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.69067 14.4572C9.716 14.5203 9.76003 14.5742 9.81685 14.6116C9.87368 14.6489 9.94057 14.668 10.0086 14.6663C10.0766 14.6646 10.1424 14.6421 10.1972 14.6018C10.2521 14.5616 10.2933 14.5055 10.3153 14.4412L14.6487 1.77454C14.67 1.71547 14.6741 1.65154 14.6604 1.59024C14.6467 1.52894 14.6159 1.4728 14.5715 1.42839C14.5271 1.38398 14.4709 1.35314 14.4096 1.33947C14.3483 1.3258 14.2844 1.32987 14.2253 1.35121L1.55867 5.68454C1.49433 5.7066 1.43829 5.74782 1.39805 5.80266C1.35781 5.85749 1.33532 5.92332 1.33357 5.99131C1.33183 6.05931 1.35093 6.1262 1.38831 6.18303C1.42568 6.23985 1.47955 6.28388 1.54267 6.30921L6.82934 8.42921C6.99646 8.49612 7.1483 8.59618 7.27571 8.72336C7.40312 8.85054 7.50346 9.0022 7.57067 9.16921L9.69067 14.4572Z"
                                            stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M14.5693 1.43115L7.276 8.72382" stroke="white"
                                            stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg> Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-md-6">
                    <div class="contact-info d-flex flex-column gap-3">
                        <div class="card border-0 ">
                            <div class="card-body p-3">
                                <div class="info-box d-flex align-items-center gap-3">
                                    <img src="assets/images/contact-icons/contact-icon1.svg" alt="">
                                    <div>
                                        <p class="font14">Call Us</p>
                                        <p class="font16_bold">1800-123-4567</p>
                                        <p class="font12">Toll-free, 24/7 support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0">
                            <div class="card-body p-3">
                                <div class="info-box d-flex align-items-center gap-3">
                                    <img src="assets/images/contact-icons/contact-icon2.svg" alt="">
                                    <div>
                                        <p class="font14">Live Chat</p>
                                        <p class="font16_bold">Start Chat</p>
                                        <p class="font12">Instant response</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0">
                            <div class="card-body p-3">
                                <div class="info-box d-flex align-items-center gap-3">
                                    <img src="assets/images/contact-icons/contact-icon3.svg" alt="">
                                    <div>
                                        <p class="font14">Email Us</p>
                                        <p class="font16_bold">support@medicare.in</p>
                                        <p class="font12">Response within 2 hours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card primary-bg-light border-0 mt-2">
                            <div class="card-body p-4">
                                <h6 class="font16_bold fw-bold text-dark mb-3">Head Office</h6>
                                <div class="d-flex gap-2">
                                    <span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.6666 8.33317C16.6666 12.494 12.0508 16.8273 10.5008 18.1657C10.3564 18.2742 10.1806 18.333 9.99998 18.333C9.81931 18.333 9.64354 18.2742 9.49915 18.1657C7.94915 16.8273 3.33331 12.494 3.33331 8.33317C3.33331 6.56506 4.03569 4.86937 5.28593 3.61913C6.53618 2.36888 8.23187 1.6665 9.99998 1.6665C11.7681 1.6665 13.4638 2.36888 14.714 3.61913C15.9643 4.86937 16.6666 6.56506 16.6666 8.33317Z"
                                                stroke="#0DA2E7" stroke-width="1.66667" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M10 10.8335C11.3807 10.8335 12.5 9.71421 12.5 8.3335C12.5 6.95278 11.3807 5.8335 10 5.8335C8.61929 5.8335 7.5 6.95278 7.5 8.3335C7.5 9.71421 8.61929 10.8335 10 10.8335Z"
                                                stroke="#0DA2E7" stroke-width="1.66667" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <p class="font16">
                                        MediCare Healthcare Pvt. Ltd.
                                        <br>
                                        123, Tech Park, HSR Layout,
                                        <br>
                                        Bangalore, Karnataka - 560102
                                    </p>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 18.3332C14.6024 18.3332 18.3334 14.6022 18.3334 9.99984C18.3334 5.39746 14.6024 1.6665 10 1.6665C5.39765 1.6665 1.66669 5.39746 1.66669 9.99984C1.66669 14.6022 5.39765 18.3332 10 18.3332Z"
                                                stroke="#0DA2E7" stroke-width="1.66667" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M10 5V10L13.3333 11.6667" stroke="#0DA2E7"
                                                stroke-width="1.66667" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <p class="font16">
                                        Mon - Sat: 9:00 AM - 8:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card border-dashed mt-2">
                            <div class="card-body p-3">
                                <div class="info-box d-flex align-items-center gap-3">
                                    <img src="assets/images/contact-icons/contact-icon4.svg" alt="">
                                    <div>
                                        <p class="font16_bold text-dark fw-bold">Partner with Us</p>
                                        <p class="font14 mb-3">Are you a clinic or hospital? Join our network of
                                            10,000+ healthcare partners.</p>
                                        <a href="#" class="btn btn-outline-primary">Become a Partner</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===================================================================================
                                 Contact Area End
   =====================================================================================-->

    <!-- ===================================================================================
                                 Footer Area Start
   =====================================================================================-->
    <footer class="footer-section section-padding">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 gy-5 gy-sm-4">
                <!-- Brand -->
                <div class="col text-center text-sm-start">
                    <div class="mb-3">
                        <a href="index.html"><img class="footer-logo" src="assets/images/footer-logo.png"
                                alt=""></a>
                    </div>
                    <p class="font14 pera-text">
                        India’s most trusted healthcare platform. Connecting patients with
                        quality healthcare since 2020.
                    </p>

                    <h6 class="footer-title font14 fw-bold mb-3 text-white mt-4">Download our App</h6>
                    <div class="app-buttons d-flex gap-2 justify-content-center justify-content-sm-start">
                        <a href="#" class="app-btn">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.3333 1.33301H4.66667C3.93029 1.33301 3.33334 1.92996 3.33334 2.66634V13.333C3.33334 14.0694 3.93029 14.6663 4.66667 14.6663H11.3333C12.0697 14.6663 12.6667 14.0694 12.6667 13.333V2.66634C12.6667 1.92996 12.0697 1.33301 11.3333 1.33301Z"
                                    stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 12H8.00667" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            iOS
                        </a>
                        <a href="#" class="app-btn">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.3333 1.33301H4.66667C3.93029 1.33301 3.33334 1.92996 3.33334 2.66634V13.333C3.33334 14.0694 3.93029 14.6663 4.66667 14.6663H11.3333C12.0697 14.6663 12.6667 14.0694 12.6667 13.333V2.66634C12.6667 1.92996 12.0697 1.33301 11.3333 1.33301Z"
                                    stroke="white" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 12H8.00667" stroke="white" stroke-width="1.33333"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Android
                        </a>
                    </div>
                </div>

                <!-- For Patients -->
                <div class="col text-center text-sm-start">
                    <h6 class="footer-title font14 fw-bold mb-3 text-white">For Patients</h6>
                    <ul class="footer-links">
                        <li><a href="#" class="font14">Find Doctors</a></li>
                        <li><a href="#" class="font14">Video Consultation</a></li>
                        <li><a href="#" class="font14">Book Lab Tests</a></li>
                        <li><a href="#" class="font14">Health Packages</a></li>
                        <li><a href="#" class="font14">Medical Records</a></li>
                        <li><a href="#" class="font14">Order Medicines</a></li>
                    </ul>
                </div>

                <!-- Specialities -->
                <div class="col text-center text-sm-start">
                    <h6 class="footer-title font14 fw-bold mb-3 text-white">Specialities</h6>
                    <ul class="footer-links">
                        <li><a href="#" class="font14">General Physician</a></li>
                        <li><a href="#" class="font14">Dermatologist</a></li>
                        <li><a href="#" class="font14">Pediatrician</a></li>
                        <li><a href="#" class="font14">Gynecologist</a></li>
                        <li><a href="#" class="font14">Cardiologist</a></li>
                        <li><a href="#" class="font14">Orthopedic</a></li>
                    </ul>
                </div>

                <!-- Top Cities -->
                <div class="col text-center text-sm-start">
                    <h6 class="footer-title font14 fw-bold mb-3 text-white">Top Cities</h6>
                    <ul class="footer-links">
                        <li><a href="#" class="font14">Bangalore</a></li>
                        <li><a href="#" class="font14">Mumbai</a></li>
                        <li><a href="#" class="font14">Delhi NCR</a></li>
                        <li><a href="#" class="font14">Chennai</a></li>
                        <li><a href="#" class="font14">Hyderabad</a></li>
                        <li><a href="#" class="font14">Kolkata</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div class="col text-center text-sm-start">
                    <h6 class="footer-title font14 fw-bold mb-3 text-white">Help & Support</h6>
                    <ul class="footer-links">
                        <li><a href="#" class="font14">Help Center</a></li>
                        <li><a href="#" class="font14">Contact Us</a></li>
                        <li><a href="#" class="font14">FAQs</a></li>
                        <li><a href="#" class="font14">Privacy Policy</a></li>
                        <li><a href="#" class="font14">Terms of Service</a></li>
                        <li><a href="#" class="font14">Refund Policy</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <p class="mb-2 mb-md-0">
                    © 2024 MediCare Healthcare Pvt. Ltd. All rights reserved.
                </p>

                <div class="social-icons d-flex gap-2">
                    <a href="#"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 1.66699H12.5C11.395 1.66699 10.3352 2.10598 9.55376 2.88738C8.77236 3.66878 8.33337 4.72859 8.33337 5.83366V8.33366H5.83337V11.667H8.33337V18.3337H11.6667V11.667H14.1667L15 8.33366H11.6667V5.83366C11.6667 5.61264 11.7545 5.40068 11.9108 5.2444C12.0671 5.08812 12.279 5.00033 12.5 5.00033H15V1.66699Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.3333 3.33368C18.3333 3.33368 17.75 5.08368 16.6666 6.16701C18 14.5003 8.83329 20.5837 1.66663 15.8337C3.49996 15.917 5.33329 15.3337 6.66663 14.167C2.49996 12.917 0.416626 8.00034 2.49996 4.16701C4.33329 6.33368 7.16663 7.58368 9.99996 7.50034C9.24996 4.00034 13.3333 2.00034 15.8333 4.33368C16.75 4.33368 18.3333 3.33368 18.3333 3.33368Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.1666 1.66699H5.83329C3.53211 1.66699 1.66663 3.53247 1.66663 5.83366V14.167C1.66663 16.4682 3.53211 18.3337 5.83329 18.3337H14.1666C16.4678 18.3337 18.3333 16.4682 18.3333 14.167V5.83366C18.3333 3.53247 16.4678 1.66699 14.1666 1.66699Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M13.3334 9.47525C13.4362 10.1688 13.3178 10.8771 12.9948 11.4994C12.6719 12.1218 12.161 12.6264 11.5347 12.9416C10.9085 13.2569 10.1987 13.3666 9.50653 13.2552C8.81431 13.1438 8.17484 12.817 7.67907 12.3212C7.1833 11.8255 6.85648 11.186 6.7451 10.4938C6.63371 9.80154 6.74343 9.09183 7.05865 8.46556C7.37386 7.8393 7.87853 7.32837 8.50086 7.00545C9.12319 6.68254 9.8315 6.56407 10.525 6.66692C11.2325 6.77182 11.8874 7.10147 12.3931 7.60717C12.8988 8.11288 13.2285 8.76782 13.3334 9.47525Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M14.5834 5.41699H14.5917" stroke="white" stroke-width="1.66667"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.3334 6.66699C14.6595 6.66699 15.9312 7.19378 16.8689 8.13146C17.8066 9.06914 18.3334 10.3409 18.3334 11.667V17.5003H15V11.667C15 11.225 14.8244 10.801 14.5119 10.4885C14.1993 10.1759 13.7754 10.0003 13.3334 10.0003C12.8913 10.0003 12.4674 10.1759 12.1549 10.4885C11.8423 10.801 11.6667 11.225 11.6667 11.667V17.5003H8.33337V11.667C8.33337 10.3409 8.86016 9.06914 9.79784 8.13146C10.7355 7.19378 12.0073 6.66699 13.3334 6.66699Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M4.99996 7.5H1.66663V17.5H4.99996V7.5Z" stroke="white" stroke-width="1.66667"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M3.33329 5.00033C4.25377 5.00033 4.99996 4.25413 4.99996 3.33366C4.99996 2.41318 4.25377 1.66699 3.33329 1.66699C2.41282 1.66699 1.66663 2.41318 1.66663 3.33366C1.66663 4.25413 2.41282 5.00033 3.33329 5.00033Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="#">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.08334 14.1667C1.50119 11.4194 1.50119 8.58061 2.08334 5.83333C2.15983 5.55434 2.30762 5.30006 2.51218 5.0955C2.71674 4.89095 2.97101 4.74316 3.25001 4.66667C7.71955 3.92622 12.2805 3.92622 16.75 4.66667C17.029 4.74316 17.2833 4.89095 17.4878 5.0955C17.6924 5.30006 17.8402 5.55434 17.9167 5.83333C18.4988 8.58061 18.4988 11.4194 17.9167 14.1667C17.8402 14.4457 17.6924 14.6999 17.4878 14.9045C17.2833 15.1091 17.029 15.2568 16.75 15.3333C12.2805 16.0739 7.71953 16.0739 3.25001 15.3333C2.97101 15.2568 2.71674 15.1091 2.51218 14.9045C2.30762 14.6999 2.15983 14.4457 2.08334 14.1667Z"
                                stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M8.33337 12.5L12.5 10L8.33337 7.5V12.5Z" stroke="white" stroke-width="1.66667"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===================================================================================
                                 Footer Area End
   =====================================================================================-->

    <!-- Js Files -->
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
