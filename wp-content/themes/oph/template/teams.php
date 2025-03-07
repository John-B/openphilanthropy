<?php
	/**
	 * Template Name: Teams
	 */

        the_post();

        get_header();

        get_template_part( 'part/page', 'header' );

        echo '<div class="content-team" id="team"><div class="wrap">';

        // get the terms, ordered by name
        // https://developer.wordpress.org/reference/functions/get_terms/
        // https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
        $member_name = $_GET['member_name'] ?? "";
        $taxonomy = 'teams';
        $tax_terms = get_terms( $taxonomy, array(
          'hide_empty' => 0,
          'orderby' => 'term_order',
          'order' => 'ASC',
          'child_of' => 0,
        ) );

        // Custom order to sort by team's last name
        function posts_orderby_lastname ($orderby_statement) {
        $orderby_statement = "RIGHT(post_title, LOCATE(' ', CONCAT(REVERSE(post_title), ' ')) - 1) ASC";
        return $orderby_statement;
        }
	$count = 0;
        $length = count($tax_terms);
        foreach($tax_terms as $tax_term) { // loop through the terms to set heading then remove terms with children
	 $count++;
         if (empty($tax_term->parent) ) { 
            $term_header = '<h2 class="term-h2" id="' . $tax_term->slug . '-header">' . $tax_term->name . '</h2>'; //Print name in h2 if it is top level, otherwise in h4
          } else {
            $term_header = '<h3 class="term-h3" id="' . $tax_term->slug . '-header">' . $tax_term->name . '</h3>'; //Print name in h3 if it is second level, otherwise in h4
          }
//          add_filter( 'posts_orderby' , 'posts_orderby_lastname' );
          add_filter( 'order_by' , 'menu_order' );

           $term_posts = new WP_Query( // find posts with the correct term
             array(
              'no_found_rows' => true, // for performance
              'ignore_sticky_posts' => true, // for performance
              'post_type' => 'team',
              'posts_per_page' => -1, // return all results
              'tax_query' => array( // https://developer.wordpress.org/reference/classes/wp_tax_query/
                array(
                  'taxonomy' => $taxonomy,
                  'field'    => 'name',
                  'terms'    => array( $tax_term->name )
               )
           ),
           'meta_query' => array(
             'relation' => 'OR',
               array(
                 'key'     => 'teampage_exclusion',
                 'compare' => 'NOT EXISTS'
               ),
               array(
                 'key'     => 'teampage_exclusion',
                 'value'   => '1',
                 'compare' => '!='
               ),
           ),
           'fields' => 'ids', // return the post IDs only
           )
         );
        // Clean up as to not affect other posts
      //  remove_filter( 'posts_orderby' , 'posts_orderby_lastname' );
      remove_filter( 'order_by' , 'menu_order' );
           // Now get leadership posts again in an order defined b ACF leadershp_order field.
           $term_posts_leadership = new WP_Query( // find posts with the correct term
             array(
              'no_found_rows' => true, // for performance
              'ignore_sticky_posts' => true, // for performance
              'post_type' => 'team',
              'posts_per_page' => -1, // return all results
    	      'orderby' => 'meta_value_num',
  	      'meta_key' => 'leadership_order',
   	      'order' => 'ASC',
              'tax_query' => array(
                array(
                  'taxonomy' => $taxonomy,
                  'field'    => 'name',
                  'terms'    => array( "leadership" )
               )
           ),
           'meta_query' => array(
             'relation' => 'OR',
               array(
                 'key'     => 'teampage_exclusion',
                 'compare' => 'NOT EXISTS'
               ),
               array(
                 'key'     => 'teampage_exclusion',
                 'value'   => '1',
                 'compare' => '!='
               ),
           ),
           'fields' => 'ids', // return the post IDs only
           )
         );
  ?>
	<?php if ( $tax_term->slug === "leadership" ) : ?>
                <div class="content-team__main collapsed-grid" id="leadership">
                                <!-- The following allow class "team-flex" to center incomplete rows, or "team-grid" for a grid layout with 4 columns in desktop.-->
			<?php echo $term_header; ?>
                                <div class="team-grid leadership" id="<?php echo $tax_term->slug; ?>-grid">
                                        <?php while ( $term_posts_leadership->have_posts() ) : $term_posts_leadership->the_post(); ?>
                                                <?php
						   $terms = [];
						   $terms = get_the_terms(get_the_ID(), 'teams');
						   for ($i = 0; $i < count($terms); $i++) { $term = $terms[$i];
                                                     if($tax_term->term_id === $term->term_id) { // Without this we end up printing posts or the term AND its parent term.
                                                        $team_title = get_field( 'short_team_title' ) ?: get_field( 'team_title' );
                                                        $team_content = get_the_content();
                                                        $team_image = get_the_post_thumbnail();
                                                        // Uncomment to skip lazy loading.
                                                        // $team_image = str_replace('lazy', 'skip-lazy', get_the_post_thumbnail());
                                                ?>
                                                	<article class="team-item">
                                                                <div class="team-item-header">
                                                                <a href="<?php echo get_permalink(); ?>">
								<?php if ( isset($team_image) ) : ?>
                                                                        <?php echo $team_image; ?>
                                                                <?php endif; ?>
                                                                <h4><?php echo the_title(); ?></h4>
                                                                <?php if ( isset($team_title) ) : ?>
                                                                <h6><?php echo $team_title; ?></h6>
                                                                <?php endif; ?>
								</a>
                                                                </div>
                                                                <?php if ( isset($team_content) ) : ?>
                                                                        <details class="leadership-details"><summary> </summary>
                                                                <?php endif; ?>
                                                                <p><?php echo $team_content; ?></p></details>
                                               		</article>
					     <?php } 
                                       		 } endwhile; ?>
                                </div>
		</div>

	<?php endif; ?>
	<?php if ( $tax_term->slug !== "leadership" && empty($member_name) ) : ?>
               	<?php if ($count === 2) { echo '<div class="content-team__main collapsed-grid" id="staff">'; } ?>
			<?php if(empty($tax_term->parent)) { echo '<div class="divider"></div>'; } if($tax_term->count > 0) { echo $term_header; } ?>
                                <div class="team-grid staff" id="<?php echo $tax_term->slug; ?>">
                                        <?php  while ( $term_posts->have_posts() ) : $term_posts->the_post(); ?>
                                                 <?php
						   $terms = get_the_terms(get_the_ID(), 'teams');
						   for ($i = 0; $i < count($terms); $i++) { $term = $terms[$i];
                                                     if($tax_term->term_id === $term->term_id) { // Without this we end up printing posts or the term AND its parent term.
                                                        $team_title = get_field( 'short_team_title' ) ?: get_field( 'team_title' );
                                                        $team_content = get_the_content();
                                                        $team_image = get_the_post_thumbnail();
                                                        // Uncomment to skip lazy loading.
                                                        // $team_image = str_replace('lazy', 'skip-lazy', get_the_post_thumbnail());
                                                ?>
                                                	<article class="team-item staff">
                                                                <a href="<?php echo get_permalink(); ?>"><h4>
									<span class="name"><?php echo the_title(); ?></span>
								</h4></a>
                                                                <?php if ( isset($team_title) ) : ?>
                                                                <h6><?php echo $team_title; ?></h6>
                                                                <?php endif; ?>
                        	                        </article>
					    <?php }
						} endwhile; wp_reset_postdata();  ?>
                                </div>
               <?php if($count === $length) { echo '</div>'; } ?>
	<?php  endif; ?>
 
<?php  } ?>
		
		<aside id="midriff"><h2 class="section-heading">Staff Directory</h2>
			<div class="form-wrapper"><form class="team-search-form" action="" method="">
  				<input class="search-field" id="teams-search" type="search" name="" placeholder="Search names" value="">
			</form><button onclick="searchText()" style="height: 40px;">Search</button><button onclick="clearText()" style="height: 40px;">Reset</button>
    <script>
//	window.addEventListener("hashchange", function(e){ 
//	  document.body.querySelectorAll('details')
//	  .forEach((e) => {e.removeAttribute('open');
//	  });
//	});
        const tocTablet = 768;
        const tocDesktop = 1024;
        const bodyHeight = document.body.scrollHeight;
        let widthToc = window.innerWidth;
        function searchText() {
            // Get the search term from the input field
            const searchField = document.getElementById('teams-search');
            const links = document.querySelectorAll('a.toc-sublink');
            const searchTerm = searchField.value.toLowerCase();
            const parents = document.querySelectorAll(".team-grid.staff");
            const details = document.querySelectorAll("#toc details");

            // Get all elements with the class 'team-grid'
            const teamGridElements = document.querySelectorAll('.team-item.staff');
	    // Set flag so we can detect if there are no results
	    let flag = false;
            // Loop through each element and check if the search term is present
            teamGridElements.forEach(element => {
                // Get the text content of the element
                const textContent = element.textContent.toLowerCase();
                // Check if the search term is present in the text content
                if (searchTerm === '' || textContent.includes(searchTerm)) {
                    // If the search term is present or search term is empty, show the element
                    element.style.display = 'block';
		    flag = true;
                } else {
                    // If the search term is not present, hide the element
                    element.style.display = 'none';
                }
            });
	    // Change input border and add text if there are no results
	    var noResultsMessage = '<div id="no-result">No results found, please try a new search.</div>';
	    var noResultsHtml = document.getElementById("no-result");
	    if (flag === false) {
              searchField.style.border = "2px solid crimson";
	      if(noResultsHtml != null) {
	        noResultsHtml.remove();
	      }
              searchField.insertAdjacentHTML("afterend",noResultsMessage);
	    } else  {
              searchField.style.border = "2px solid #445277";
	      if(noResultsHtml != null) {
	        noResultsHtml.remove();
	      }
	    } 	
            parents.forEach(parent => {
                if (parent.querySelectorAll(".team-item.staff").length == parent.querySelectorAll(".team-item.staff[style='display: none;']").length) {
                  parent.style.display = "none";
                  if(parent.previousElementSibling.classList.contains("term-h3")) {
                    parent.previousElementSibling.style.display = "none";
                  } 
                } else {
                  parent.style.display = "grid";
                  if(parent.previousElementSibling.classList.contains("term-h3")) {
                    parent.previousElementSibling.style.display = "block";
                  }
                }

            });
            details.forEach(detail => {
	      detail.addEventListener("click", function(e) {
		this.open=false;
	      });
            });

          var visibleElement = document.querySelector('.team-item.staff[style="display: block;"]');
          if(visibleElement) {
            var headerOffset = 150;
            var elementPosition = visibleElement.getBoundingClientRect().top;
            var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            window.scrollTo({top: offsetPosition, behavior:'smooth'});
          }
        }
        const node = document.getElementById("teams-search");
        node.addEventListener("keydown", function(e) {
          if (e.code === "Enter") {
            e.preventDefault();
            e.stopPropagation();
            searchText();
          }
        });
        function clearText() {
            // Get all elements with the class 'team-grid'
            const teamGridElements = document.querySelectorAll('.team-item.staff');
            const teamGridSubheaders = document.querySelectorAll('.term-h3');
            // Get the search term from the input field
            const searchField = document.getElementById('teams-search');
	    searchField.value = '';
            searchField.style.border = "2px solid #445277";
	    var noResultsHtml = document.getElementById("no-result");
	    if(typeof noResultsHtml !== null) {
	      noResultsHtml.remove();
	    }
            // Loop through each element and unhide them.
            teamGridElements.forEach(element => {
              element.parentElement.style.display = 'grid';
              element.style.display = 'block';
            });
            teamGridSubheaders.forEach(element => {
              element.style.display = 'block';
            });
        }

    </script>
			</div>
		</aside>
	
	<aside id="toc"><h3>Table of contents</h3>
					<?php 
        $taxonomy = 'teams';
        $tax_terms = get_terms( $taxonomy, array(
          'hide_empty' => 0,
          'orderby' => 'term_order',
          'order' => 'ASC',
          'child_of' => 0,
        ) );
        foreach($tax_terms as $tax_term) { // loop through the terms to set heading then remove terms with children
	  $count++;
	  $term_id = 0;
	  $term_parent = 0;
          if (empty($tax_term->parent) ) {
	    echo '<details  name="toc-section">';
	    $term_id = $tax_term->term_id;
            $child_count = count(get_term_children($term_id, $taxonomy));
	    if ($child_count > 0) {
              $term_link = '<summary class="team-toc-main"><a href="#' . $tax_term->slug . '-header" class="toc-link"><h4>' . $tax_term->name . '</h4></a>
<div class="teams-navigation-icon"><svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"/></svg></div>
<span class="team-toc-open trigger" style="display: none;">+</span><span class="team-toc-close trigger" style="display: none;">&ndash;</span></summary>'; //Print name in h2 if it is top level, otherwise in h4
	    } else  {
              $term_link = '<summary class="team-toc-main"><a href="#' . $tax_term->slug . '-header" class="toc-link"><h4>' . $tax_term->name . '</h4></a></summary>'; //Print name in h2 if it is top level, otherwise in h4
	    }
	    echo $term_link;          
	    foreach ($tax_terms as $tax_term) {
	       if($tax_term->parent === $term_id) {
     		 $term_link = '<a href="#' . $tax_term->slug . '-header" class="toc-sublink"><h5>' . $tax_term->name . '</h5></a>'; //Print name in h3 if it is second level, otherwise in h4	
		 echo $term_link;
	       }
            }
	    echo '</details>';
	  }
       	  if ($tax_term->count > 0) {
	  // echo $term_link;
	  }
        } ?>
               	</aside>

<?php
   the_content(); 
   echo '</div></div>';

   get_template_part( 'part/cta-button' );

   get_footer();

?>
