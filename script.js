import confetti from 'canvas-confetti';

/**
 * ==================================
 * CLIENT-SIDE SCRIPT
 * Manages UI interactions like modals.
 * The core logic is now handled by PHP.
 * ==================================
 */

// --- Model (simplified for client-side state) ---
const model = {
    deliveryFee: 7.00,
    deliveryMethod: 'pickup',
};

// --- View (DOM elements and UI updates) ---
const view = {
    elements: {
        // Modals
        checkoutModal: document.getElementById('checkout-modal'),
        loginModal: document.getElementById('login-modal'),
        signupModal: document.getElementById('signup-modal'),
        recoveryModal: document.getElementById('recovery-modal'),
        allModals: document.querySelectorAll('.modal-overlay'),

        // Modal Triggers
        checkoutBtn: document.getElementById('checkout-btn'),
        loginBtn: document.getElementById('login-btn'),
        signupBtn: document.getElementById('signup-btn'),

        // Modal Controls
        allCloseModalBtns: document.querySelectorAll('.close-modal-btn'),
        switchToSignupLink: document.getElementById('switch-to-signup-link'),
        switchToLoginLink: document.getElementById('switch-to-login-link'),
        forgotPasswordLink: document.getElementById('forgot-password-link'),
        
        // Auth-related elements
        authLinks: document.getElementById('auth-links'),
        userInfo: document.getElementById('user-info'),

        // Checkout Form Elements
        checkoutForm: document.getElementById('checkout-form'), // The main form
        deliveryRadios: document.querySelectorAll('input[name="delivery_method"]'),
        paymentRadios: document.querySelectorAll('input[name="payment_method"]'),
        deliveryAddressForm: document.getElementById('delivery-address-form'),
        summarySubtotalEl: document.getElementById('summary-subtotal'),
        summaryDeliveryFeeEl: document.getElementById('summary-delivery-fee'),
        summaryTotalEl: document.getElementById('summary-total'),
        confirmPurchaseBtn: document.getElementById('confirm-purchase-btn'),
        cartSubtotalEl: document.getElementById('cart-subtotal'),
    },

    formatCurrency(value) {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    },

    showModal(modal) {
        this.elements.allModals.forEach(m => m.style.display = 'none');
        if (modal) {
            modal.style.display = 'flex';
        }
    },

    hideModals() {
        this.elements.allModals.forEach(m => m.style.display = 'none');
    },

    updateCheckoutSummary() {
        const subtotalText = this.elements.cartSubtotalEl.textContent;
        const subtotal = parseFloat(subtotalText.replace('R$ ', '').replace(',', '.')) || 0;
        const deliveryFee = model.deliveryMethod === 'delivery' ? model.deliveryFee : 0;
        const total = subtotal + deliveryFee;

        this.elements.summarySubtotalEl.textContent = this.formatCurrency(subtotal);
        this.elements.summaryDeliveryFeeEl.textContent = this.formatCurrency(deliveryFee);
        this.elements.summaryTotalEl.textContent = this.formatCurrency(total);
        this.elements.deliveryAddressForm.style.display = deliveryFee > 0 ? 'block' : 'none';
    },

    togglePaymentDetails(paymentMethod) {
        document.querySelectorAll('.payment-method-details').forEach(div => {
            div.style.display = 'none';
        });
        const selectedDetails = document.getElementById(`${paymentMethod}-details`);
        if (selectedDetails) {
            selectedDetails.style.display = 'block';
        }
    },
    
    // This function is now for demonstration and can be removed if a success page is used
    showSuccessAndConfetti() {
        alert('Pedido realizado com sucesso! Agradecemos a sua preferência.');
        confetti({
            particleCount: 150,
            spread: 90,
            origin: { y: 0.6 }
        });
        // The form submission now handles redirection
        window.location.href = 'index.php?order=success';
    }
};

// --- Controller (Event listeners) ---
const controller = {
    init() {
        this.bindModalEvents();
        this.bindCheckoutEvents();
        view.togglePaymentDetails('cash'); // Set initial state
        this.checkOrderStatus();
    },
    
    checkOrderStatus() {
        // Check for a success flag in the URL to show confetti after redirect
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('order') === 'success') {
            confetti({
                particleCount: 150,
                spread: 90,
                origin: { y: 0.6 }
            });
            // Clean up the URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    },

    bindModalEvents() {
        const { elements } = view;

        elements.checkoutBtn?.addEventListener('click', () => {
             // Check if user is logged in by seeing which header section is visible
            const userIsLoggedIn = elements.userInfo && elements.userInfo.style.display !== 'none';
            if (userIsLoggedIn) {
                view.showModal(elements.checkoutModal);
                view.updateCheckoutSummary();
            } else {
                // If not logged in, show the login modal first
                alert('Por favor, faça login ou cadastre-se para continuar.');
                view.showModal(elements.loginModal);
            }
        });

        elements.loginBtn?.addEventListener('click', () => view.showModal(elements.loginModal));
        elements.signupBtn?.addEventListener('click', () => view.showModal(elements.signupModal));

        elements.switchToSignupLink?.addEventListener('click', e => {
            e.preventDefault();
            view.showModal(elements.signupModal);
        });
        elements.switchToLoginLink?.addEventListener('click', e => {
            e.preventDefault();
            view.showModal(elements.loginModal);
        });
        elements.forgotPasswordLink?.addEventListener('click', e => {
            e.preventDefault();
            view.showModal(elements.recoveryModal);
        });

        elements.allCloseModalBtns.forEach(btn => btn.addEventListener('click', () => view.hideModals()));
        elements.allModals.forEach(modal => {
            modal.addEventListener('click', e => {
                if (e.target === modal) view.hideModals();
            });
        });
    },

    bindCheckoutEvents() {
        const { elements } = view;

        elements.deliveryRadios.forEach(radio => radio.addEventListener('change', e => {
            model.deliveryMethod = e.target.value;
            view.updateCheckoutSummary();
        }));
        
        elements.paymentRadios.forEach(radio => radio.addEventListener('change', e => {
            view.togglePaymentDetails(e.target.value);
        }));
    }
};

// --- Application Entry Point ---
document.addEventListener('DOMContentLoaded', () => {
    controller.init();
});