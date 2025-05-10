function showCart(data) {
    console.log('showCart called with data:', data);
    try {
        $('#cart-modal .modal-body').html(data.html);
        const modalElement = document.getElementById('cart-modal');
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modal.show();
        let cartQty = data.cart_qty || 0;
        $('.mini-cart-qty').text(cartQty);
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    } catch (error) {
        console.error('showCart error:', error);
        alert('Ошибка при отображении корзины: ' + error.message);
    }
}
function updateCheckout(data) {
    console.log('updateCheckout called with data:', data);
    try {
        const cartContainer = $('.cart-container');
        const cartTable = $('.cart-table');
        const tempContainer = $('<div>').html(data.cart_table);
        const isFullHtml = tempContainer.find('html, head, body').length > 0;
        console.log('Is full HTML:', isFullHtml);

        const filteredContent = tempContainer.find('.cart-table').length
            ? tempContainer.find('.cart-table')
            : tempContainer.children().filter(':not(html, head, body, script, style)');

        console.log('Filtered content:', filteredContent[0]?.outerHTML || 'No content');
        console.log('Cart container found:', cartContainer.length, 'Selector:', cartContainer.attr('class'));

        if (data.cart_qty > 0 && cartTable.length) {
            console.log('Updating cart table, qty:', data.cart_qty);
            cartTable.replaceWith(filteredContent);

            $('#cart-qty-total').text(data.cart_qty || 0);
            $('#cart-price-total').text((Number(data.cart_total) || 0).toFixed(2) + ' руб.');
        } else if (cartContainer.length) {
            console.log('Empty cart, replacing cart container');

            cartContainer.empty();
            cartContainer.append(filteredContent);

            const checkoutForm = $('#checkoutForm');
            if (checkoutForm.length) {
                console.log('Hiding checkoutForm');
                checkoutForm.hide();
            } else {
                console.warn('checkoutForm not found');
            }
        } else {
            console.error('Cart container not found');
        }

        $('.mini-cart-qty').text(data.cart_qty || 0);

        if (!data.cart_qty) {
            console.log('Hiding btn-cart');
            $('.btn-cart').addClass('d-none');
        } else {
            $('.btn-cart').removeClass('d-none');
        }
    } catch (error) {
        console.error('updateCheckout error:', error);
        alert('Ошибка при обновлении страницы оформления: ' + error.message);
    }
}

function getCart(action) {
    console.log('getCart called with action:', action);
    $.ajax({
        url: action,
        type: 'get',
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function (result) {
            console.log('getCart success:', result);
            if (result.success) {
                showCart(result);
            } else {
                alert('Ошибка при загрузке корзины: ' + (result.message || 'Неизвестная ошибка'));
            }
        },
        error: function (xhr, status, error) {
            console.error('getCart error:', xhr, status, error);
            alert('Ошибка при загрузке корзины: ' + (xhr.responseJSON?.message || error));
        }
    });
}
$(function () {
    $('.addtocart').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        console.log('addtocart submitted:', form.serialize());
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'post',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (result) {
                console.log('addtocart success:', result);
                if (result.success) {
                    showCart(result);
                    form[0].reset();
                } else {
                    alert('Ошибка при добавлении товара: ' + (result.message || 'Неизвестная ошибка'));
                }
            },
            error: function (xhr, status, error) {
                console.error('addtocart error:', xhr, status, error);
                alert('Ошибка при добавлении товара: ' + (xhr.responseJSON?.message || error));
            }
        });
    });
    $(document).on('click', '.del-item', function (e) {
        e.preventDefault();
        const action = $(this).data('action');
        console.log('del-item clicked:', action);
        $.ajax({
            url: action,
            type: 'get',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (result) {
                console.log('del-item success:', result);
                if (result.success) {
                
                    if ($('.cart-table').length) {
                        updateCheckout(result);
                    } else {
                        showCart(result);
                    }
                } else {
                    alert('Ошибка при удалении товара: ' + (result.message || 'Неизвестная ошибка'));
                }
            },
            error: function (xhr, status, error) {
                console.error('del-item error:', xhr, status, error);
                alert('Ошибка при удалении товара: ' + (xhr.responseJSON?.message || error));
            }
        });
    });
});

window.addEventListener('load', () => {
    setTimeout(() => {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 1000);
        }
    }, 1000);
});
