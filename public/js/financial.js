// resources/js/financial.js

// Budget tracking
function trackBudget(budgetId) {
    showLoader();
    fetch(`/budgets/${budgetId}/track`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        if (data.success) {
            showAlert('success', 'Budget tracked successfully');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert('error', data.message || 'Error tracking budget');
        }
    })
    .catch(error => {
        hideLoader();
        console.error('Error:', error);
        showAlert('error', 'Failed to track budget');
    });
}

// Bank account sync
function syncAccount(accountId) {
    showLoader();
    fetch(`/bank-accounts/${accountId}/sync`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        if (data.success) {
            showAlert('success', 'Account synced successfully');
            updateAccountData(accountId, data.account);
        } else {
            showAlert('error', data.message || 'Error syncing account');
        }
    })
    .catch(error => {
        hideLoader();
        console.error('Error:', error);
        showAlert('error', 'Failed to sync account');
    });
}

// Currency conversion
function convertCurrency() {
    const form = document.getElementById('currencyConverterForm');
    showLoader();
    
    fetch('/currency/convert', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            amount: form.amount.value,
            from_currency: form.from_currency.value,
            to_currency: form.to_currency.value
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        if (data.success) {
            document.getElementById('conversionResult').innerHTML = `
                <div class="alert alert-success">
                    ${data.amount} ${data.from_currency} = 
                    ${data.converted_amount} ${data.to_currency}
                </div>`;
        } else {
            showAlert('error', data.message || 'Error converting currency');
        }
    })
    .catch(error => {
        hideLoader();
        console.error('Error:', error);
        showAlert('error', 'Failed to convert currency');
    });
}

// Helper functions
function showLoader() {
    const loader = document.createElement('div');
    loader.id = 'page-loader';
    loader.innerHTML = `
        <div class="loader-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    document.body.appendChild(loader);
}

function hideLoader() {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.remove();
    }
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

function updateAccountData(accountId, accountData) {
    const accountRow = document.querySelector(`tr[data-account-id="${accountId}"]`);
    if (accountRow) {
        accountRow.querySelector('.current-balance').textContent = 
            new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' })
                .format(accountData.current_balance);
        accountRow.querySelector('.last-synced').textContent = 
            'Just now';
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Currency converter form submission
    const converterForm = document.getElementById('currencyConverterForm');
    if (converterForm) {
        converterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            convertCurrency();
        });
    }

    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
});

// Add required CSS
const style = document.createElement('style');
style.textContent = `
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
`;
document.head.appendChild(style);