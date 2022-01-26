define(
    ['jquery',
        'underscore',
        'ko',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/model/quote'
    ],
    function (
        $,
        _,
        ko,
        Component,
        quote
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'SkillUp_CustomPayment/payment/custompayment',
                weatherMessag: ko.observable(false),
                cityWeather: ko.observable(false),
                temperature: ko.observable(false),
                deliveryDay: ko.observable(false)
            },
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            getInstructions: function () {
                return window.checkoutConfig.payment.instructions[this.item.method];
            },
            getWeather: function () {
                var self = this;
                $.ajax({
                    type: "POST",
                    url: '/weather/weather/report/',
                    data: {
                        'city':quote.shippingAddress().city,
                        'country':quote.shippingAddress().countryId,
                    },
                    success: function (data) {
                        if (data) {
                            var dataWeather = jQuery.parseJSON(data)
                            self.cityWeather(dataWeather.weather);
                            self.temperature(Math.round(dataWeather.temp));
                            self.deliveryDay(dataWeather.day);
                            self.weatherMessag(true);
                        }
                    },
                });
            },
        });
    }
);
