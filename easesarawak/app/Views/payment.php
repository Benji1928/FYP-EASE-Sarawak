<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASE SARAWAK | Payment</title>
    <link rel="icon" type="image/png" href="assets/images/cropped-Ease_PNG_File-09.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/footer_style.css">
    <link rel="stylesheet" href="assets/css/payment_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="assets/images/Ease_PNG_File-01.png" alt="EASE Logo">
        </div>
        <div class="menu">
            <div class="dropdown">
                <a>Menu <i class="bi bi-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Our Services</a>
                    <a href="#">How It Works</a>
                    <a href="#">Why Us</a>
                    <a href="#">About Us</a>
                    <a href="#">Contact Us</a>
                </div>
            </div>
            <a href="#" class="btn">Book Now</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>TRAVEL SMART WITH EASE</h1>
            <p>Whether you need secure storage or prompt delivery, we provide reliable and convenient solutions to ensure your journey is as smooth as possible.</p>
        </div>
    </section>

    <!-- Main Content (havent complete)-->  
    <div class="container">  
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-title">Booking Details</div>
                <div class="step-connector"></div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-title">Information & Payment</div>
                <div class="step-connector"></div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-title">Complete</div>
            </div>
        </div>

        <!-- Customer Information-->
        <div class="customer information">
             <div class="customer form">
                <h2 class="section-title">CUSTOMER INFORMATION</h2>
                
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" class="form-control" placeholder="Enter your first name">
                </div>
                
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" class="form-control" placeholder="Enter your last name">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="identificationNumber">Identification number</label>
                        <input type="text" id="identificationNumber" class="form-control" placeholder="Enter your identification">
                    </div>
                </div>
                
                    <div class="form-group">
                        <label for="emailAddress">Email Address</label>
                        <input type="text" id="emailAddress" class="form-control" placeholder="Enter your email">
                    </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phoneNumber" class="form-control" placeholder="Enter your phone">
                    </div>

                    <div class="form-group">
                        <label for="socialContact">Social Contact</label>
                        <input type="text" id="socialContact" class="form-control" placeholder="Whatsapp/ Wechat/ Line">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Baggage photo/Travel documents upload (Optional)</label> <!--Need change here -->
                    <div class="document upload">
                        <i class="bi bi-credit-card"></i>
                        <div>Select a file or drop it here</div>
                    </div>
                </div>
            </div>

        <!-- Payment Section -->
        <div class="payment-section">
            <!-- Payment Form -->
            <div class="payment-form">
                <h2 class="section-title">Payment Information</h2>
                
                <div class="form-group">
                    <label for="cardName">Name on Card</label>
                    <input type="text" id="cardName" class="form-control" placeholder="John Doe">
                </div>
                
                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date</label>
                        <input type="text" id="expiryDate" class="form-control" placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" class="form-control" placeholder="123">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="payment-methods">
                        <div class="payment-method">
                            <i class="bi bi-credit-card"></i>
                            <div>Credit Card</div>
                        </div>
                        <div class="payment-method">
                            <i class="bi bi-paypal"></i>
                            <div>PayPal</div>
                        </div>
                        <div class="payment-method">
                            <i class="bi bi-bank"></i>
                            <div>Bank Transfer</div>
                        </div>
                    </div>
                </div>
                
                <button class="btn-primary">Complete Payment</button>
            </div>
            
            <!-- Payment Summary -->
            <div class="payment-summary">
                <h2 class="section-title">Order Summary</h2>
                
                <div class="summary-item">
                    <span>In-Town Delivery</span>
                    <span>RM 25.00</span>
                </div>
                
                <div class="summary-item">
                    <span>Storage Fee (2 days)</span>
                    <span>RM 40.00</span>
                </div>
                
                <div class="summary-item">
                    <span>Service Tax</span>
                    <span>RM 5.00</span>
                </div>
                
                <div class="summary-total">
                    <span>Total</span>
                    <span>RM 70.00</span>
                </div>
                
                <div style="margin-top: 2rem;">
                    <h3 style="margin-bottom: 1rem;">Need Help?</h3>
                    <p>Contact our customer service:</p>
                    <p><i class="bi bi-telephone"></i> +60 12-345 6789</p>
                    <p><i class="bi bi-envelope"></i> support@ease.com</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Form validation
        document.querySelector('.btn-primary').addEventListener('click', function(e) {
            e.preventDefault();
            
            const cardName = document.getElementById('cardName').value;
            const cardNumber = document.getElementById('cardNumber').value;
            const expiryDate = document.getElementById('expiryDate').value;
            const cvv = document.getElementById('cvv').value;
            
            if (!cardName || !cardNumber || !expiryDate || !cvv) {
                alert('Please fill in all payment details');
                return;
            }
            
            // In a real application, you would process the payment here
            alert('Payment processed successfully!');
            
            // Redirect to next step
            window.location.href = 'confirmation.html';
        });
    </script>

    <?= $this->include('footer/footer') ?>v
</body>

</html>