/*
 * Mage2developer
 * Copyright (C) 2021 Mage2developer
 *
 * @category Mage2developer
 * @package Mage2_Inquiry
 * @copyright Copyright (c) 2021 Mage2developer
 * @author Mage2developer <mage2developer@gmail.com>
 */

define([
    'ko',
    'jquery',
    'uiComponent'
], function (
    ko,
    $,
    Component
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Mage2_Inquiry/inquiry-graphql',
            result: ko.observableArray(),
            isInquiries: ko.observable(0),
            isModuleDisplayFront: ko.observable(0)
        },

        initialize: function () {
            this._super();
            var self = this;

            $(".question-listing").hide();
            this.isModuleDisplayFront(Number(this.isDisplayFront));

            const query = `
{
  inquiry(sku:"` + this.currentProductSku + `", display_front:1) {
    totalCount
    items {
      inquiry_id
      message
      admin_message
    }
  }
}
`;
            const payload = {
                query: query,
                variables: {
                    sku: this.currentProductSku,
                    display_front: 1
                }
            };

            $.ajax({
                url: 'graphql',
                contentType: 'application/json',
                dataType: 'json',
                type: 'POST',
                data: JSON.stringify(payload),
                success: (function (response) {
                    self.result(response.data);

                    if (self.result().inquiry.totalCount > 0) {
                        self.isInquiries(1);
                    }
                }),
                error: (function (error) {
                    console.log(error);
                })
            });

            return this;
        },

        toggleQueAns: function() {
            $(".question-listing").slideToggle("slow");
        }
    });
});
