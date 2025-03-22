<?php

/**
 * Template Name: Table of Contents (New)
 */

the_post();

get_header();

$content_sections = get_field('content_sections');
$footnotes = get_field('footnotes');
?>

<?php get_template_part('part/page', 'header'); ?>

<div class="content-table-of-contents">
    <div class="content-single" id="research-post">
        <div class="wrap">
            <div class="content-single__container">
                <div class="content-single__aside pagenav-aside">
                    <h3>Table of Contents</h3>

                    <nav aria-label="Post Navigation" class="aside-post-navigation" id="nav-post">
                        <ul class="list-aside-post-navigation" id="post-navigation-list"></ul>
                    </nav>

                    <nav aria-label="Mobile Post Navigation" class="aside-post-navigation-mobile" id="nav-post-mobile">
                        <select class="goto-select" id="post-navigation-list-mobile"></select>
                    </nav>

                    <svg aria-hidden="true" class="aside-post-navigation-icon" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2" />
                    </svg>

                    <?php if (get_field("social_share") == 'show' || !get_field("social_share")) : ?>
                        <div class="post-share">
                            <div class="a2a_wrapper">
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style social-media">
                                    <a class="a2a_button_x">
                                        <svg xmlns="http://www.w3.org/2000/svg"; viewBox="0 0 512 512">
                                           <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                                        </svg>
                                    </a>

                                    <a class="a2a_button_facebook">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                            <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                                        </svg>
                                    </a>

                                    <a class="a2a_button_linkedin">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                                        </svg>
                                    </a>

                                    <a class="a2a_button_print">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z" />
                                        </svg>
                                    </a>
                                </div>

                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="content-single__main pagenav-content">
                    <?php if ($post_thumbnail) : ?>
                        <img class="post-thumbnail" src="<?php echo $post_thumbnail; ?>" alt="">
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <?php if ($footnotes) : ?>
                        <div class="entry-footnotes">
                            <a href='javascript:void(0);' id='toggle-footnotes'>
                                <span class='expand'>
                                    Expand Footnotes
                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.1123 9.71249L12.4996 15.2875L6.8877 9.71249" stroke="#445277" stroke-width="1.49661" />
                                    </svg>
                                </span>
                                <span class='collapse'>
                                    Collapse Footnotes <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.8877 15.2875L12.5004 9.71248L18.1123 15.2875" stroke="#445277" stroke-width="1.49661" />
                                    </svg>
                                </span>
                            </a>
                            <div class="footnotes">
                                <?php echo $footnotes; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$call_to_action_button = get_field('call_to_action_button');
?>

<?php if ($call_to_action_button) : ?>
    <div class="cta-button" id="button">
        <div class="wrap">
            <div class="cta-button__content">
                <div class="button-group">
                    <?php foreach ($call_to_action_button as $button) : ?>
                        <a class="button" href="<?php if(isset($button['link']['url'])) echo $button['link']['url']; ?>"><?php if(isset($button['link']['title'])) echo $button['link']['title']; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>
