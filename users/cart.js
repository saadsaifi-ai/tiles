$(document).ready(function () {
    console.log("Loaded");

    // Add to Cart
    $('.add-to-cart').click(function () {
        var productId = $(this).data('id');

        // Create spinner icon
        var spinner = $('<div class="cart-spinner"><i class="fa fa-spinner fa-spin"></i></div>');
        $('body').append(spinner);

        $.ajax({
            url: 'users/cart.php?action=add',
            method: 'GET',
            data: { id: productId },
            success: function (response) {
                // Remove spinner after success
                spinner.fadeOut(function() {
                    $(this).remove();
                });
            }
        });
    });

    // Remove from Cart
    $('.remove-from-cart').click(function () {
        var productId = $(this).data('id');

        // Create spinner icon
        var spinner = $('<div class="cart-spinner"><i class="fa fa-spinner fa-spin"></i></div>');
        $('body').append(spinner);

        $.ajax({
            url: 'cart.php?action=remove',
            method: 'GET',
            data: { id: productId },
            success: function (response) {
                // Remove spinner and reload page
                spinner.fadeOut(function() {
                    $(this).remove();
                    location.reload(); 
                });
            }
        });
    });

    // Update Quantity
    $('.update-quantity').click(function () {
        var productId = $(this).data('id');
        // Change the selector to find the quantity input within the same container
        var quantity = $(this).closest('.col-md-4').find('.quantity-input').val();
        console.log(quantity);
        console.log(productId);
        if (quantity <= 0) {
            alert('Quantity must be greater than 0');
            return;
        }

        // Create spinner icon
        var spinner = $('<div class="cart-spinner"><i class="fa fa-spinner fa-spin"></i></div>');
        $('body').append(spinner);

        $.ajax({
            url: 'cartquantity.php',
            method: 'POST',
            data: { id: productId, quantity: quantity },
            success: function (response) {
                console.log(response); 
                spinner.fadeOut(function() {
                    $(this).remove();
                    // location.reload(); 
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
            
        });
    });
    
});




        
