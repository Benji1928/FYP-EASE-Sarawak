<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - EASE SARAWAK</title>
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

        .booking-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            min-height: calc(100vh - 200px);
        }

        .booking-header {
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }

        .booking-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .service-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .tab-btn {
            background: white;
            border: 2px solid #ddd;
            padding: 1rem 2rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .tab-btn:hover {
            border-color: #007bff;
        }

        .tab-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .booking-form {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
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

        .form-group select,
        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group select:focus,
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .dropdown-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .hidden {
            display: none;
        }

        .time-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            color: #856404;
            padding: 0.75rem;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            display: none;
        }

        .time-warning.show {
            display: block;
        }

        .address-input {
            margin-top: 0.5rem;
        }

        .address-input input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .address-input input:focus {
            outline: none;
            border-color: #007bff;
        }

        .address-input input::placeholder {
            color: #999;
        }

        .continue-section {
            text-align: right;
            margin-top: 2rem;
        }

        .continue-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .continue-btn:hover {
            background: #218838;
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 1rem;
            }
            
            .service-tabs {
                flex-direction: column;
            }
            
            .dropdown-group,
            .datetime-group {
                grid-template-columns: 1fr;
            }
            
            .continue-section {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('navbar/navbar') ?>
    
    <main class="booking-container">
        <div class="booking-header">
            <h1>Book Your Service</h1>
        </div>

        <div class="service-tabs">
            <button class="tab-btn active" onclick="showService('delivery')">In Town Delivery</button>
            <button class="tab-btn" onclick="showService('storage')">Luggage Storage</button>
        </div>

        <!-- Delivery Form -->
        <div id="deliveryForm" class="booking-form">
            <div class="form-group">
                <label for="origin">Where is your origin? <i class="bi bi-info-circle"></i></label>
                <div class="dropdown-group">
                    <select id="origin-category" name="origin_category" onchange="updateOriginSpecific()">
                        <option value="">Choose Category</option>
                        <option value="ease-storage">Ease Storage Hub @ Plaza Aurora</option>
                        <option value="hotel">Hotel</option>
                        <option value="shopping-mall">Shopping Mall</option>
                        <option value="airport">Airport</option>
                        <option value="other">Other Location</option>
                    </select>
                    <select id="origin-specific" name="origin_specific" disabled>
                        <option value="">Select category first</option>
                    </select>
                </div>
                <div id="origin-address" class="address-input hidden">
                    <input type="text" id="origin-address-text" name="origin_address" placeholder="Please enter your specific address">
                </div>
            </div>

            <div class="form-group">
                <label for="dropoff-datetime">Drop-off date & time <i class="bi bi-info-circle"></i></label>
                <div class="datetime-group">
                    <input type="date" id="dropoff-date" name="dropoff_date" value="2025-10-04">
                    <input type="time" id="dropoff-time" name="dropoff_time" value="14:00">
                </div>
                <div id="dropoff-time-warning" class="time-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Please select a time that is at least 2 hours from current time which is 05 Oct 2025 Time: 16:00.
                </div>
            </div>

            <div class="form-group">
                <label for="destination">Where is your destination? <i class="bi bi-info-circle"></i></label>
                <div class="dropdown-group">
                    <select id="destination-category" name="destination_category" onchange="updateDestinationSpecific()">
                        <option value="">Choose Category</option>
                        <option value="ease-storage">Ease Storage Hub @ Plaza Aurora</option>
                        <option value="hotel">Hotel</option>
                        <option value="shopping-mall">Shopping Mall</option>
                        <option value="airport">Airport</option>
                        <option value="other">Other Location</option>
                    </select>
                    <select id="destination-specific" name="destination_specific" disabled>
                        <option value="">Select category first</option>
                    </select>
                </div>
                <div id="destination-address" class="address-input hidden">
                    <input type="text" id="destination-address-text" name="destination_address" placeholder="Please enter your specific address">
                </div>
            </div>

            <div class="form-group">
                <label for="pickup-datetime">Pick-up date & time <i class="bi bi-info-circle"></i></label>
                <div class="datetime-group">
                    <input type="date" id="pickup-date" name="pickup_date" value="2025-10-04">
                    <input type="time" id="pickup-time" name="pickup_time" value="16:00">
                </div>
                <div id="pickup-time-warning" class="time-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Please select a time that is at least 2 hours from current time which is 05 Oct 2025 Time: 16:00.
                </div>
            </div>
        </div>

        <!-- Storage Form -->
        <div id="storageForm" class="booking-form hidden">
            <div class="form-group">
                <label for="storage-location">Storage Location <i class="bi bi-info-circle"></i></label>
                <select id="storage-location" name="storage_location">
                    <option value="ease-plaza-aurora">EASE Storage Hub @ Plaza Aurora</option>
                    <option value="ease-central">EASE Storage Hub @ Central</option>
                    <option value="ease-waterfront">EASE Storage Hub @ Waterfront</option>
                </select>
            </div>

            <div class="form-group">
                <label for="storage-dropoff-datetime">Drop-off date & time <i class="bi bi-info-circle"></i></label>
                <div class="datetime-group">
                    <input type="date" id="storage-dropoff-date" name="storage_dropoff_date" value="2025-10-04">
                    <input type="time" id="storage-dropoff-time" name="storage_dropoff_time" value="12:00">
                </div>
                <div id="storage-dropoff-time-warning" class="time-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Please select a time that is at least 2 hours from current time which is 05 Oct 2025 Time: 16:00.
                </div>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity <i class="bi bi-info-circle"></i></label>
                <select id="quantity" name="quantity">
                    <option value="1">1 piece</option>
                    <option value="2">2 pieces</option>
                    <option value="3">3 pieces</option>
                    <option value="4">4 pieces</option>
                    <option value="5">5+ pieces</option>
                </select>
            </div>

            <div class="form-group">
                <label for="storage-pickup-datetime">Pick-up date & time <i class="bi bi-info-circle"></i></label>
                <div class="datetime-group">
                    <input type="date" id="storage-pickup-date" name="storage_pickup_date" value="2025-10-04">
                    <input type="time" id="storage-pickup-time" name="storage_pickup_time" value="14:00">
                </div>
                <div id="storage-pickup-time-warning" class="time-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Please select a time that is at least 2 hours from current time which is 05 Oct 2025 Time: 16:00.
                </div>
            </div>
        </div>

        <div class="continue-section">
            <button class="continue-btn" onclick="continueBooking()">CONTINUE</button>
        </div>
    </main>
    
    <?= $this->include('footer/footer') ?>

    <script>
        let currentService = 'delivery';

        // Location data
        const locationData = {
            'ease-storage': {
                options: [
                    { value: 'ease-plaza-aurora', text: 'Ease Storage Hub @ Plaza Aurora' }
                ],
                autoSelect: true
            },
            'hotel': {
                options: [
                    { value: 'astana-wing-riverside', text: 'Astana Wing - Riverside Majestic Hotel' },
                    { value: 'citadines-uplands', text: 'Citadines Uplands Kuching' },
                    { value: 'grand-margherita', text: 'Grand Margherita Hotel' },
                    { value: 'hilton-kuching', text: 'Hilton Kuching Hotel' },
                    { value: 'hock-lee', text: 'Hock Lee Hotel & Residences' },
                    { value: 'imperial-hotel', text: 'Imperial Hotel Kuching' },
                    { value: 'merdeka-palace', text: 'Merdeka Palace Hotel & Suites' },
                    { value: 'pullman-kuching', text: 'Pullman Kuching' },
                    { value: 'puteri-wing-riverside', text: 'Puteri Wing - Riverside Majestic Hotel' },
                    { value: 'sheraton-kuching', text: 'Sheraton Kuching Hotel' },
                    { value: 'waterfront-hotel', text: 'The Waterfront Hotel Kuching' },
                    { value: 'ucsi-hotel', text: 'UCSI Hotel Kuching' }
                ]
            },
            'shopping-mall': {
                options: [
                    { value: 'aeon-mall', text: 'AEON Mall Kuching Central' },
                    { value: 'boulevard-shopping', text: 'Boulevard Shopping Mall' },
                    { value: 'cityone-megamall', text: 'CityOne Megamall' },
                    { value: 'plaza-merdeka', text: 'Plaza Merdeka Matang Jaya' },
                    { value: 'spring-shopping', text: 'The Spring Shopping Mall' },
                    { value: 'vivacity-megamall', text: 'Vivacity Megamall' }
                ]
            },
            'airport': {
                options: [
                    { value: 'kuching-airport', text: 'Kuching International Airport' }
                ],
                autoSelect: true
            }
        };

        // Initialize date and time restrictions when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setMinDateTime();
            
            // Add event listeners for date-time validation - ONLY for delivery
            document.getElementById('dropoff-date').addEventListener('change', validateDropoffDateTime);
            document.getElementById('dropoff-time').addEventListener('change', validateDropoffDateTime);
            document.getElementById('pickup-date').addEventListener('change', validatePickupDateTime);
            document.getElementById('pickup-time').addEventListener('change', validatePickupDateTime);
            
            // Storage form listeners - NO 2-hour restriction
            document.getElementById('storage-dropoff-date').addEventListener('change', validateStorageDropoffDateTimeBasic);
            document.getElementById('storage-dropoff-time').addEventListener('change', validateStorageDropoffDateTimeBasic);
            document.getElementById('storage-pickup-date').addEventListener('change', validateStoragePickupDateTimeBasic);
            document.getElementById('storage-pickup-time').addEventListener('change', validateStoragePickupDateTimeBasic);
        });

        function setMinDateTime() {
            const now = new Date();
            const currentDate = now.toISOString().split('T')[0];
            const currentTime = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            
            // Set minimum date to today for all date inputs
            document.getElementById('dropoff-date').min = currentDate;
            document.getElementById('pickup-date').min = currentDate;
            document.getElementById('storage-dropoff-date').min = currentDate;
            document.getElementById('storage-pickup-date').min = currentDate;
            
            // Set default values for DELIVERY (2 hours from now)
            const futureTime = new Date(now.getTime() + 2 * 60 * 60 * 1000); // 2 hours from now
            const futureTimeString = futureTime.getHours().toString().padStart(2, '0') + ':' + futureTime.getMinutes().toString().padStart(2, '0');
            
            document.getElementById('dropoff-date').value = currentDate;
            document.getElementById('dropoff-time').value = futureTimeString;
            document.getElementById('pickup-date').value = currentDate;
            document.getElementById('pickup-time').value = new Date(futureTime.getTime() + 2 * 60 * 60 * 1000).getHours().toString().padStart(2, '0') + ':' + new Date(futureTime.getTime() + 2 * 60 * 60 * 1000).getMinutes().toString().padStart(2, '0');
            
            // Set default values for STORAGE (current time + 30 minutes)
            const storageTime = new Date(now.getTime() + 30 * 60 * 1000); // 30 minutes from now
            const storageTimeString = storageTime.getHours().toString().padStart(2, '0') + ':' + storageTime.getMinutes().toString().padStart(2, '0');
            
            document.getElementById('storage-dropoff-date').value = currentDate;
            document.getElementById('storage-dropoff-time').value = storageTimeString;
            document.getElementById('storage-pickup-date').value = currentDate;
            document.getElementById('storage-pickup-time').value = new Date(storageTime.getTime() + 2 * 60 * 60 * 1000).getHours().toString().padStart(2, '0') + ':' + new Date(storageTime.getTime() + 2 * 60 * 60 * 1000).getMinutes().toString().padStart(2, '0');
        }

        // DELIVERY VALIDATION FUNCTIONS (with 2-hour restriction)
        function validateDropoffDateTime() {
            const selectedDate = document.getElementById('dropoff-date').value;
            const selectedTime = document.getElementById('dropoff-time').value;
            const warningDiv = document.getElementById('dropoff-time-warning');
            
            if (!isDateTimeValid(selectedDate, selectedTime)) {
                warningDiv.classList.add('show');
                return false;
            } else if (!isAtLeast2HoursFromNow(selectedDate, selectedTime)) {
                // Update warning message with current time
                updateWarningMessage(warningDiv);
                warningDiv.classList.add('show');
                return false;
            } else {
                warningDiv.classList.remove('show');
                // Update pickup minimum based on dropoff
                updatePickupMinimum();
                return true;
            }
        }

        function validatePickupDateTime() {
            const selectedDate = document.getElementById('pickup-date').value;
            const selectedTime = document.getElementById('pickup-time').value;
            const dropoffDate = document.getElementById('dropoff-date').value;
            const dropoffTime = document.getElementById('dropoff-time').value;
            const warningDiv = document.getElementById('pickup-time-warning');
            
            if (!isDateTimeValid(selectedDate, selectedTime)) {
                updateWarningMessage(warningDiv);
                warningDiv.classList.add('show');
                return false;
            } else if (!isAtLeast2HoursFromNow(selectedDate, selectedTime)) {
                updateWarningMessage(warningDiv);
                warningDiv.classList.add('show');
                return false;
            } else if (isDateTime1BeforeDateTime2(selectedDate, selectedTime, dropoffDate, dropoffTime)) {
                warningDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Pick-up date and time must be after drop-off date and time.';
                warningDiv.classList.add('show');
                updatePickupMinimum();
                return false;
            } else {
                warningDiv.classList.remove('show');
                return true;
            }
        }

        // STORAGE VALIDATION FUNCTIONS (NO 2-hour restriction, only past time check)
        function validateStorageDropoffDateTimeBasic() {
            const selectedDate = document.getElementById('storage-dropoff-date').value;
            const selectedTime = document.getElementById('storage-dropoff-time').value;
            const warningDiv = document.getElementById('storage-dropoff-time-warning');
            
            if (!isDateTimeValid(selectedDate, selectedTime)) {
                warningDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Drop-off date and time cannot be in the past.';
                warningDiv.classList.add('show');
                return false;
            } else {
                warningDiv.classList.remove('show');
                // Update storage pickup minimum based on dropoff
                updateStoragePickupMinimum();
                return true;
            }
        }

        function validateStoragePickupDateTimeBasic() {
            const selectedDate = document.getElementById('storage-pickup-date').value;
            const selectedTime = document.getElementById('storage-pickup-time').value;
            const dropoffDate = document.getElementById('storage-dropoff-date').value;
            const dropoffTime = document.getElementById('storage-dropoff-time').value;
            const warningDiv = document.getElementById('storage-pickup-time-warning');
            
            if (!isDateTimeValid(selectedDate, selectedTime)) {
                warningDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Pick-up date and time cannot be in the past.';
                warningDiv.classList.add('show');
                return false;
            } else if (isDateTime1BeforeDateTime2(selectedDate, selectedTime, dropoffDate, dropoffTime)) {
                warningDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Pick-up date and time must be after drop-off date and time.';
                warningDiv.classList.add('show');
                updateStoragePickupMinimum();
                return false;
            } else {
                warningDiv.classList.remove('show');
                return true;
            }
        }

        function isAtLeast2HoursFromNow(date, time) {
            if (!date || !time) return false;
            
            const selectedDateTime = new Date(date + 'T' + time);
            const now = new Date();
            const twoHoursFromNow = new Date(now.getTime() + 2 * 60 * 60 * 1000);
            
            return selectedDateTime >= twoHoursFromNow;
        }

        function updateWarningMessage(warningDiv) {
            const now = new Date();
            const currentDateStr = now.toLocaleDateString('en-GB', { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric' 
            });
            const currentTimeStr = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false
            });
            
            warningDiv.innerHTML = `<i class="bi bi-exclamation-triangle"></i> Please select a time that is at least 2 hours from current time which is ${currentDateStr} Time: ${currentTimeStr}.`;
        }

        function isDateTimeValid(date, time) {
            if (!date || !time) return false;
            
            const selectedDateTime = new Date(date + 'T' + time);
            const now = new Date();
            
            return selectedDateTime > now;
        }

        function isDateTime1BeforeDateTime2(date1, time1, date2, time2) {
            if (!date1 || !time1 || !date2 || !time2) return false;
            
            const dateTime1 = new Date(date1 + 'T' + time1);
            const dateTime2 = new Date(date2 + 'T' + time2);
            
            return dateTime1 <= dateTime2;
        }

        function updatePickupMinimum() {
            const dropoffDate = document.getElementById('dropoff-date').value;
            const dropoffTime = document.getElementById('dropoff-time').value;
            
            if (dropoffDate && dropoffTime) {
                // Set pickup minimum to dropoff date
                document.getElementById('pickup-date').min = dropoffDate;
                
                // If pickup date is same as dropoff date, ensure pickup time is after dropoff time
                const pickupDate = document.getElementById('pickup-date').value;
                if (pickupDate === dropoffDate) {
                    // Add 1 hour minimum gap
                    const dropoffDateTime = new Date(dropoffDate + 'T' + dropoffTime);
                    const minPickupTime = new Date(dropoffDateTime.getTime() + 60 * 60 * 1000); // 1 hour later
                    const minTime = minPickupTime.getHours().toString().padStart(2, '0') + ':' + minPickupTime.getMinutes().toString().padStart(2, '0');
                    
                    if (document.getElementById('pickup-time').value <= dropoffTime) {
                        document.getElementById('pickup-time').value = minTime;
                    }
                }
            }
        }

        function updateStoragePickupMinimum() {
            const dropoffDate = document.getElementById('storage-dropoff-date').value;
            const dropoffTime = document.getElementById('storage-dropoff-time').value;
            
            if (dropoffDate && dropoffTime) {
                // Set pickup minimum to dropoff date
                document.getElementById('storage-pickup-date').min = dropoffDate;
                
                // If pickup date is same as dropoff date, ensure pickup time is after dropoff time
                const pickupDate = document.getElementById('storage-pickup-date').value;
                if (pickupDate === dropoffDate) {
                    // Add 1 hour minimum gap
                    const dropoffDateTime = new Date(dropoffDate + 'T' + dropoffTime);
                    const minPickupTime = new Date(dropoffDateTime.getTime() + 60 * 60 * 1000); // 1 hour later
                    const minTime = minPickupTime.getHours().toString().padStart(2, '0') + ':' + minPickupTime.getMinutes().toString().padStart(2, '0');
                    
                    if (document.getElementById('storage-pickup-time').value <= dropoffTime) {
                        document.getElementById('storage-pickup-time').value = minTime;
                    }
                }
            }
        }

        function updateOriginSpecific() {
            const category = document.getElementById('origin-category').value;
            const specificSelect = document.getElementById('origin-specific');
            const addressDiv = document.getElementById('origin-address');
            
            updateLocationDropdown(category, specificSelect, addressDiv);
        }

        function updateDestinationSpecific() {
            const category = document.getElementById('destination-category').value;
            const specificSelect = document.getElementById('destination-specific');
            const addressDiv = document.getElementById('destination-address');
            
            updateLocationDropdown(category, specificSelect, addressDiv);
        }

        function updateLocationDropdown(category, specificSelect, addressDiv) {
            if (category === 'other') {
                // Hide the second dropdown and show address input
                specificSelect.style.display = 'none';
                addressDiv.classList.remove('hidden');
                addressDiv.querySelector('input').setAttribute('required', 'required');
            } else if (category && locationData[category]) {
                // Show the second dropdown and populate with specific options
                specificSelect.style.display = 'block';
                specificSelect.disabled = false;
                addressDiv.classList.add('hidden');
                addressDiv.querySelector('input').removeAttribute('required');
                addressDiv.querySelector('input').value = '';
                
                const data = locationData[category];
                
                // Clear previous options
                specificSelect.innerHTML = '';
                
                if (!data.autoSelect) {
                    specificSelect.innerHTML = '<option value="">Choose specific location</option>';
                }
                
                data.options.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option.value;
                    optionElement.textContent = option.text;
                    specificSelect.appendChild(optionElement);
                });
                
                // Auto-select if needed (for Ease Storage and Airport)
                if (data.autoSelect && data.options.length === 1) {
                    specificSelect.value = data.options[0].value;
                }
            } else {
                // Reset to default state - show dropdown but disabled
                specificSelect.style.display = 'block';
                specificSelect.disabled = true;
                specificSelect.innerHTML = '<option value="">Select category first</option>';
                addressDiv.classList.add('hidden');
                addressDiv.querySelector('input').removeAttribute('required');
                addressDiv.querySelector('input').value = '';
            }
        }

        function showService(serviceType) {
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            // Show/hide forms
            if (serviceType === 'delivery') {
                document.getElementById('deliveryForm').classList.remove('hidden');
                document.getElementById('storageForm').classList.add('hidden');
            } else {
                document.getElementById('deliveryForm').classList.add('hidden');
                document.getElementById('storageForm').classList.remove('hidden');
            }

            currentService = serviceType;
        }

        function continueBooking() {
            // Basic form validation
            let isValid = true;
            let errorMessage = '';

            if (currentService === 'delivery') {
                const originCategory = document.getElementById('origin-category').value;
                const originSpecific = document.getElementById('origin-specific').value;
                const destinationCategory = document.getElementById('destination-category').value;
                const destinationSpecific = document.getElementById('destination-specific').value;
                
                // Validate date-time first (with 2-hour restriction for delivery)
                if (!validateDropoffDateTime() || !validatePickupDateTime()) {
                    return; // Stop if date-time validation fails - warnings will be shown
                }
                
                if (!originCategory) {
                    isValid = false;
                    errorMessage = 'Please select an origin category.';
                } else if (originCategory !== 'other' && !originSpecific) {
                    isValid = false;
                    errorMessage = 'Please select a specific origin location.';
                } else if (originCategory === 'other' && !document.getElementById('origin-address-text').value.trim()) {
                    isValid = false;
                    errorMessage = 'Please enter your origin address.';
                } else if (!destinationCategory) {
                    isValid = false;
                    errorMessage = 'Please select a destination category.';
                } else if (destinationCategory !== 'other' && !destinationSpecific) {
                    isValid = false;
                    errorMessage = 'Please select a specific destination location.';
                } else if (destinationCategory === 'other' && !document.getElementById('destination-address-text').value.trim()) {
                    isValid = false;
                    errorMessage = 'Please enter your destination address.';
                }
            } else {
                // Validate storage date-time (basic validation only - no 2-hour restriction)
                if (!validateStorageDropoffDateTimeBasic() || !validateStoragePickupDateTimeBasic()) {
                    return; // Stop if date-time validation fails - warnings will be shown
                }
            }

            if (!isValid) {
                alert(errorMessage);
                return;
            }

            // Collect form data and store in session storage for the booking detail page
            let bookingData = {};
            
            if (currentService === 'delivery') {
                // Get origin data
                const originCategory = document.getElementById('origin-category').value;
                let originLocation = '';
                let originAddress = '';
                
                if (originCategory === 'other') {
                    originLocation = 'Other Location';
                    originAddress = document.getElementById('origin-address-text').value;
                } else {
                    const originSpecific = document.getElementById('origin-specific');
                    originLocation = originSpecific.options[originSpecific.selectedIndex].text;
                }
                
                // Get destination data
                const destinationCategory = document.getElementById('destination-category').value;
                let destinationLocation = '';
                let destinationAddress = '';
                
                if (destinationCategory === 'other') {
                    destinationLocation = 'Other Location';
                    destinationAddress = document.getElementById('destination-address-text').value;
                } else {
                    const destinationSpecific = document.getElementById('destination-specific');
                    destinationLocation = destinationSpecific.options[destinationSpecific.selectedIndex].text;
                }
                
                bookingData = {
                    service: 'delivery',
                    origin: originLocation,
                    originAddress: originAddress,
                    destination: destinationLocation,
                    destinationAddress: destinationAddress,
                    dropoffDate: document.getElementById('dropoff-date').value,
                    dropoffTime: document.getElementById('dropoff-time').value,
                    pickupDate: document.getElementById('pickup-date').value,
                    pickupTime: document.getElementById('pickup-time').value
                };
            } else {
                // Storage service data
                const storageLocation = document.getElementById('storage-location');
                
                bookingData = {
                    service: 'storage',
                    storageLocation: storageLocation.options[storageLocation.selectedIndex].text,
                    quantity: document.getElementById('quantity').value,
                    dropoffDate: document.getElementById('storage-dropoff-date').value,
                    dropoffTime: document.getElementById('storage-dropoff-time').value,
                    pickupDate: document.getElementById('storage-pickup-date').value,
                    pickupTime: document.getElementById('storage-pickup-time').value
                };
            }
            
            // Store booking data in session storage
            sessionStorage.setItem('bookingData', JSON.stringify(bookingData));
            
            // Debug: Check if data is stored
            console.log('Booking data stored:', bookingData);
            
            // Redirect to booking detail page using relative URL
            window.location.href = 'bookingdetail';
        }
    </script>
</body>
</html>