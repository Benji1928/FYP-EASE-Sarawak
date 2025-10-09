<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details - EASE SARAWAK</title>
    <link rel="icon" type="image/png" href="assets/images/cropped-Ease_PNG_File-09.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/footer_style.css">
    <link rel="stylesheet" href="assets/css/navbar_style.css">

    <style>
        @font-face {
            font-family: 'EurostarRegular';
            src: url('assets/Eurostar Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'EurostarRegular', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .customer-detail-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            min-height: calc(100vh - 200px);
        }

        .customer-detail-header {
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }

        .customer-detail-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .customer-detail-header p {
            font-size: 1.1rem;
            color: #666;
        }

        .section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f2be00;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .file-upload:hover {
            border-color: #007bff;
        }

        .file-upload i {
            font-size: 2rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .file-upload p {
            margin: 0;
            color: #666;
        }

        .file-upload.dragover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }

        .file-info {
            display: none;
            margin-top: 0.5rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #545b62;
        }

        .btn-submit {
            background: #28a745;
            color: white;
        }

        .btn-submit:hover {
            background: #218838;
        }

        @media (max-width: 768px) {
            .customer-detail-container {
                padding: 1rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?= $this->include('navbar/navbar') ?>
    
    <main class="customer-detail-container">
        <div class="customer-detail-header">
            <h1>Customer Details</h1>
            <p>Please provide your contact information</p>
        </div>

        <form id="customerForm">
            <!-- Customer Information Section -->
            <div class="section">
                <h2 class="section-title">
                    <i class="bi bi-person-fill"></i> CUSTOMER INFORMATION
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name <i class="bi bi-info-circle"></i></label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name <i class="bi bi-info-circle"></i></label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="identificationNumber">Identification Number <i class="bi bi-info-circle"></i></label>
                    <input type="text" id="identificationNumber" name="identificationNumber" placeholder="Enter your identification" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address <i class="bi bi-info-circle"></i></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number <i class="bi bi-info-circle"></i></label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone" required>
                </div>

                <div class="form-group">
                    <label>Social Contact <i class="bi bi-info-circle"></i></label>
                    <div class="form-row">
                        <div class="form-group">
                            <select id="socialContactType" name="socialContactType" required>
                                <option value="">Select social platform</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="wechat">WeChat</option>
                                <option value="line">Line</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" id="socialContactValue" name="socialContactValue" placeholder="Enter your contact number" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Baggage photo/Travel documents upload (Optional) <i class="bi bi-info-circle"></i></label>
                    <div class="file-upload" id="fileUpload">
                        <i class="bi bi-cloud-upload"></i>
                        <p>No file chosen</p>
                        <p>Select a file or drop it here</p>
                        <input type="file" id="documentUpload" name="documentUpload" style="display: none;" accept="image/*,.pdf,.doc,.docx">
                    </div>
                    <div class="file-info" id="fileInfo"></div>
                </div>
            </div>
        </form>

        <div class="action-buttons">
            <a href="bookingdetail" class="btn btn-back">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <button class="btn btn-submit" onclick="submitBooking()">
                <i class="bi bi-check-circle"></i> Submit Booking
            </button>
        </div>
    </main>
    
    <?= $this->include('footer/footer') ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File upload handling
            const fileUpload = document.getElementById('fileUpload');
            const fileInput = document.getElementById('documentUpload');
            const fileInfo = document.getElementById('fileInfo');

            fileUpload.addEventListener('click', function() {
                fileInput.click();
            });

            fileUpload.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUpload.classList.add('dragover');
            });

            fileUpload.addEventListener('dragleave', function() {
                fileUpload.classList.remove('dragover');
            });

            fileUpload.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUpload.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    updateFileInfo(files[0]);
                }
            });

            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    updateFileInfo(fileInput.files[0]);
                }
            });

            function updateFileInfo(file) {
                fileInfo.style.display = 'block';
                fileInfo.innerHTML = `
                    <i class="bi bi-file-earmark"></i>
                    <strong>${file.name}</strong> (${(file.size / 1024 / 1024).toFixed(2)} MB)
                `;
                fileUpload.querySelector('p').textContent = 'File selected: ' + file.name;
            }
        });

        function submitBooking() {
            // Validate form
            const form = document.getElementById('customerForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Get booking data from previous page
            const bookingData = JSON.parse(sessionStorage.getItem('bookingData'));
            if (!bookingData) {
                alert('Booking data not found. Please go back and complete your booking.');
                window.location.href = 'booking';
                return;
            }

            // Collect customer data
            const customerData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                identificationNumber: document.getElementById('identificationNumber').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                socialContactType: document.getElementById('socialContactType').value,
                socialContactValue: document.getElementById('socialContactValue').value,
                document: document.getElementById('documentUpload').files[0] || null
            };

            // Prepare order data for database
            const orderData = {
                first_name: customerData.firstName,
                last_name: customerData.lastName,
                id_num: customerData.identificationNumber,
                email: customerData.email,
                phone: customerData.phone,
                social: customerData.socialContactType,
                social_num: customerData.socialContactValue,
                service_type: bookingData.service,
                order_details_json: JSON.stringify(bookingData)
            };

            // Debug: Log the data being sent
            console.log('Sending order data:', orderData);

            // Show loading message
            const submitButton = document.querySelector('.btn-submit');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Submitting...';
            submitButton.disabled = true;

            // Send data to server using relative URL
            fetch('saveOrder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orderData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return response.text(); // Get as text first to see raw response
            })
            .then(text => {
                console.log('Raw response:', text);
                
                try {
                    const data = JSON.parse(text);
                    console.log('Parsed response data:', data);
                    
                    if (data.success) {
                        // Clear session storage
                        sessionStorage.removeItem('bookingData');
                        sessionStorage.removeItem('customerData');
                        
                        // Show success message
                        alert('Booking submitted successfully! Order ID: ' + data.order_id);
                        
                        // Redirect to confirmation page
                        window.location.href = 'booking-confirmation?order_id=' + data.order_id;
                    } else {
                        alert('Error submitting booking: ' + data.message);
                        // Reset button
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                } catch (parseError) {
                    console.error('JSON parse error:', parseError);
                    alert('Server returned invalid response: ' + text);
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred while submitting your booking: ' + error.message);
                // Reset button
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        }
    </script>
</body>

</html>