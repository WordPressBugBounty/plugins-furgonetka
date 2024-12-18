window.FurgonetkaAdmin = {

    /**
     * Contains handle for currently pending AJAX request
     */
    modalAjaxHandle: null,

    sendAjaxRequest: function (event, action) {
        var $ = jQuery.noConflict();

        event.preventDefault();

        if (event.currentTarget) {
            var target = $(event.currentTarget);

            if (target.attr("data-order-id")) {
                var data = {
                    action: action,
                    order_id: target.attr("data-order-id")
                };

                $(".furgonetka-modal #furgonetka-iframe iframe").attr("src", "about:blank");
                $(".furgonetka-modal").removeClass("furgonetka-modal-hidden");

                window.FurgonetkaAdmin.modalAjaxHandle = $.post(
                    furgonetka_modal.ajax_url,
                    data,
                    function (response) {
                        window.FurgonetkaAdmin.modalAjaxHandle = null;

                        if (response.success && response.data && response.data.url) {
                            $(".furgonetka-modal #furgonetka-iframe iframe").attr("src", response.data.url);
                        } else {
                            if (response.data && response.data.error_message) {
                                alert(response.data.error_message);
                            }

                            $(".furgonetka-modal").addClass("furgonetka-modal-hidden");

                            if (response.data && response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            }
                        }
                    }
                );
            }
        }

    },

    /**
     * Invoice handler
     *
     * @param event
     */
    invoice: function (event) {
        window.FurgonetkaAdmin.sendAjaxRequest(event, "furgonetka_invoices_init")
    },

    /**
     * Fast shipping handler
     *
     * @param event
     */
    fastShipping: function (event) {
        window.FurgonetkaAdmin.sendAjaxRequest(event, "furgonetka_fast_shipping_init")
    },
};

jQuery(document).ready(function ($) {
    /**
     * Fast shipping modal close listener
     */
    $("#furgonetka-iframe-exit").click(function (e) {
        e.preventDefault();

        if (window.FurgonetkaAdmin.modalAjaxHandle) {
            window.FurgonetkaAdmin.modalAjaxHandle.abort();
            window.FurgonetkaAdmin.modalAjaxHandle = null;
        }

        $(".furgonetka-modal").addClass("furgonetka-modal-hidden");
        $(".furgonetka-modal #furgonetka-iframe iframe").attr("src", "about:blank");
    });
});
