document.addEventListener("DOMContentLoaded",(function(){const{registerCheckoutFilters:t}=window.wc.blocksCheckout,{getSetting:e}=window.wc.wcSettings,o="furgonetka-checkout-filters",c=e(o+"_data")||{};t(o,{proceedToCheckoutButtonLink:(t,e,o)=>o?.cart.items&&c.furgonetka_replacement_checkout_url||t})}));