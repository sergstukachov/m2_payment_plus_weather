define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'custompayment',
                component: 'SkillUp_CustomPayment/js/view/payment/method-renderer/custompayment-method'
            }
        );
        return Component.extend({});
    }
);