<?php 

/* generate sidebar filters 
 * $slug, string 
 * $type, array 
 * $tax, boolean 
*/
function generate_filters( $slug, $type, $tax = false, $allowed = false ) { 
  $params = get_url_params();
  $slug = $slug;
  foreach ( $type as $i ) {
    if ( !empty( $i ) ) {
      if ( $tax ) {
        $ancestors = get_ancestors($i->term_id, $slug); 
        $depth = count($ancestors) + 1; 

        if ( $allowed === false ) { 
        ?>
          <label 
            for="<?php echo $i->name; ?>" 
            class="selection-label" 
            data-parent="<?php echo $i->parent ?>"
            data-depth="level-<?php echo $depth; ?>"
            data-termID="<?php echo $i->term_id ?>">
            <input type="checkbox" 
              class="selection-input" 
              data-category="<?php echo $i->slug; ?>" 
              data-termID="<?php echo $i->term_id ?>" 
              id="<?php echo $i->name; ?>" 
              name="<?php echo $slug; ?>[]"
              value="<?php echo $i->slug; ?>" 
              <?php
              foreach($params as $param) {
                if ( in_array( $i->slug, $param )) {
                  echo 'checked';
                }
              }
              ?> />
            <span class="checked-box"></span>
            <?php echo $i->name; ?>
          </label> 
        <?php 
        } else {
          if ( in_array($i->slug, $allowed) ) { 
          ?>
          <label 
            for="<?php echo $i->name; ?>" 
            class="selection-label" 
            data-parent="<?php echo $i->parent ?>"
            data-depth="level-<?php echo $depth; ?>"
            data-termID="<?php echo $i->term_id ?>">
            <input type="checkbox" 
              class="selection-input" 
              data-category="<?php echo $i->slug; ?>" 
              data-termID="<?php echo $i->term_id ?>" 
              id="<?php echo $i->name; ?>" 
              name="<?php echo $slug; ?>[]"
              value="<?php echo $i->slug; ?>" 
              <?php if ( isset($params[$slug]) && in_array( $i->slug, $params[$slug] ) ) { echo 'checked'; } ?> /> 
            <span class="checked-box"></span>
            <?php echo $i->name; ?>
          </label> 
          <?php 
          }
        }
      } else {
        ?> 
          <label 
            for="<?php echo $i; ?>" 
            class="selection-label"> 
            <input type="checkbox" 
              class="selection-input" 
              data-category="<?php echo $i; ?>" 
              id="<?php echo $i; ?>" 
              name="<?php echo $slug; ?>[]"
              value="<?php echo $i; ?>" 
              <?php
              if ( !empty($params) ) {
                foreach($params as $param) {
                  if ( in_array( $i, $param )) {
                    echo 'checked';
                  }
                }
              }
              ?> /> 
            <span class="checked-box"></span>
            <?php echo $i; ?> 
          </label> 
        <?php
      } 
    }
  }
} 
