<?php
$related = $related;
$related_link = get_permalink($related->ID);
$related_title = $related->post_title;

if (has_excerpt($related->ID)) {
    $related_excerpt_source = get_the_excerpt($related->ID);
} else {
    $related_excerpt_source = get_post_field('post_content', $related->ID);
}

$related_excerpt = array(
    'append' => '...',
    'limit' => 28,
    'limitby' => 'word',
    'source' => $related_excerpt_source
);

$related_description = excerpt($related_excerpt);

$grant_focus_area = get_the_terms($related->ID, 'focus-area')[0];
$related_eyebrow_copy = '';
$related_eyebrow_link_url = '';

if ($grant_focus_area && $grant_focus_area->name) {
    $related_eyebrow_copy = $grant_focus_area->name;
}

if ($grant_focus_area && $grant_focus_area->slug) {
    $related_eyebrow_link_url = 'grants/?focus-area=' . $grant_focus_area->slug;
}

$title = get_field('custom_title', $related->ID) ? get_field('custom_title', $related->ID) : $related_title;
$description = get_field('custom_description', $related->ID) ? get_field('custom_description', $related->ID) : '<p>' . $related_description . '</p>';
$link = get_field('custom_link', $related->ID) ? get_field('custom_link', $related->ID) : $related_link;
$eyebrow_copy = get_field('custom_title', $related->ID) ? get_field('custom_eyebrow_copy', $related->ID) : $related_eyebrow_copy;
$eyebrow_link = get_field('custom_eyebrow_link', $related->ID) ? get_field('custom_eyebrow_link', $related->ID) : $related_eyebrow_link_url;
?>

<li>
    <h5>
        <a href="/<?php echo $eyebrow_link; ?>"><?php echo $eyebrow_copy; ?></a>
    </h5>

    <h4>
        <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
    </h4>

    <div class="single-related-posts__description">
        <p><?php echo $description; ?></p>
    </div>

    <div class="single-related-posts__link">
        <a href="<?php echo $link; ?>">
            Read more <svg viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.352 1l7.395 7.5-7.395 7.5M1 8.397l21.748.103" stroke="#6e7ca0" stroke-width="2" />
            </svg>
        </a>
    </div>
</li>
