<?php
/*
 * Add help text where drag and drop is available.
 */
function reorder_instructions_team() {
    global $my_admin_page;
    global $post;
    $screen = get_current_screen();
    $slug = $post->post_name;

    if ( is_admin() && ($slug == 'team') ) {
        function add_teams_help_text() {
            echo '<div class="postbox" style="background:#0074a2;color:#fff;margin-top:40px; width:97%;"><div class="inside">';
            echo 'For guidance on setting up this auto-generated team page, see <a href="/wp-admin/edit.php?post_type=team" target="_blank" style="color: lightgreen;">the team member listing form</a>.';
            echo '</div></div>';
        }
        add_action( 'all_admin_notices', 'add_teams_help_text' );
    }
    if ( is_admin() && ($screen->id == 'edit-teams') && ($screen->taxonomy == 'teams') ) {
        function add_teams_help_text() {
            echo '<div class="postbox" style="background:#0074a2;color:#fff;margin-top:40px; width:97%;"><div class="inside">';
            echo 'The "Order" field is not used. Order teams using drag & drop, and perform a save to ensure correct hierarchy <a href="/wp-admin/admin.php?page=customtaxorder-teams" target="_blank" style="color: lightgreen;">here</a>.';
            echo '</div></div>';
        }
        add_action( 'all_admin_notices', 'add_teams_help_text' );
    }
    if ( is_admin() && $screen->id == 'edit-team' ) {
        function add_teams_help_text() {
            echo '<div class="postbox" style="background:#0074a2;color:#fff;margin-top:40px;width: 97%;"><div class="inside">';
	    echo '<h3>Guidance on team page setup</h3>';
            echo '<span style="font-size: larger;">1. Set up teams and sub-teams <a href="/wp-admin/edit-tags.php?taxonomy=teams&post_type=team" target="_blank" style="color: white;">here</a>.</span><br>';
            echo '<span style="font-size: larger;">2. Set order of teams and sub-teams <a href="/wp-admin/admin.php?page=customtaxorder-teams" target="_blank" style="color: white;">here</a> using drag & drop, then "Update Order", and "Save".</span><br>';
            echo '<span style="font-size: larger;">3. When editing or adding a team member listed on this page check at least one box under "Team Membership".<br></span>';
	    echo '<span>(If "team page exclusion" is checked, adding that person to a team is not required.)</span><br>';
            echo '<span style="font-size: larger;">4. To re-order team members within a team, filter this page down to that team using the "All Teams" dropdown below and click "Filter", then drag & drop members into the desired order.<span>';
	    echo '</div></div>';
        }
        add_action( 'all_admin_notices', 'add_teams_help_text' );
    }
}
add_action( 'admin_notices', 'reorder_instructions_team' );
