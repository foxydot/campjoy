          <h2>Plugin Settings</h2>
          <p></p>
          <ul class="input-table">
              <li>
                  <label for="icon_size">Icon Size</label>
                  <div class="input">
                    <input name="icon_size" type="radio" id="icon_size" value="0" <?php print get_option('msdsocial_icon_size')==0?'CHECKED':''; ?>> None, use FontAwesome &nbsp;|&nbsp;
                    <input name="icon_size" type="radio" id="icon_size" value="16" <?php print get_option('msdsocial_icon_size')==16?'CHECKED':''; ?> disabled> 16 &nbsp;|&nbsp;
                    <input name="icon_size" type="radio" id="icon_size" value="24" <?php print get_option('msdsocial_icon_size')==24?'CHECKED':''; ?> disabled> 24 &nbsp;|&nbsp;
                    <input name="icon_size" type="radio" id="icon_size" value="32" <?php print get_option('msdsocial_icon_size')==32?'CHECKED':''; ?> disabled> 32
                  </div>
              </li>
          </ul>