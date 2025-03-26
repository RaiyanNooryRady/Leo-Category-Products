document.getElementById('lcpPricingType').addEventListener('change', function() {
    // Get all the regular price and sale price elements
    var regularPrices = document.getElementsByClassName('lcp-base-price');
    var salePrices = document.getElementsByClassName('lcp-sale-price');

    // Loop through each product
    for (var i = 0; i < regularPrices.length; i++) {
        // Get the current regular price and sale price for this product
        var regularPrice = regularPrices[i];
        var salePrice = salePrices[i];

        // Check if the checkbox is checked
        if (this.checked) {
            // If sale price is visible, hide it and remove the strikethrough class from regular price
            if (salePrice.style.display !== 'none') {
                salePrice.style.display = 'none';
                regularPrice.classList.remove('text-strikethrough');
            }
        } else {
            // If sale price is hidden, show it and add the strikethrough class to regular price
            if (salePrice.style.display === 'none') {
                salePrice.style.display = 'block';
                regularPrice.classList.add('text-strikethrough');
            }
        }
    }
});
