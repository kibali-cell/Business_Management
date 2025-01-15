document.addEventListener('DOMContentLoaded', function() {
    // Transaction amount calculation
    const calculateTotal = () => {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
        const taxAmount = subtotal * (taxRate / 100);
        const total = subtotal + taxAmount;

        document.getElementById('tax').value = taxAmount.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    };

    // Add event listeners to recalculate on input change
    document.getElementById('subtotal')?.addEventListener('input', calculateTotal);
    document.getElementById('tax_rate')?.addEventListener('input', calculateTotal);
});