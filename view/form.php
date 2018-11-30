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
                            <select name="<?php echo $action_control->get_field_name('product_id') ?>">
                                <option value=""></option>
								<?php foreach ($products as $product) : ?>
                                    <option value="<?php echo $product->id ?>" <?php selected($form_action->post_content['product_id'], $product->id) ?> >
										<?php echo $product->name ?>
                                    </option>
								<?php endforeach; ?>
                            </select>
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
					<?php if (! empty($checkout_fields)) : ?>
						<?php foreach ($checkout_fields as $field_set_key => $field_set) : ?>
							<?php if (! empty($field_set)) : ?>
                                <tr>
                                    <td colspan="2"><h3><?php echo esc_attr(ucwords($field_set_key)) ?></h3></td>
                                </tr>
								<?php foreach ($field_set as $key => $field) : ?>
                                    <tr>
                                        <th><label> <strong><?php echo esc_attr($field['label']) ?></strong></label></th>
                                        <td>
                                            <input type="text" class="large-text gfirem-woo-cart-field" id="<?php echo $key . '_' . $this->number ?>" value="<?php echo esc_attr($form_action->post_content[$key]); ?>" name="<?php echo $action_control->get_field_name($key) ?>">
                                        </td>
                                    </tr>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else : ?>
                        <tr>
                            <td colspan="2"><strong><?php _e('Checkout fields not detected.', 'gfirem-woo-cart'); ?></strong></td>
                        </tr>
					<?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
</ol>
