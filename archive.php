<?php
if (!defined('ABSPATH')) {
    die();
}

global $avia_config, $more;

/*
 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
 */
get_header();


$showheader = true;
if (avia_get_option('frontpage') && $blogpage_id = avia_get_option('blogpage')) {
    if (get_post_meta($blogpage_id, 'header', true) == 'no') $showheader = false;
}

if ($showheader) {
    echo avia_title(array('title' => avia_which_archive()));
}

do_action('ava_after_main_title');


/**
 * blog template
 */
$category = get_queried_object();
$postsCount = intval($category->count);
$categoryId = intval($category->cat_ID);
// wp_die(json_encode($category, JSON_PRETTY_PRINT));
$limit = get_option('RADtools_setting_articles_perpage', 1);
$args = array(
    'posts_per_page' => $limit,
    'offset' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'cat' => $categoryId,
);
$results = new WP_Query($args);
$posts = $results->posts;

// global $wpdb;
// $postsTable = $wpdb->prefix . 'posts';
// $postsCount = $wpdb->get_var(
//     $wpdb->prepare(
//         "SELECT COUNT(*) FROM ${postsTable} WHERE post_status=%s AND post_type=%s",
//         array('publish', 'post')
//     )
// );
?>

<div class='container_wrap container_wrap_first main_color <?php avia_layout_class('main'); ?>'>
    <div class='container template-blog '>
        <main class='content <?php avia_layout_class('content'); ?> units' <?php avia_markup_helper(array('context' => 'content', 'post_type' => 'post')); ?>>
            <div class="posts-container">
                <?php
                $offset = 0;
                foreach ($posts as $post) {
                    $postImage = (get_the_post_thumbnail($post->ID) !== '')
                        ? get_the_post_thumbnail($post->ID, 'full')
                        : '<img src="' . RAD_ASSETS . 'images/Image_not_available.jpg" alt="تصویر جایگزین مقالات بدون تصویر شاخص سایت رادشید">';
                    $postUrl = get_permalink($post->ID);
                    $postTitle = $post->post_title;
                    $postExcerpt = $post->post_excerpt;
                    $postCommentCount = $post->comment_count;
                    $postDate = $post->post_date;
                ?>
                    <div class="card">
                        <div class="col-lg-6 col-md-6 col-sm-12 card-img-top">
                            <a href="<?= $postUrl ?>">
                                <figure><?= $postImage ?></figure>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 card-body">
                            <a href="<?= $postUrl ?>">
                                <h2 class="card-title"><?= $postTitle ?></h2>
                            </a>
                            <p class="card-attrs w-100">
                                <small class="text-muted">
                                    <a href="<?= $postUrl . '/#respond' ?>">
                                        <?= $postCommentCount ?>
                                        <i class="ic-bubble mx-1"></i>
                                        دیدگاه
                                    </a>
                                </small>
                            </p>
                            <p class="card-text">
                                <?= mb_strimwidth($postExcerpt, 0, 300, '---') ?>
                            </p>
                        </div>
                    </div>
                <?php
                    $offset++;
                }
                ?>
            </div>
            <div class="text-center">
                <?php
                if ($postsCount > $limit) {
                ?>
                    <button class="btn load_more_posts" data-offset="<?= $offset ?>" data-limit="<?= $limit ?>">
                        بارگیری بیشتر
                    </button>
                <?php
                }
                ?>
            </div>
        </main>
        <?php
        $data = ([
            'limit_counter' => $limit,
            'total_counter' => $postsCount,
            'site_url' => get_site_url(),
            // 'category_id' => 1
            'category_id' => $categoryId
        ])
        ?>
        <input type="hidden" id="offset_counter" value="<?= $offset ?>">
        <script type="text/javascript">
            let constants = <?= json_encode($data); ?>;
        </script>
    </div>
</div>

<?php
get_footer();
