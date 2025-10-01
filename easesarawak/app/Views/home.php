<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASE SARAWAK | Kuching Luggage Storage & Delivery</title>
    <link rel="icon" type="image/png" href="assets/images/cropped-Ease_PNG_File-09.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/footer_style.css">
    <link rel="stylesheet" href="assets/css/navbar_style.css">

    <style>
        @font-face {
            font-family: 'BebasKai';
            src: url('assets/BebasKai.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'EurostarRegular';
            src: url('assets/Eurostar Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'EurostarRegular', sans-serif, Arial, 'BebasKai';
            line-height: 1.6;
        }

        /* Hero section */
        .hero {
            position: relative;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            /* semi-transparent black */
            z-index: 1;
        }

        .hero::before,
        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform: scale(1);
            animation: zoom 20s ease-in-out infinite;
            z-index: 0;
            opacity: 0;
        }

        .hero::before {
            background-image: url("assets/images/close-up-tourist-with-suitcase_11zon.webp");
            animation-delay: 0s;
        }

        .hero::after {
            background-image: url("assets/images/close-up-traveler-with-luggage_11zon.webp");
            animation-delay: 10s;
            /* Half of total duration */
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1000px;
            padding: 1rem;
        }

        .hero-content h1 {
            font-size: 0.9rem;
            margin-top: 4rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .hero-content h2 {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .hero-content .btn {
            font-size: 1.3rem;
            margin: 0.5rem;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-primary {
            background: #f2be00;
            color: #fff;
        }

        .btn-primary:hover {
            background: #000;
        }

        /* Zoom & Crossfade Animation */
        @keyframes zoom {
            0% {
                opacity: 0;
                transform: scale(1);
            }

            5% {
                opacity: 1;
            }

            45% {
                opacity: 1;
                transform: scale(1.1);
                /* slow zoom-in */
            }

            50% {
                opacity: 0;
                transform: scale(1.15);
            }

            100% {
                opacity: 0;
                transform: scale(1);
            }
        }


        /* INTRODUCING EASE Section */
        .intro {
            display: flex;
            flex-wrap: wrap;
            min-height: 80vh;
        }

        .intro-left,
        .intro-right {
            flex: 1;
            padding: 3rem;
        }

        .intro-left {
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .intro-left h2 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .intro-left h3 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .intro-left p {
            margin-bottom: 1rem;
            color: #333;
            font-size: 1.1rem;
        }

        .intro-right {
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .intro-right video {
            width: 100%;
            height: 100%;
            min-height: 300px;
            object-fit: contain;
            border: none;
            border-radius: 8px;
        }

        /* OUR SERVICES Section */
        .services {
            padding: 4rem 2rem;
            background: url('assets/images/service-v1-pattern.jpg') no-repeat center center/cover;
            text-align: center;
        }

        .services-header h2 {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .services-header h3 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .services-header p {
            max-width: 700px;
            margin: 0 auto 3rem;
            color: #555;
            font-size: 1.1rem;
        }

        /* Cards container */
        .services-cards {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        /* Single card */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            align-items: start;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-image {
            background: #f2be00;
            border-radius: 10px;
            width: 70px;
            padding: 5px 5px 0px 5px;
        }

        .card-image img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .card h4 {
            font-size: 1.9rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .card .price {
            font-weight: bold;
            color: #f2be00;
            margin-bottom: 1rem;
        }

        .card .desc {
            flex-grow: 1;
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .btn-card {
            background: #f2be00;
            color: #fff;
            text-decoration: none;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-card:hover {
            background: black;
        }

        /* HOW IT WORKS Section */
        .how {
            padding: 4rem 2rem;
            background: #fff;
            text-align: center;
        }

        .how-header h2 {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .pill-title {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            gap: 15px;
            /* space between text and dots */
            background: #fff;
            border-radius: 50px;
            padding: 10px 25px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #000;
            text-transform: uppercase;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .pill-title .dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #f2be00;
            /* yellow color */
            display: inline-block;
        }

        .how-header h3 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .how-header p {
            max-width: 700px;
            margin: 0 auto 3rem;
            color: #555;
            font-size: 1.1rem;
        }

        /* Cards container */
        .how-cards {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        /* Single step card */
        .step-card {
            background: url('assets/images/bg-003-6.png') no-repeat center center/cover;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 250px;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
        }

        .step-card h4 {
            font-size: 2.4rem;
            color: #f2be00;
            margin-bottom: 0.5rem;
            font-weight: bold;
            text-align: right;
        }

        .step-card h5 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-align: left;
        }

        .step-card p {
            font-size: 1.1rem;
            color: #555;
            text-align: left;
        }

        /* Footer button */
        .how-footer {
            margin-top: 2rem;
        }

        .btn-how {
            background: #f2be00;
            color: #fff;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-how:hover {
            background: black;
        }

        /* WHY CHOOSE EASE Section */
        .why-choose-ease {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)),
                /* black filter */
                url('assets/images/valet-holding-baggage-side-view_23-2149901449-1 (1).webp') center/cover no-repeat;
            padding: 60px 20px;
            color: #fff;
        }

        .why-choose-ease .content {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
        }

        .left {
            flex: 1;
            padding: 20px;
        }

        .left h2 {
            font-size: 15px;
            margin-bottom: 10px;
        }

        .left h3 {
            font-size: 40px;
            margin-bottom: 20px;
        }

        .left p {
            line-height: 1.6;
            font-size: 20px;
        }

        /* RIGHT SIDE SPLIT INTO 4 QUADRANTS */
        .right {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 20px;
            /* spacing between quadrants */
            position: relative;
            padding: 20px;
        }

        /* Draw cross lines */
        .right::before,
        .right::after {
            content: "";
            position: absolute;
            background: rgba(255, 255, 255, 1);
        }

        .right::before {
            top: 50%;
            left: 0;
            width: 100%;
            height: 2px;
            /* horizontal line */
            transform: translateY(-50%);
        }

        .right::after {
            left: 50%;
            top: 0;
            height: 100%;
            width: 2px;
            /* vertical line */
            transform: translateX(-50%);
        }

        /* Each quadrant */
        .quadrant {
            /* background: rgba(0, 0, 0, 0.5); */
            /* semi-transparent bg for readability */
            padding: 15px;
            border-radius: 8px;
        }

        .quadrant h4 {
            margin-bottom: 10px;
            font-size: 23px;
        }

        .quadrant p {
            font-size: 18px;
            line-height: 1.4;
        }

        /* CONNECT WITH US Section */
        .connect-with-us {
            background: #f7f7f7;
            padding: 60px 20px;
        }

        .connect-with-us .content {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            gap: 40px;
        }

        .connect-with-us .connect-left {
            flex: 1;
            padding: 20px;
        }

        .connect-with-us .connect-left h2 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }

        .connect-with-us .connect-left h3 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #333;
        }

        .connect-with-us .connect-left p {
            font-size: 18px;
            margin-bottom: 15px;
            line-height: 1.6;
            color: #444;
        }

        .contact-info p {
            margin-bottom: 16px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border: 2px solid #f2be00;
            /* yellow border */
            border-radius: 50%;
            margin-right: 15px;
            color: #f2be00;
            font-size: 22px;
        }

        .contact-text .label {
            font-weight: 600;
            color: #000;
            font-size: 18px;
            margin-bottom: 2px;
            /* reduce space between heading and value */
        }

        .contact-text .value {
            font-size: 16px;
            color: #333;
        }

        .connect-with-us .connect-right {
            flex: 1;
            padding: 20px;
            background: black;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .connect-with-us .connect-right h2 {
            margin-top: 20px;
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }

        .connect-with-us .connect-right .tagline {
            font-size: 24px;
            color: #fff;
            margin-bottom: 20px;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #0077cc;
        }

        .contact-form button {
            padding: 14px;
            background: #f2be00;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .contact-form button:hover {
            background: black;
        }

        .cta-section {
            background: #dbd9d9ff;
            /* light grey background */
            padding: 80px 20px;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .cta-section p {
            font-size: 18px;
            color: #f2be00;
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            padding: 14px 28px;
            background: #f2be00;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .cta-button:hover {
            background: black;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-wrap: wrap;
            }

            .navbar .menu {
                flex-direction: column;
                align-items: flex-end;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content h2 {
                font-size: 1.2rem;
            }

            .intro {
                flex-direction: column;
            }

            .intro-left,
            .intro-right {
                padding: 2rem;
            }

            .intro-right iframe {
                min-height: 250px;
            }

            .services-cards {
                flex-direction: column;
                align-items: center;
            }

            .how-cards {
                flex-direction: column;
                align-items: center;
            }

            .connect-with-us .content {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?= $this->include('navbar/navbar') ?>
    <!-- Hero -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="pill-title">
                <span class="dot"></span>
                EASE BAGGAGE SOLUTIONS
                <span class="dot"></span>
            </h1>
            <h2>KUCHING HANDS-FREE TRAVEL
            </h2>
            <p>
                Discover the best of Kuching – We ensure you a smooth and hassle-free journey
                with our easy-to-use Kuching Luggage Storage and Delivery service.
            </p>
            <a href="#contact" class="btn btn-primary">CONTACT NOW</a>
            <a href="#book" class="btn btn-primary">BOOK NOW</a>
        </div>
    </section>

    <!-- INTRODUCING EASE Section -->
    <section class="intro">
        <div class="intro-left">
            <h2 class="pill-title">
                <span class="dot"></span>
                INTRODUCING EASE
                <span class="dot"></span>
            </h2>
            <h3>STREAMLINING YOUR TRAVEL</h3>
            <p>
                Every moment in Kuching is an opportunity for discovery. With EASE, you’re free to seize each one.
                Our seamless luggage storage and delivery services let you explore without limits—no bags to hold you back, no burdens to slow you down.
            </p>
            <p>
                Imagine wandering through vibrant markets, indulging in local cuisine, or uncovering hidden gems, all with your hands free and your mind at ease.
                We handle your luggage, so you can immerse yourself fully in the beauty and culture of this incredible city.
            </p>
        </div>
        <div class="intro-right">
            <video width="100%" height="100%" autoplay muted loop playsinline controls>
                <source src="assets/images/EASE-v2-Sub-Ease.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

    <!-- OUR SERVICES Section -->
    <section class="services" id="services">
        <div class="services-header">
            <h2 class="pill-title">
                <span class="dot"></span>
                OUR SERVICES
                <span class="dot"></span>
            </h2>
            <h3>TRAVEL LIGHT WITH EASE</h3>
            <p>
                Whether you need secure storage or prompt delivery, we provide reliable and convenient
                solutions to ensure your journey is as smooth as possible.
            </p>
        </div>

        <div class="services-cards">
            <!-- Card 1 -->
            <div class="card">
                <div class="card-image">
                    <img src="assets/images/case-1.png" alt="Basic Service">
                </div>
                <h4>Basic</h4>
                <p class="price">Starts from <strong>RM18</strong></p>
                <p class="desc">
                    Looking for short-term storage? Our Kuching Luggage Storage service keeps your luggage safe
                    for as long as needed while you explore the city worry-free!
                </p>
                <a href="#book" class="btn-card">BOOK NOW</a>
            </div>

            <!-- Card 2 -->
            <div class="card">
                <div class="card-image">
                    <img src="assets/images/baggage.png" alt="Standard Service">
                </div>
                <h4>Standard</h4>
                <p class="price">Starts from <strong>RM24</strong></p>
                <p class="desc">
                    Enjoy our complimentary Kuching Luggage Transfer with 24 hours of secure storage, offering
                    seamless transfers between selected locations for added convenience!
                </p>
                <a href="#book" class="btn-card">BOOK NOW</a>
            </div>

            <!-- Card 3 -->
            <div class="card">
                <div class="card-image">
                    <img src="assets/images/suitcase .png" alt="On-demand Service">
                </div>
                <h4>On-demand</h4>
                <p class="price">Starts from <strong>RM30</strong></p>
                <p class="desc">
                    Carrying oversized luggage or need a specific pickup/drop-off location? Our Kuching Luggage
                    Delivery service got you covered—flexible and hassle-free!
                </p>
                <a href="#book" class="btn-card">BOOK NOW</a>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS Section -->
    <section class="how" id="how">
        <div class="how-header">
            <h2 class="pill-title">
                <span class="dot"></span>
                HOW IT WORKS
                <span class="dot"></span>
            </h2>
            <h3>EASE TRAVEL PROCESS</h3>
            <p>
                Our process is designed to take the stress out of your travel experience:
            </p>
        </div>

        <div class="how-cards">
            <!-- Step 1 -->
            <div class="step-card">
                <h4>01</h4>
                <h5>Book Online</h5>
                <p>Reserve the luggage services you need in Kuching with just a few clicks.</p>
            </div>

            <!-- Step 2 -->
            <div class="step-card">
                <h4>02</h4>
                <h5>Get Confirmation</h5>
                <p>Receive an instant confirmation with all the details you need.</p>
            </div>

            <!-- Step 3 -->
            <div class="step-card">
                <h4>03</h4>
                <h5>Drop Off</h5>
                <p>Store your luggage at our location or schedule a pick-up whenever it suits you.</p>
            </div>

            <!-- Step 4 -->
            <div class="step-card">
                <h4>04</h4>
                <h5>Enjoy Your Trip</h5>
                <p>Explore Kuching without the extra weight.</p>
            </div>
        </div>

        <div class="how-footer">
            <a href="#book" class="btn-how">BOOK NOW</a>
        </div>
    </section>

    <section class="why-choose-ease" id="why-choose-ease">
        <div class="content">
            <!-- LEFT -->
            <div class="left">
                <h2 class="pill-title">
                    <span class="dot"></span>
                    WHY CHOOSE EASE?
                    <span class="dot"></span>
                </h2>
                <h3>YOUR TRAVEL, OUR COMMITMENT</h3>
                <p>
                    We understand that carrying your luggage through the city can be one of the biggest hassles
                    when traveling. Let us lift that burden off your shoulders, making your travel in Kuching
                    relaxing and enjoyable from start to end.
                </p>
            </div>

            <!-- RIGHT -->
            <div class="right">
                <div class="quadrant top-left">
                    <h4>Easy to Use</h4>
                    <p>Our user-friendly website and booking process allow you to arrange the service you need with just a few clicks.</p>
                </div>
                <div class="quadrant top-right">
                    <h4>Safe Assured</h4>
                    <p>Travel with peace of mind, knowing your luggage is protected by our top-notch security measures.</p>
                </div>
                <div class="quadrant bottom-left">
                    <h4>Optimal Flexibility</h4>
                    <p>Choose when and where to store or retrieve your luggage, giving you ultimate freedom and convenience.</p>
                </div>
                <div class="quadrant bottom-right">
                    <h4>Fast & Reliable</h4>
                    <p>Experience quick check-in for storage and on-time, prompt delivery.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="connect-with-us" id="contact">
        <div class="content">
            <!-- LEFT SIDE -->
            <div class="connect-left">
                <h2 class="pill-title">
                    <span class="dot"></span>
                    CONNECT WITH US
                    <span class="dot"></span>
                </h2>
                <h3>CONTACT US TODAY!</h3>
                <p>
                    Have any questions? Ready to book your baggage storage or delivery service in Kuching?
                </p>
                <p>
                    Reach us today through our form or the following contact information.
                </p>

                <div class="contact-info">
                    <div class="contact-item">
                        <div class="icon-circle">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="contact-text">
                            <div class="label">Phone Number</div>
                            <div class="value">+60 187773618</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="icon-circle">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <div class="label">Email Address</div>
                            <div class="value">easesarawak@gmail.com</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="icon-circle">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="contact-text">
                            <div class="label">Office Address</div>
                            <div class="value">No.118, Level 1, Plaza Aurora, Jalan McDougall, 93000 Kuching, Sarawak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="connect-right">
                <h2 class="pill-title">
                    <span class="dot"></span>
                    MESSAGE US TODAY
                    <span class="dot"></span>
                </h2>
                <p class="tagline">FILL THE FORM BELOW<br>Travel Light. Travel Smart. Travel with EASE.</p>

                <form class="contact-form">
                    <input type="email" placeholder="Your Email" required>
                    <input type="text" placeholder="Your Phone Number" required>
                    <input type="text" placeholder="Subject" required>
                    <textarea placeholder="Your Message" rows="5" required></textarea>
                    <button type="submit">SUBMIT FORM</button>
                </form>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2>
                AT EASE, WE PROMISE YOU A WONDERFUL AND<br>MEMORABLE JOURNEY IN KUCHING.
            </h2>
            <p>
                Travel Light. Travel Smart. Travel with EASE.
            </p>
            <a href="#book" class="cta-button">SCHEDULE TODAY</a>
        </div>
    </section>

    <?= $this->include('footer/footer') ?>

</body>

</html>