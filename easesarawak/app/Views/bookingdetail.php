<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - EASE SARAWAK</title>
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

        .booking-detail-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            min-height: calc(100vh - 200px);
        }

        .booking-detail-header {
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }

        .booking-detail-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .booking-detail-header p {
            font-size: 1.1rem;
            color: #666;
        }

        .service-type-badge {
            display: inline-block;
            background: #f2be00;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .booking-details-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section h3 {
            color: #333;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #f2be00;
            padding-bottom: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
            flex: 1;
        }

        .detail-value {
            color: #333;
            flex: 2;
            text-align: right;
        }

        .location-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin: 0.5rem 0;
        }

        .location-info strong {
            color: #333;
            display: block;
            margin-bottom: 0.25rem;
        }

        .location-info span {
            color: #666;
            font-size: 0.9rem;
        }

        .datetime-info {
            background: #e3f2fd;
            padding: 1rem;
            border-radius: 8px;
            margin: 0.5rem 0;
        }

        .datetime-info strong {
            color: #1976d2;
            display: block;
            margin-bottom: 0.25rem;
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

        .btn-edit {
            background: #6c757d;
            color: white;
        }

        .btn-edit:hover {
            background: #545b62;
        }

        .btn-proceed {
            background: #28a745;
            color: white;
        }

        .btn-proceed:hover {
            background: #218838;
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ddd;
        }

        @media (max-width: 768px) {
            .booking-detail-container {
                padding: 1rem;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .detail-value {
                text-align: left;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?= $this->include('navbar/navbar') ?>
    
    <main class="booking-detail-container">
        <div class="booking-detail-header">
            <h1>Booking Details</h1>
            <p>Please review your booking information</p>
        </div>

        <div id="booking-details-content">
            <!-- Content will be populated by JavaScript -->
        </div>
    </main>
    
    <?= $this->include('footer/footer') ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingData = JSON.parse(sessionStorage.getItem('bookingData'));
            const contentDiv = document.getElementById('booking-details-content');
            
            if (!bookingData) {
                contentDiv.innerHTML = `
                    <div class="booking-details-card">
                        <div class="no-data">
                            <i class="bi bi-exclamation-triangle"></i>
                            <h3>No Booking Data Found</h3>
                            <p>Please go back to the booking page and complete your booking.</p>
                            <a href="booking" class="btn btn-proceed">Go to Booking</a>
                        </div>
                    </div>
                `;
                return;
            }

            let html = '';
            
            // Service type badge
            html += `<div class="service-type-badge">
                ${bookingData.service === 'delivery' ? 'In Town Delivery' : 'Luggage Storage'}
            </div>`;

            html += '<div class="booking-details-card">';

            if (bookingData.service === 'delivery') {
                // Delivery service details
                html += `
                    <div class="detail-section">
                        <h3><i class="bi bi-geo-alt-fill"></i> Location Details</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Origin:</div>
                            <div class="detail-value">
                                <div class="location-info">
                                    <strong>${bookingData.origin}</strong>
                                    ${bookingData.originAddress ? `<span>${bookingData.originAddress}</span>` : ''}
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Destination:</div>
                            <div class="detail-value">
                                <div class="location-info">
                                    <strong>${bookingData.destination}</strong>
                                    ${bookingData.destinationAddress ? `<span>${bookingData.destinationAddress}</span>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3><i class="bi bi-calendar-check"></i> Schedule</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Drop-off:</div>
                            <div class="detail-value">
                                <div class="datetime-info">
                                    <strong>${formatDate(bookingData.dropoffDate)}</strong>
                                    <span>at ${formatTime(bookingData.dropoffTime)}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Pick-up:</div>
                            <div class="detail-value">
                                <div class="datetime-info">
                                    <strong>${formatDate(bookingData.pickupDate)}</strong>
                                    <span>at ${formatTime(bookingData.pickupTime)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Storage service details
                html += `
                    <div class="detail-section">
                        <h3><i class="bi bi-building"></i> Storage Details</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Storage Location:</div>
                            <div class="detail-value">
                                <div class="location-info">
                                    <strong>${bookingData.storageLocation}</strong>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Quantity:</div>
                            <div class="detail-value">
                                <strong>${bookingData.quantity} ${bookingData.quantity == '1' ? 'piece' : 'pieces'}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3><i class="bi bi-calendar-check"></i> Schedule</h3>
                        
                        <div class="detail-row">
                            <div class="detail-label">Drop-off:</div>
                            <div class="detail-value">
                                <div class="datetime-info">
                                    <strong>${formatDate(bookingData.dropoffDate)}</strong>
                                    <span>at ${formatTime(bookingData.dropoffTime)}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">Pick-up:</div>
                            <div class="detail-value">
                                <div class="datetime-info">
                                    <strong>${formatDate(bookingData.pickupDate)}</strong>
                                    <span>at ${formatTime(bookingData.pickupTime)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            html += '</div>';

            // Action buttons
            html += `
                <div class="action-buttons">
                    <a href="booking" class="btn btn-edit">
                        <i class="bi bi-pencil"></i> Edit Booking
                    </a>
                    <button class="btn btn-proceed" onclick="proceedToPayment()">
                        <i class="bi bi-credit-card"></i> Proceed to Payment
                    </button>
                </div>
            `;

            contentDiv.innerHTML = html;
        });

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            return date.toLocaleDateString('en-US', options);
        }

        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const time = new Date();
            time.setHours(parseInt(hours), parseInt(minutes));
            return time.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
        }

        function proceedToPayment() {
            const bookingData = JSON.parse(sessionStorage.getItem('bookingData'));
            if (bookingData) {
                // Redirect to customer details page
                window.location.href = 'bookingcustomerdetail';
            } else {
                alert('No booking data found. Please go back and complete your booking.');
                window.location.href = 'booking';
            }
        }
    </script>
</body>

</html>