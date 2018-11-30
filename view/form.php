<input type="hidden" value="<?php echo esc_attr($form_action->post_content['product_id']); ?>" name="<?php echo $action_control->get_field_name('form_id') ?>">
<h3><?php echo __('Set the data you like to push to WooCommerce Checkout', 'gfirem-woo-cart') ?></h3>
<ol>
    <li>
        <div>
            <h3><?php _e('Select the behavior of the action.', 'gfirem-woo-cart'); ?></h3>
            <div>
                <table class="form-table frm-no-margin">
                    <tbody>
                    <tr>
                        <th>
                            <label for="is_clean_cart_enabled_<?php echo $this->number ?>"> <strong><?php echo __('Clean Cart: ', 'gfirem-woo-cart'); ?></strong></label>
                        </th>
                        <td>
                            <input type="checkbox" <?php checked(1, $form_action->post_content['is_clean_cart_enabled']) ?> name="<?php echo $action_control->get_field_name('is_clean_cart_enabled') ?>" id="is_clean_cart_enabled_<?php echo $this->number ?>" value="1"/>
							<?php echo __('Enable this to clean the cart before process the action.', 'gfirem-woo-cart') ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="is_country_name_search_enabled_<?php echo $this->number ?>"> <strong><?php echo __('Country by Name: ', 'gfirem-woo-cart'); ?></strong></label>
                        </th>
                        <td>
                            <input type="checkbox" <?php checked(1, $form_action->post_content['is_country_name_search_enabled']) ?> name="<?php echo $action_control->get_field_name('is_country_name_search_enabled') ?>" id="is_country_name_search_enabled_<?php echo $this->number ?>" value="1"/>
							<?php echo __('Tick this if you want the process match the Country by the name instead the code.', 'gfirem-woo-cart') ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="is_state_name_search_enabled_<?php echo $this->number ?>"> <strong><?php echo __('State by Name: ', 'gfirem-woo-cart'); ?></strong></label>
                        </th>
                        <td>
                            <input type="checkbox" <?php checked(1, $form_action->post_content['is_state_name_search_enabled']) ?> name="<?php echo $action_control->get_field_name('is_state_name_search_enabled') ?>" id="is_state_name_search_enabled_<?php echo $this->number ?>" value="1"/>
							<?php echo __('Tick this if you want the process match the State by the name instead the code.', 'gfirem-woo-cart') ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
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
                                            <input type="text" class="large-text gfirem-woo-cart-field" id="<?php echo $field_set_key . '_' . $key . '_' . $this->number ?>" value="<?php echo esc_attr($form_action->post_content[$key]); ?>" name="<?php echo $action_control->get_field_name($key) ?>">
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
