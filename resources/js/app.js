import './bootstrap';

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

const app = document.getElementById('app');

Echo.channel('product')
    .listen('ProductCreated', ({product}) => {
        app.innerHTML += `ProductCreated #${product.id} - ${product.name}<br>`
    })
    .listen('ProductUpdated',({product}) => {
        app.innerHTML += `ProductUpdated #${product.id} - ${product.name}<br>`
    })
    .listen('ProductDeleted', ({product_id}) => {
        app.innerHTML += `ProductDeleted #${product_id}<br>`
    })

