          <h2>Social Media Settings</h2>
          <p>Please supply full urls except as indicated. Leave blank any items you do not wish to display.</p>
          <ul class="input-table">
              <li>
                  <label for="facebook_link">Facebook Link <i class="fa fa-facebook"></i></label>
                  <div class="input">
                    <input name="facebook_link" type="text" id="facebook_link" value="<?php echo get_option('msdsocial_facebook_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="twitter_user">Twitter (username only) <i class="fa fa-twitter"></i></label>
                  <div class="input">
                    <input name="twitter_user" type="text" id="twitter_user" value="<?php echo get_option('msdsocial_twitter_user'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="pinterest_link">Pinterest Link <i class="fa fa-pinterest"></i></label>
                  <div class="input">
                    <input name="pinterest_link" type="text" id="pinterest_link" value="<?php echo get_option('msdsocial_pinterest_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="google_link">Google+ Link <i class="fa fa-google-plus"></i></label>
                  <div class="input">
                    <input name="google_link" type="text" id="google_link" value="<?php echo get_option('msdsocial_google_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="linkedin_link">LinkedIn Link <i class="fa fa-linkedin"></i></label>
                  <div class="input">
                    <input name="linkedin_link" type="text" id="linkedin_link" value="<?php echo get_option('msdsocial_linkedin_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="instagram_link">Instagram Link <i class="fa fa-instagram"></i></label>
                  <div class="input">
                    <input name="instagram_link" type="text" id="instagram_link" value="<?php echo get_option('msdsocial_instagram_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="tumblr_link">Tumblr Link <i class="fa fa-tumblr"></i></label>
                  <div class="input">
                    <input name="tumblr_link" type="text" id="tumblr_link" value="<?php echo get_option('msdsocial_tumblr_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="reddit_link">Reddit Link <i class="fa fa-reddit"></i></label>
                  <div class="input">
                    <input name="reddit_link" type="text" id="reddit_link" value="<?php echo get_option('msdsocial_reddit_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="flickr_link">Flickr Link <i class="fa fa-flickr"></i></label>
                  <div class="input">
                    <input name="flickr_link" type="text" id="flickr_link" value="<?php echo get_option('msdsocial_flickr_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="youtube_link">YouTube Link <i class="fa fa-youtube"></i></label>
                  <div class="input">
                    <input name="youtube_link" type="text" id="youtube_link" value="<?php echo get_option('msdsocial_youtube_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="vimeo_link">Vimeo Link <i class="fa fa-vimeo-square"></i></label>
                  <div class="input">
                    <input name="vimeo_link" type="text" id="vimeo_link" value="<?php echo get_option('msdsocial_vimeo_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="vine_link">Vine Link <i class="fa fa-vine"></i></label>
                  <div class="input">
                    <input name="vine_link" type="text" id="vine_link" value="<?php echo get_option('msdsocial_vine_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="sharethis_link">Sharethis Link <i class="fa fa-share-alt"></i></label>
                  <div class="input">
                    <input name="sharethis_link" type="text" id="sharethis_link" value="<?php echo get_option('msdsocial_sharethis_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="contact_link">Contact Link <i class="fa fa-envelope"></i></label>
                  <div class="input">
                    <input name="contact_link" type="text" id="contact_link" value="<?php echo get_option('msdsocial_contact_link'); ?>" class="regular-text" />
                  </div>
              </li>
              <li>
                  <label for="show_feed">Show Feed? <i class="fa fa-rss"></i></label>
                  <div class="input">
                    <input name="show_feed" type="checkbox" id="show_feed" value="true" <?php print get_option('msdsocial_show_feed')==true?'CHECKED':''; ?>> yes
                  </div>
              </li>
          </ul>