@include('home.layouts.header')
    <!-- START ABOUT DESIGN AREA -->
    <section id="about" class="about-area">
        <div class="container">
            <div class="row">
                <!-- START ABOUT IMAGE DESIGN AREA -->
                <div class="col-lg-4">
                    <div class="about-image-part wow fadeInUp delay-0-3s">
                        <div class="about-image-part2">
							<img src="{{ asset('images/about/profile.jpg') }}" alt="About Me" />
						</div>
                        <h2>Dorbesh Baba</h2>
                        <p>I am a Web Designer based in san francisco.</p>
                        <div class="about-social text-center">
                            <ul>
                                <li><a href=""><i class="ri-facebook-circle-fill"></i></a></li>
                                <li><a href=""><i class="ri-twitter-x-line"></i></a></li>
                                <li><a href=""><i class="ri-linkedin-fill"></i></a></li>
                                <li><a href=""><i class="ri-github-line"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- / END ABOUT IMAGE DESIGN AREA -->
                <!-- START ABOUT TEXT DESIGN AREA -->
                <div class="col-lg-8">
                    <div class="about-content-part wow fadeInUp delay-0-2s">
                        <p>Hello There!</p>
                        <h2>
                            I’m <span>Dorbesh Baba</span>, a product designer crafting <span>user-centric design</span> with pixel-perfect precision.
                        </h2>
                        <div class="adress-field">
                            <ul>
                                <li><i class="ri-circle-fill"></i>Available for Freelancing</li>
                            </ul>
                        </div>
                        <div class="hero-btns">
                            <a href="contact.html" class="theme-btn">Download CV <i class="ri-download-line"></i></a>
                        </div>
                    </div>
                    <div class="about-content-part-bottom wow fadeInUp delay-0-2s">
						<div class="company-list">
                            <div class="scroller" data-direction="left" data-speed="slow">
                                <div class="scroller__inner">
                                    <h4>Bank lotpat kora amr main kaj.</h4>
                                    <h4>Manusher taka ami mere khai</h4>
                                    <h4>Ami khuni hasinar lok</h4>
                                    <h4>Ami desh chere palaite chaichilam</h4>
                                    <h4>Kinto pari nai</h4>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </div>
                <!-- / END ABOUT TEXT DESIGN AREA -->
            </div>
        </div>
    </section>
    <!-- / END ABOUT DESIGN AREA -->

    <!-- START BRAND DESIGN AREA -->
    <div class="client-logo-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="section-title text-center pt-5 mb-65 wow fadeInUp delay-0-2s">
                        <p>Company I work</p>
						<h2>300+ Global Clients</h2>
                    </div>
                </div>
            </div>
            <div class="client-logo-wrap">
                <a class="client-logo-item wow fadeInUp delay-0-2s">
                    <img src="{{ asset('images/client-logos/partner1.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-3s">
                    <img src="{{ asset('images/client-logos/partner2.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-4s">
                    <img src="{{ asset('images/client-logos/partner3.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-5s">
                    <img src="{{ asset('images/client-logos/partner4.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-6s">
                    <img src="{{ asset('images/client-logos/partner1.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-2s">
                    <img src="{{ asset('images/client-logos/partner4.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-3s">
                    <img src="{{ asset('images/client-logos/partner4.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-4s">
                    <img src="{{ asset('images/client-logos/partner2.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-5s">
                    <img src="{{ asset('images/client-logos/partner3.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-6s">
                    <img src="{{ asset('images/client-logos/partner1.png') }}" alt="brand Logo" />
                </a>
            </div>
        </div>
    </div>
    <!-- END BRAND DESIGN AREA -->
    
@include('home.layouts.footer')