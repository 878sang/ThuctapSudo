function showToast(message, type = 'success') {
    // Tạo container chứa Toast nếu chưa có
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-5 right-5 z-[9999] flex flex-col gap-3.5 pointer-events-none';
        document.body.appendChild(container);
    }

    // Tạo khối Toast
    const toast = document.createElement('div');
    toast.className = `min-w-[280px] max-w-sm bg-white border-l-4 rounded shadow-lg p-4 flex items-center gap-3 transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto`;

    if (type === 'success') {
        toast.classList.add('border-green-500');
    } else {
        toast.classList.add('border-red-500');
    }

    const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
    const iconClass = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';

    toast.innerHTML = `
        <span class="${iconColor} text-lg flex-shrink-0">
            <i class="fa-solid ${iconClass}"></i>
        </span>
        <div class="flex-grow">
            <p class="text-sm font-semibold text-gray-800 leading-snug">${message}</p>
        </div>
        <button class="text-gray-400 hover:text-gray-600 transition-colors shrink-0">
            <i class="fa-solid fa-xmark text-xs"></i>
        </button>
    `;

    // Sự kiện nút đóng
    toast.querySelector('button').addEventListener('click', () => {
        toast.classList.add('translate-y-2', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    });

    container.appendChild(toast);

    // Kích hoạt hiệu ứng trượt và mờ
    setTimeout(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    }, 10);

    // Tự động biến mất sau 3 giây
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }
    }, 3000);
}
window.showToast = showToast;

// Bắt sự kiện submit của tất cả các form thêm vào giỏ hàng
document.addEventListener('submit', function (event) {
    const form = event.target;

    // Kiểm tra xem form action có trỏ tới route add cart hay không
    if (form.action && form.action.includes('/cart/add')) {
        event.preventDefault(); // Ngăn trình duyệt load lại trang

        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Đánh dấu là Ajax để Laravel Controller nhận biết
                'X-CSRF-TOKEN': formData.get('_token')
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng trên icon giỏ hàng ở Header
                    const cartCountEl = document.getElementById('cart-count');
                    if (cartCountEl) {
                        cartCountEl.textContent = data.cart_count;
                    }

                    // Hiển thị thông báo Toast thành công
                    showToast(data.message || 'Thêm vào giỏ hàng thành công!', 'success');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
            });
    }
    if (form.action && form.action.includes('/cart/update')) {
        event.preventDefault(); // Ngăn trình duyệt load lại trang

        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Đánh dấu là Ajax để Laravel Controller nhận biết
                'X-CSRF-TOKEN': formData.get('_token')
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Cập nhật số lượng trên icon giỏ hàng ở Header
                    const cartCountEl = document.getElementById('cart-count');
                    if (cartCountEl) {
                        cartCountEl.textContent = data.cart_count;
                    }

                    // Cập nhật số lượng hiển thị trên Tiêu đề giỏ hàng
                    const cartTitleCountEl = document.getElementById('cart-title-count');
                    if (cartTitleCountEl) {
                        cartTitleCountEl.textContent = data.cart_count;
                    }

                    // Cập nhật thành tiền của dòng sản phẩm tương ứng
                    const row = form.closest('tr');
                    if (row) {
                        const subtotalEl = row.querySelector('.cart-subtotal');
                        if (subtotalEl) {
                            subtotalEl.textContent = data.item_subtotal;
                        }
                    }

                    // Cập nhật Tổng tiền của giỏ hàng ở Tóm tắt đơn hàng
                    document.querySelectorAll('.cart-total-price').forEach(el => {
                        el.textContent = data.total_price;
                    });
                    document.querySelectorAll('.cart-total-payment').forEach(el => {
                        el.textContent = data.total_price;
                    });
                    document.querySelectorAll('.cart-total-deposit').forEach(el => {
                        el.textContent = data.total_price;
                    });
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Có lỗi xảy ra khi cập nhật vào giỏ hàng!', 'error');
            });
    }
    if (form.action && form.action.includes('/cart/remove')) {
        event.preventDefault(); // Ngăn trình duyệt load lại trang

        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Đánh dấu là Ajax để Laravel Controller nhận biết
                'X-CSRF-TOKEN': formData.get('_token')
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Nếu giỏ hàng rỗng, reload trang để render lại view Giỏ hàng trống
                    if (data.cart_count === 0) {
                        window.location.reload();
                        return;
                    }

                    // Cập nhật số lượng trên icon giỏ hàng ở Header
                    const cartCountEl = document.getElementById('cart-count');
                    if (cartCountEl) {
                        cartCountEl.textContent = data.cart_count;
                    }

                    // Cập nhật số lượng hiển thị trên Tiêu đề giỏ hàng
                    const cartTitleCountEl = document.getElementById('cart-title-count');
                    if (cartTitleCountEl) {
                        cartTitleCountEl.textContent = data.cart_count;
                    }

                    // Xóa các dòng tr của sản phẩm đã bị xóa khỏi DOM
                    const checkedCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
                    checkedCheckboxes.forEach(cb => {
                        const tr = cb.closest('tr');
                        if (tr) {
                            tr.remove();
                        }
                    });

                    // Cập nhật Tổng tiền của giỏ hàng ở Tóm tắt đơn hàng
                    document.querySelectorAll('.cart-total-price').forEach(el => {
                        el.textContent = data.total_price;
                    });
                    document.querySelectorAll('.cart-total-payment').forEach(el => {
                        el.textContent = data.total_price;
                    });
                    document.querySelectorAll('.cart-total-deposit').forEach(el => {
                        el.textContent = data.total_price;
                    });

                    showToast(data.message || 'Xóa sản phẩm thành công!', 'success');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Có lỗi xảy ra khi cập nhật vào giỏ hàng!', 'error');
            });
    }
});
function validateCheckoutStep2(alpineData, url) {
    if (alpineData.isValidating) return;
    alpineData.isValidating = true;

    // Xóa sạch thông báo lỗi cũ
    document.querySelectorAll('.error-message-span').forEach(el => el.textContent = '');
    document.querySelectorAll('[data-error-field]').forEach(el => {
        el.classList.remove('border-red-500');
        el.classList.add('border-[#E5E7EB]');
    });

    const form = document.getElementById('checkout-form');
    if (!form) {
        alpineData.isValidating = false;
        return;
    }

    const formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            // Hiển thị câu báo lỗi dưới ô nhập
                            const errorSpan = document.querySelector(`.error-message-span[data-error-for="${field}"]`);
                            if (errorSpan) {
                                errorSpan.textContent = data.errors[field][0];
                            }
                            // Thêm viền đỏ cho ô nhập
                            const inputEl = document.querySelector(`[data-error-field="${field}"]`);
                            if (inputEl) {
                                inputEl.classList.remove('border-[#E5E7EB]');
                                inputEl.classList.add('border-red-500');
                            }
                        });

                        // Cuộn mượt đến ô lỗi đầu tiên
                        const firstErrorField = Object.keys(data.errors)[0];
                        const firstInput = document.querySelector(`[data-error-field="${firstErrorField}"]`);
                        if (firstInput) {
                            firstInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        showToast(data.message || 'Có lỗi xảy ra khi xác thực thông tin!', 'error');
                    }
                    throw new Error('Validation failed');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alpineData.step = 3;
            }
        })
        .catch(error => {
            console.error('Validation error:', error);
        })
        .finally(() => {
            alpineData.isValidating = false;
        });
}
window.validateCheckoutStep2 = validateCheckoutStep2;