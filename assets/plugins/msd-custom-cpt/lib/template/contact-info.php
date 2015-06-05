<?php global $wpalchemy_media_access; 
?>

<ul class="meta_control">
    <li>
        <?php $metabox->the_field('_team_last_name'); ?>
            <label>Last Name <i class="fa fa-sort-alpha-asc"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                <span>For alphabetizing</span>
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_email'); ?>
            <label>Email <i class="fa fa-envelope"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_phone'); ?>
            <label>Phone <i class="fa fa-phone"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_mobile'); ?>
            <label>Mobile <i class="fa fa-mobile"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_fax'); ?>
            <label>Fax <i class="fa fa-fax"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_linked_in'); ?>
            <label>LinkedIn URL <i class="fa fa-linkedin"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_twitter'); ?>
            <label>Twitter Username <i class="fa fa-twitter"></i></label>
            <div class="input_container">
                <input type="text" placeholder="@" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_facebook'); ?>
            <label>Facebook URL <i class="fa fa-facebook"></i></label>
            <div class="input_container">
                <input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_vcard'); ?>
            <label>vCard File <i class="fa fa-info-circle"></i></label>
            <div class="input_container">
                <?php $wpalchemy_media_access->setGroupName('team_vcard'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
           </div>
        </li>
    <li>
        <?php $metabox->the_field('_team_bio_sheet'); ?>
            <label>Bio Sheet File <i class="fa fa-user"></i></label>
            <div class="input_container">
                <?php $wpalchemy_media_access->setGroupName('_team_bio_sheet'. $mb->get_the_index())->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
           </div>
        </li>
</ul>
<script>
jQuery(function($){
    $("#postdivrich").after($("#_testimonial_info_metabox"));
});</script>