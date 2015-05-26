<?php global $wpalchemy_media_access; ?>

<?php 

$postid = is_admin()?$_GET['post']:$post->ID;
$template_file = get_post_meta($postid,'_wp_page_template',TRUE);
  // check for a template type
if (is_admin()){
    if($template_file == 'page-sectioned.php' ) { ?>
<div class="msdlab_meta_control">
    <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
    <div class="table">
    <?php $i = 1; ?>
    <?php while($mb->have_fields_and_multi('sections')): ?>
    <?php $mb->the_group_open(); ?>
    <div class="row <?php print $i%2==1?'even':'odd'; ?>">
        <div class="cell">
            <h3>
                Section <?php print $i ?>
            </h3>
        </div>
        <div class="cell">
            <?php $mb->the_field('section-name'); ?>
            <label>Section Name*</label>            
            <div class="input_container">
                <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/><br />
                <i>Please use a section name. This is used to produce identifying wrappers for the content!</i>
            </div>
        </div>
        <div class="cell">
            <?php $mb->the_field('layout'); ?>
            <label>Section <?php print $i ?> Layout</label>            
            <div class="input_container">
                <select name="<?php $mb->the_name(); ?>" class="layout">
                    <option value=""<?php $mb->the_select_state('default'); ?>>Default</option>
                    <option value="two-col"<?php $mb->the_select_state('two-col'); ?>>Two Columns</option>
                    <option value="three-col"<?php $mb->the_select_state('three-col'); ?>>Three Columns</option>
                    <option value="four-col"<?php $mb->the_select_state('four-col'); ?>>Four Columns</option>
                </select>
            </div>
        </div>
        <div class="cell file">
            <label>Background Image</label>
            <div class="input_container">
                <?php $mb->the_field('background-image'); ?>
                <?php if($mb->get_the_value() != ''){
                    $thumb_array = wp_get_attachment_image_src( get_attachment_id_from_src($mb->get_the_value()), 'thumbnail' );
                    $thumb = $thumb_array[0];
                } else {
                    $thumb = WP_PLUGIN_URL.'/msd-specialty-pages/lib/img/spacer.gif';
                } ?>
                <img class="background-preview-img" src="<?php print $thumb; ?>">
                <?php $group_name = 'background-img-'. $mb->get_the_index(); ?>
                <?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
                <br />
                <?php $mb->the_field('background-image-parallax'); ?>
                <input type="checkbox" name="<?php $mb->the_name(); ?>" value="1"<?php $mb->the_checkbox_state('1'); ?>/> Parallax background image
            </div>
        </div>
        <div class="cell file">
            <label>Background Color</label>
            <div class="input_container">
                <?php $mb->the_field('background-color'); ?>
                <input class="colorpicker" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
            </div>
        </div>       
        <div class="cell">
            <?php $mb->the_field('css-classes'); ?>
            <label>CSS Classes</label>            
            <div class="input_container">
                <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/><br />
            </div>
        </div>
        <div class="content-area box">
            <div class="cell">
                <h4>
                    Content Area
                </h4>
            </div>
            <div class="cell">
                <?php $mb->the_field('content-area-title'); ?>
                <label>Title</label>            
                <div class="input_container">
                    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
                </div>
            </div>
            <div class="cell">
                <?php $mb->the_field('content-area-subtitle'); ?>
                <label>Subtitle</label>            
                <div class="input_container">
                    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
                </div>
            </div>
            <div class="cell">
                <label>Section Header Content</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('header-area-content');
                    $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                    $mb_editor_id = sanitize_key($mb->get_the_name());
                    $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                    wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                    ?>
               </div>
            </div>
            <div class="cell column-1">
                <label class="cols-2 cols-3 cols-4">Column 1 Width</label>
                <div class="input_container cols-2 cols-3 cols-4">
                    <?php 
                    $mb->the_field('content-area-width');
                    ?>
                    <input class="input-range" type="range" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" min="1" max="12"><span class="range-value"></span>
                </div>
                <label><span class="cols-2 cols-3 cols-4">Column 1 </span>Content</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('content-area-content');
                    $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                    $mb_editor_id = sanitize_key($mb->get_the_name());
                    $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                    wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                    ?>
               </div>
            </div>
            <div class="cell column-2 cols-2 cols-3 cols-4">
                <label>Column 2 Width</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('column-2-area-width');
                    ?>
                    <input class="input-range" type="range" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" min="1" max="12"><span class="range-value"></span>
                </div>
                <label>Column 2 Content</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('column-2-area-content');
                    $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                    $mb_editor_id = sanitize_key($mb->get_the_name());
                    $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                    wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                    ?>
               </div>
            </div>
            <div class="cell column-3 cols-3 cols-4">
                <label>Column 3 Width</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('column-3-area-width');
                    ?>
                    <input class="input-range" type="range" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" min="1" max="12"><span class="range-value"></span>
                </div>
                <label>Column 3 Content</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('column-3-area-content');
                    $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                    $mb_editor_id = sanitize_key($mb->get_the_name());
                    $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                    wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                    ?>
               </div>
            </div>
            <div class="cell column-4 cols-4">
                <label>Column 4 Width</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('column-4-area-width');
                    ?>
                    <input class="input-range" type="range" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" min="1" max="12"><span class="range-value"></span>
                </div>
                <label>Column 4 Content</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('column-4-area-content');
                    $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                    $mb_editor_id = sanitize_key($mb->get_the_name());
                    $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                    wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                    ?>
               </div>
            </div>
            <div class="cell">
                <label>Section Footer Content</label>
                <div class="input_container">
                    <?php 
                    $mb->the_field('footer-area-content');
                    $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                    $mb_editor_id = sanitize_key($mb->get_the_name());
                    $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                    wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                    ?>
               </div>
            </div>
            <div class="cell file">
                <label>Feature Image</label>
                <div class="input_container">
                <?php $mb->the_field('content-area-image'); ?>
                <?php if($mb->get_the_value() != ''){
                    $thumb_array = wp_get_attachment_image_src( get_attachment_id_from_src($mb->get_the_value()), 'thumbnail' );
                    $thumb = $thumb_array[0];
                } else {
                    $thumb = WP_PLUGIN_URL.'/msd-specialty-pages/lib/img/spacer.gif';
                } ?>
                <img class="content-area-preview-img" src="<?php print $thumb; ?>">
                <?php $group_name = 'content-area-feature-img-'. $mb->get_the_index(); ?>
                <?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
                
                <br />
                <?php $mb->the_field('feature-image-float'); ?>
                <strong>Feature image align:</strong> 
                <input type="radio" name="<?php $mb->the_name(); ?>" value="none"<?php $mb->the_radio_state('none'); ?>/> None 
                <input type="radio" name="<?php $mb->the_name(); ?>" value="left"<?php $mb->the_radio_state('left'); ?>/> Left 
                <input type="radio" name="<?php $mb->the_name(); ?>" value="center"<?php $mb->the_radio_state('center'); ?>/> Center 
                <input type="radio" name="<?php $mb->the_name(); ?>" value="right"<?php $mb->the_radio_state('right'); ?>/> Right 
                </div>
            </div>
        </div>
        <div class="cell footer">
            <a href="#" class="dodelete button alignright">Remove Section <?php print $i ?></a>
        </div>
    </div>
    <?php $i++; ?>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    </div>
    <p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-sections button">Add Section</a>
</div>
<?php } elseif($template_file == 'page-simple-sectioned.php') { ?>
    <div class="msdlab_meta_control">
 <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
    <div class="table">
    <?php $i = 1; ?>
    <?php while($mb->have_fields_and_multi('sections')): ?>
    <?php $mb->the_group_open(); ?>
    <div class="row <?php print $i%2==1?'even':'odd'; ?>">
        <div class="cell"><h3>Section <?php print $i ?> </h3></div>
        <div class="cell">
        <?php $mb->the_field('content-area-title'); ?>
        <label>Section <?php print $i ?> Content Area Title</label>            
        <div class="input_container">
            <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></div>
        </div>
        <div class="cell">
            <?php $mb->the_field('content-area-subtitle'); ?>
            <label>Section <?php print $i ?> Subtitle</label>            
            <div class="input_container">
                <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
            </div>
        </div>
        <div class="cell">
            <label>Section <?php print $i ?> Content Area Content</label>
            <div class="input_container">
                <?php 
                $mb->the_field('content-area-content');
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
           </div>
        </div>
        <div class="cell file">
            <label>Section <?php print $i ?> Feature Image</label>
            <div class="input_container">
        <?php $mb->the_field('content-area-image'); ?>
        <?php if($mb->get_the_value() != ''){
            print '<img src="'.$mb->get_the_value().'">';
        } ?>
        <?php $group_name = 'feature-img-'. $mb->get_the_index(); ?>
        <?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
        <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
        <?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Image')); ?>
            </div>
        </div>
        <div class="cell">
            <a href="#" class="dodelete button alignright">Remove Section <?php print $i ?></a>
        </div>
    </div>
    <?php $i++; ?>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    </div>
    <p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-sections button">Add Section</a>
</div>
<?php } else {
    print "Select \"Sectioned Page\" or \"Simple Sectioned Page\" template and save to activate.";
}
} ?>
