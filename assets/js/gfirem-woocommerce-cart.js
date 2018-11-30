function GFireMWooCart() {
  var controller = false;

  function emulateFormidableInsertFieldCode(id) {
    jQuery('.frm_code_list a').removeClass('frm_noallow').addClass('frm_allow');
    jQuery('.frm_code_list a.hide_' + id).addClass('frm_noallow').removeClass('frm_allow');
    jQuery('#frm-insert-fields-box,#frm-conditionals,#frm-adv-info-tab,#frm-html-tags,#frm-layout-classes,#frm-dynamic-values').removeClass().addClass('tabs-panel ' + id);
  }

  return {
    init: function() {
      if (document.getElementById('frm_notification_settings') !== null) {
        instanceGFireMWooCart.formActionsInit();
      }
    },

    formActionsInit: function() {
      jQuery(document).bind('ajaxComplete ', function(event, xhr, settings) {
        if (settings.data) {
          if (settings.data.indexOf('frm_form_action_fill') !== 0 && settings.data.indexOf('gfirem-woo-cart') !== 0) {
            jQuery('.frm_single_gfirem-woo-cart_settings ').each(function() {
              var action = jQuery(this);
              var isLoaded = action.attr('is-ready');
              isLoaded = (typeof(isLoaded) === 'undefined');
              if (isLoaded) {
                if (controller === false) {
                  jQuery(document).on('focusin click', 'form input, form textarea', function(e) {
                    var id = jQuery(this).attr('id');
                    jQuery('#frm-insert-fields-box,#frm-conditionals,#frm-adv-info-tab,#frm-html-tags,#frm-layout-classes,#frm-dynamic-values').removeClass().addClass('tabs-panel ' + id);
                    if (jQuery(this).hasClass('gfirem-woo-cart-field')) {
                      jQuery('.frm_code_list a').removeClass('frm_noallow').addClass('frm_allow');
                      jQuery('.frm_code_list a.hide_' + id).addClass('frm_noallow').removeClass('frm_allow');
                    } else {
                      jQuery('.frm_code_list a').addClass('frm_noallow').removeClass('frm_allow');
                    }
                  });
                  controller = true;
                }
                action.attr('is-ready', 'true');
              }
            });
          }
        }
      });
    },
  };
}

var instanceGFireMWooCart = GFireMWooCart();
jQuery(document).ready(function() {
  instanceGFireMWooCart.init();
});