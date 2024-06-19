<?php
/*
 * Add help text where drag and drop is available.
 */
function reorder_instructions_team() {
    global $my_admin_page;
    $screen = get_current_screen();

    if ( is_admin() && ($screen->id == 'edit-teams') && ($screen->taxonomy == 'teams') ) {
        function add_teams_help_text() {
            echo '<div class="postbox" style="background:#0074a2;color:#fff;margin-top:40px; width:97%;"><div class="inside">';
            echo 'You can reorder teams <a href="/wp-admin/admin.php?page=customtaxorder-teams" target="_blank" style="color: lightgreen;">here</a>.';
            echo '</div></div>';
        }
        add_action( 'all_admin_notices', 'add_teams_help_text' );
    }
    if ( is_admin() && $screen->id == 'edit-team' ) {
        function add_teams_help_text() {
            echo '<div class="postbox" style="background:#0074a2;color:#fff;margin-top:40px;width: 97%;"><div class="inside">';
            echo 'Members of each team are displayed in alphabetical order of last name.';
            echo '</div></div>';
        }
        add_action( 'all_admin_notices', 'add_teams_help_text' );
    }
}
add_action( 'admin_notices', 'reorder_instructions_team' );
