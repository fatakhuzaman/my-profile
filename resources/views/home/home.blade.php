@include('home.layouts.header')
    <!-- START ABOUT DESIGN AREA -->
    <section id="about" class="about-area">
        <div class="container">
            <div class="row">
                <!-- START ABOUT IMAGE DESIGN AREA -->
                <div class="col-lg-4">
                    <div class="about-image-part wow fadeInUp delay-0-3s">
                        <div class="about-image-part2">
							<img src="{{ asset('images/about/profile.png') }}" alt="About Me" />
						</div>
                        <h2>Fatakhuzaman</h2>
                        <p>Programmer with 4+ years of experience, formerly at PT Astra Daihatsu Motor and PT Metafora Indonesia Teknologi.</p>
                        <div class="about-social text-center">
                            <ul>
                                <li><a href="https://www.instagram.com/fatakhuzaman/" target="_blank"><i class="ri-instagram-line"></i></a></li>
                                <li><a href="http://wa.me/6288226377174" target="_blank"><i class="ri-whatsapp-line"></i></a></li>
                                <li><a href="https://www.linkedin.com/in/muhamad-nur-fatakhuzaman-079143205/" target="_blank"><i class="ri-linkedin-fill"></i></a></li>
                                <li><a href="https://github.com/fatakhuzaman" target="_blank"><i class="ri-github-line"></i></a></li>
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
                            I’m <span>Fatah</span>, a professional with over <span>4 years</span> of experience in <span>application development,</span> programming, and IT.
                        </h2>
                        <div class="adress-field">
                            <ul>
                                <li><i class="ri-circle-fill"></i>Available for Freelancing</li>
                            </ul>
                        </div>
                        <div class="hero-btns">
                            <a href="{{ asset('files/Muhamad-Nur-Fatakhuzaman_CV.pdf') }}" class="theme-btn">Download CV <i class="ri-download-line"></i></a>
                        </div>
                    </div>
                    <div class="about-content-part-bottom wow fadeInUp delay-0-2s">
						<div class="company-list">
                            <div class="scroller" data-direction="left" data-speed="slow">
                                <div class="scroller__inner">
                                    <h4>Web Development</h4>
                                    <h4>Mobile App Development</h4>
                                    <h4>Custom Application Development</h4>
                                    <h4>ERP Software</h4>
                                    <h4>Wordpress Development</h4>
                                    <h4>UI/UX Design</h4>
                                    <h4>IT Consultant</h4>
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
						<h2>5+ Global Companies</h2>
                    </div>
                </div>
            </div>
            <div class="client-logo-wrap">
                <a class="client-logo-item wow fadeInUp delay-0-2s">
                    <img src="{{ asset('images/client-logos/daihatsu.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-3s">
                    <img src="{{ asset('images/client-logos/idmetafora.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-4s">
                    <img src="{{ asset('images/client-logos/mps.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-5s">
                    <img src="{{ asset('images/client-logos/diskominfo.png') }}" alt="brand Logo" />
                </a>
                <a class="client-logo-item wow fadeInUp delay-0-6s">
                    <img src="{{ asset('images/client-logos/kinz.png') }}" alt="brand Logo" />
                </a>
            </div>
        </div>
    </div>
    <!-- END BRAND DESIGN AREA -->
    
@include('home.layouts.footer')