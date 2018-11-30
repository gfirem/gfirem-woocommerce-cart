<input type="hidden" value="<?php echo esc_attr($form_action->post_content['product_id']); ?>" name="<?php echo $action_control->get_field_name('form_id') ?>">
<h3><?php echo __('Set the data you like to push to WooCommerce Checkout', 'gfirem-woo-cart') ?></h3>
<ol>
    <li>
        <div>
            <h3><?php _e('Select the product you want to push to checkout.', 'gfirem-woo-cart'); ?></h3>
            <div>
                <table class="form-table frm-no-margin">
                    <tbody>
                    <tr>
                        <th><label> <strong><?php _e('WC Product: ', 'gfirem-woo-cart'); ?></strong></label></th>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li>
        <div>
            <h3><?php _e('Fill the WooCommerce fields with the values from the Form.', 'gfirem-woo-cart'); ?></h3>
            <div>
                Make a foreach for all Woocommerce checkout field and show the next html
                <table class="form-table frm-no-margin">
                    <tbody>
                    <tr>
                        <th><label> <strong><?php _e('Name: ', 'gfirem-woo-cart'); ?></strong></label></th>
                        <td>
                            <input type="text" class="large-text gfirem-woo-cart-field" id="billing_name_<?php echo $this->number ?>" value="<?php echo esc_attr($form_action->post_content['billing_name']); ?>" name="<?php echo $action_control->get_field_name('billing_name') ?>">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
</ol>
