                <div class="wrap">
                <h2>Image Slider</h2>
                <form method="post" id="msd_imageslider_options">
                <?php wp_nonce_field('msd_imageslider-update-options'); ?>
                    <table width="100%" cellspacing="2" cellpadding="5" class="form-table"> 
                        <tr valign="top"> 
                            <th width="33%" scope="row"><?php _e('Option 1:', $this->localizationDomain); ?></th> 
                            <td><input name="msd_imageslider_path" type="text" id="msd_imageslider_path" size="45" value="<?php echo $this->options['msd_imageslider_path'] ;?>"/>
                        </td> 
                        </tr>
                        <tr valign="top"> 
                            <th width="33%" scope="row"><?php _e('Option 2:', $this->localizationDomain); ?></th> 
                            <td><input name="msd_imageslider_allowed_groups" type="text" id="msd_imageslider_allowed_groups" value="<?php echo $this->options['msd_imageslider_allowed_groups'] ;?>"/>
                            </td> 
                        </tr>
                        <tr valign="top"> 
                            <th><label for="msd_imageslider_enabled"><?php _e('CheckBox #1:', $this->localizationDomain); ?></label></th><td><input type="checkbox" id="msd_imageslider_enabled" name="msd_imageslider_enabled" <?=($this->options['msd_imageslider_enabled']==true)?'checked="checked"':''?>></td>
                        </tr>
                        <tr>
                            <th colspan=2><input type="submit" name="msd_imageslider_save" value="Save" /></th>
                        </tr>
                    </table>
                </form>