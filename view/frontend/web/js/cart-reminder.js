define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/url'
], function(Component, ko, $, urlBuilder) {
    'use strict';
    return Component.extend({
        defaults: {
            items: []
        },
        initialize: function () {
            this._super();
            this.items = ko.observableArray(this.items);
        },
        goToCheckout: function() {
            window.location.href = urlBuilder.build('checkout');
        },
        closePopup: function() {
            $('#cart-reminder-popup').hide();
        }
    });
});