<?php defined('ABSPATH') or die('No script kiddies please!');

$limit = get_option('RADtools_setting_articles_perpage', 1);
$args = array(
    'posts_per_page' => $limit,
    'offset' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish'
);

$results = new WP_Query($args);
$posts = $results->posts;

global $wpdb;
$postsTable = $wpdb->prefix . 'posts';
$postsCount = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT COUNT(*) FROM ${postsTable} WHERE post_status=%s AND post_type=%s",
        array('publish', 'post')
    )
);

// Shamsi Date
include_once RAD_INCS . '/libs/jdatetime.class.php';
$date = new jDateTime(true, true, 'Asia/Tehran');
?>

<div>
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
                    <p class="card-text"><?= mb_strimwidth($postExcerpt, 0, 300, '---') ?></p>
                </div>
                <div class="card-date d-none"><span><?= $date->date("j F Y", strtotime($postDate)) ?></span></div>
            </div>
        <?php
            $offset++;
        }
        ?>
    </div>
    <div class="text-center">
        <?php if ($postsCount > $limit) : ?>
            <button class="btn load_more_posts" data-offset="<?= $offset ?>" data-limit="<?= $limit ?>">
                بارگیری بیشتر
            </button>
        <?php endif; ?>
    </div>
    <?php
    $data = ([
        'limit_counter' => $limit,
        'total_counter' => $postsCount
    ])
    ?>
    <input type="hidden" id="offset_counter" value="<?= $offset ?>">
    <script type="text/javascript">
        let constants = <?= json_encode($data); ?>;
    </script>
</div>