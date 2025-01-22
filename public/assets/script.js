document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('product-modal');
    const closeModalBtn = document.querySelector('.close-modal');
    const addToCartBtn = document.getElementById('add-to-cart');
    const quantityElement = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decrease-quantity');
    const increaseBtn = document.getElementById('increase-quantity');
    const cartCount = document.querySelector('.cart-count');

    // Load cart from localStorage or initialize as empty array
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartCount();

    // Handle quantity changes
    let quantity = 1;
    decreaseBtn.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--;
            quantityElement.textContent = quantity;
        }
    });

    increaseBtn.addEventListener('click', () => {
        quantity++;
        quantityElement.textContent = quantity;
    });

    // Show modal
    document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('click', () => {
            const id = card.dataset.id;
            const name = card.dataset.name;
            const price = card.dataset.price;
            const imageSrc = card.querySelector('img').src;

            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-price').textContent = 'Rp ' + Number(price).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            document.getElementById('modal-image').src = imageSrc;
            document.getElementById('modal-name').dataset.id = id;

            modal.classList.remove('hidden');
            quantity = 1; // Reset quantity
            quantityElement.textContent = quantity;
            document.getElementById('modal-note').value = ''; // Reset note
        });
    });

    // Close modal
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Add to cart
    addToCartBtn.addEventListener('click', () => {
        const id = document.getElementById('modal-name').dataset.id;
        const name = document.getElementById('modal-name').textContent;
        const price = Number(document.getElementById('modal-price').textContent.replace(/[^\d]/g, ''));
        const note = document.getElementById('modal-note').value;
        const imageSrc = document.getElementById('modal-image').src;

        // Add product to cart
        const product = {
            id,
            name,
            price,
            quantity,
            note,
            imageSrc,
        };

        // Check if product already exists in cart
        const existingProductIndex = cart.findIndex(item => item.id === id);
        if (existingProductIndex > -1) {
            // Update existing product's quantity and note
            cart[existingProductIndex].quantity += quantity;
            cart[existingProductIndex].note = note; // Overwrite note
        } else {
            // Add new product
            cart.push(product);
        }

        // Save cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Update cart count
        updateCartCount();

        // Close modal
        modal.classList.add('hidden');

        // Reset fields
        quantity = 1;
        document.getElementById('modal-note').value = '';
    });

    // Update cart count
    function updateCartCount() {
        cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0) || 0;
    }
});


