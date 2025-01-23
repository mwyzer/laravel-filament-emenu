document.addEventListener('DOMContentLoaded', function () {
    const cartContainer = document.getElementById('cart-container');
    const totalPriceElement = document.getElementById('total-price');

    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    function renderCart() {
        cartContainer.innerHTML = '';
        let totalPrice = 0;

        cart.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';

            cartItem.innerHTML = `
                <img src="${item.imageSrc}" alt="${item.name}">
                <div class="cart-item-details">
                    <h2>${item.name}</h2>
                    <p>Rp ${Number(item.price).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}</p>
                    <textarea class="note-field" placeholder=" note ..." data-index="${index}">${item.note || ''}</textarea>
                    <div class="quantity-control">
                        <button class="quantity-btn decrease" data-index="${index}">-</button>
                        <span>${item.quantity}</span>
                        <button class="quantity-btn increase" data-index="${index}">+</button>
                    </div>
                </div>
                <button class="delete-btn" data-index="${index}" type="button">
                    &times;
                </button>
            `;

            cartContainer.appendChild(cartItem);

            totalPrice += item.price * item.quantity;
        });

        totalPriceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}`;
    }

    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    cartContainer.addEventListener('click', function (event) {
        if (event.target.classList.contains('note-field')) return;

        const index = event.target.dataset.index;

        if (event.target.classList.contains('increase')) {
            cart[index].quantity++;
        } else if (event.target.classList.contains('decrease') && cart[index].quantity > 1) {
            cart[index].quantity--;
        } else if (event.target.classList.contains('delete-btn')) {
            cart.splice(index, 1);
        }

        updateCart();
    });



    cartContainer.addEventListener('input', function (event) {
        if (event.target.classList.contains('note-field')) {
            const index = event.target.dataset.index;
            cart[index].note = event.target.value;
            clearTimeout(cart[index].noteUpdateTimeout);
            cart[index].noteUpdateTimeout = setTimeout(() => {
                updateCart();
            }, 1000);
        }
    });

    renderCart();
});

document.addEventListener('DOMContentLoaded', function () {
    const orderButton = document.getElementById('order-button');
    const paymentModal = document.getElementById('payment-modal');
    const closeModalButton = document.getElementById('close-modal');
    const paymentForm = document.getElementById('payment-form');

    orderButton.addEventListener('click', function () {
        paymentModal.style.display = 'flex';
    });

    closeModalButton.addEventListener('click', function () {
        paymentModal.style.display = 'none';
    });

    paymentForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const cartData = JSON.parse(localStorage.getItem('cart'));
        document.getElementById('cart-data').value = JSON.stringify(cartData.map(item => ({
            id: item.id,
            quantity: item.quantity,
            note: item.note,
        })));
        paymentForm.submit();
        localStorage.setItem('cart', '[]');
    });

    // Close modal if clicked outside content
    window.addEventListener('click', function (event) {
        if (event.target === paymentModal) {
            paymentModal.style.display = 'none';
        }
    });
});

