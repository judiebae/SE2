<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hotel Management</title>
    <style>
        :root {
            --blue-header: #17488a;
            --brown-text: #663a2c;
            --gray-text: #777777;
            --border-color: #e2e2e2;
            --modal-overlay: rgba(0, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "BalooTammudu2-Medium", sans-serif;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--modal-overlay);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 50;
        }

        .modal {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 1200px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .header {
            background: var(--blue-header);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-id {
            color: #e5e5e5;
            font-size: 2.5rem;
            font-weight: 500;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .staff-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .staff-label {
            color: white;
            font-size: 1.1rem;
        }

        select {
            padding: 0.5rem;
            width: 180px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--gray-text);
            cursor: pointer;
        }

        .button {
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            border: none;
            background: white;
            color: var(--blue-header);
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .button:hover {
            opacity: 0.9;
        }

        .main-content {
            padding: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .form-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-label {
            width: 160px;
            color: var(--brown-text);
            font-weight: 500;
            font-size: 1.1rem;
        }

        .form-input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 2px;
            color: var(--gray-text);
        }

        .payment-section {
            margin-top: 2rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: .5rem;
        }

        .payment-header {
            color: var(--brown-text);
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .payment-header::after {
            content: '▼';
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }

        .payment-form {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1rem;
            overflow: hidden;
        }

        .payment-section[data-expanded="true"] .payment-header::after {
            transform: rotate(180deg);
        }

        .payment-section[data-expanded="true"] .payment-form {
            display: grid;
        }

        .payment-form {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .payment-section[data-expanded="true"] .payment-form {
            opacity: 1;
        }

        .save-payment {
            grid-column: 1 / -1;
            background: #666666;
            color: white;
            padding: 0.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .modal {
                height: 100vh;
                max-height: none;
                border-radius: 0;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .header-controls {
                flex-direction: column;
            }

            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-label {
                width: 100%;
            }

            .form-input {
                width: 100%;
            }

            .payment-form {
                grid-template-columns: 1fr;
            }
        }

        /* Animation for modal */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal {
            animation: modalFadeIn 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="modal-overlay">
        <div class="modal">
            <header class="header">
                <div class="header-id">PO45849</div>
                <div class="header-controls">
                    <div class="staff-section">
                        <label class="staff-label">Staff:</label>
                        <select class="staff-select">
                            <option>Veronica</option>
                            <option>John</option>
                            <option>Sarah</option>
                        </select>
                    </div>
                    <div class="button-group">
                        <button class="button">Save</button>
                        <button class="button" onclick="document.querySelector('.modal-overlay').style.display='none'">Cancel</button>
                    </div>
                </div>
            </header>

            <main class="main-content">
                <form class="form-grid">
                    <!-- Left Column -->
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Owner Name:</label>
                            <input type="text" class="form-input" value="Han Bascao">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact:</label>
                            <input type="text" class="form-input" value="0944 234 2413">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Comm Plat:</label>
                            <input type="text" class="form-input" value="Viber">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Name:</label>
                            <input type="text" class="form-input" value="Eddie">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Type:</label>
                            <input type="text" class="form-input" value="Dog">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Breed:</label>
                            <input type="text" class="form-input" value="Shih Tzu">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Service:</label>
                            <input type="text" class="form-input" value="Pet Hotel">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pet Breed:</label>
                            <input type="text" class="form-input" value="09/05/2024">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Service:</label>
                            <input type="text" class="form-input" value="09/10/2024">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Balance:</label>
                            <input type="text" class="form-input" value="PHP 500.00">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Amount:</label>
                            <input type="text" class="form-input" value="PHP 300.00">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mode of payment:</label>
                            <input type="text" class="form-input" value="Gcash">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Reference No:</label>
                            <input type="text" class="form-input" value="123456">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Status</label>
                            <input type="text" class="form-input" value="Downpayment">
                        </div>

                        <div class="payment-section" data-expanded="false" onclick="this.setAttribute('data-expanded', this.getAttribute('data-expanded') === 'true' ? 'false' : 'true')">
                            <div class="payment-header">Add Payment?</div>
                            <div class="payment-form">
                                <div class="form-group">
                                    <label class="form-label">Amount Paid:</label>
                                    <input type="text" class="form-input" value="PHP 200.00" onclick="event.stopPropagation()">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mode of Payment:</label>
                                    <input type="text" class="form-input" value="Gcash" onclick="event.stopPropagation()">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Balance:</label>
                                    <input type="text" class="form-input" value="PHP 200.00" onclick="event.stopPropagation()">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Payment Status:</label>
                                    <input type="text" class="form-input" value="PHP 200.00" onclick="event.stopPropagation()">
                                </div>
                                <button class="save-payment" onclick="event.stopPropagation()">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
</body>
</html>