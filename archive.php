<?php
if ( !defined('ABSPATH') ){ die(); }

global $avia_config, $more;

/*
 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
 */
get_header();


$showheader = true;
if(avia_get_option('frontpage') && $blogpage_id = avia_get_option('blogpage'))
{
	if(get_post_meta($blogpage_id, 'header', true) == 'no') $showheader = false;
}

if($showheader)
{
	echo avia_title(array('title' => avia_which_archive()));
}

do_action( 'ava_after_main_title' );
?>


<?php
global $wpdb;
$posts_table = $wpdb->prefix . 'posts';
$postmeta_table = $wpdb->prefix . 'postmeta';
$users_table = $wpdb->prefix . 'users';
$term_relationships_table = $wpdb->prefix . 'term_relationships';
$term_taxonomy_table = $wpdb->prefix . 'term_taxonomy';
$terms_table = $wpdb->prefix . 'terms';

$pagenum = 1;
$limit = get_option('RADtools_setting_articles_perpage'); // number of rows in page
$offset = 0;
$category = get_queried_object();


$posts = $wpdb->get_results("SELECT p.ID,p.post_title AS title,p.post_excerpt AS excerpt, p.post_date AS date , p.post_name AS slug , pm2.meta_value AS image
                                    ,p.comment_count , u.display_name AS author , tax.term_id AS cat_id
                                FROM $posts_table p 
                                INNER JOIN $postmeta_table pm ON (p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id' AND p.post_status='publish' AND p.post_type='post')
                                INNER JOIN $postmeta_table pm2 ON (pm.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file') 
                                INNER JOIN $users_table u ON (p.post_author = u.ID)
                                LEFT JOIN $term_relationships_table rel ON rel.object_id = p.ID
                                LEFT JOIN $term_taxonomy_table tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
                                LEFT JOIN $terms_table t ON t.term_id = tax.term_id
                                WHERE tax.term_id=$category->term_id
                                ORDER BY post_date DESC LIMIT $offset,$limit ");

$total_query = $wpdb->get_results( "SELECT p.ID,p.post_title AS title,p.post_excerpt AS excerpt, p.post_date AS date , p.post_name AS slug , pm2.meta_value AS image
                                    ,p.comment_count , u.display_name AS author , tax.term_id AS cat_id FROM $posts_table p 
                                INNER JOIN $postmeta_table pm ON (p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id' AND p.post_status='publish' AND p.post_type='post')
                                INNER JOIN $postmeta_table pm2 ON (pm.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file') 
                                INNER JOIN $users_table u ON (p.post_author = u.ID)
                                LEFT JOIN $term_relationships_table rel ON rel.object_id = p.ID
                                LEFT JOIN $term_taxonomy_table tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
                                LEFT JOIN $terms_table t ON t.term_id = tax.term_id
                                WHERE tax.term_id=$category->term_id" );


$total = sizeof($total_query);
$num_of_pages = ceil( $total / $limit );

// Shamsi Date
include_once RAD_INCS . '/libs/jdatetime.class.php';
$date = new jDateTime(true, true, 'Asia/Tehran');
?>

    <div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>
        <div class='container template-blog '>
            <main class='content <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content','post_type'=>'post'));?>>
                <div class="posts-container">
					<?php
					$offset = 0;
					foreach ($posts as $post){
						?>
                        <div class="card">
                            <div class="col-lg-6 col-md-6 col-sm-12 card-img-top">
                                <a href="<?= get_site_url().'/'. $post->slug ?>">
                                    <figure><img src="<?= get_site_url() . '/wp-content/uploads/' . $post->image ?>" alt="تصویر شاخص"></figure>
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 card-body">
                                <a href="<?= get_site_url().'/'. $post->slug ?>"><h5 class="card-title"><?= $post->title ?></h5></a>
                                <p class="card-attrs w-100">
                                    <small class="text-muted"><a href="<?= get_site_url().'/'. $post->slug . '/#respond' ?>"><?= $post->comment_count ?><i class="ic-bubble mx-1"></i>&nbsp;دیدگاه</a></small>
                                </p>
                                <p class="card-text"><?= mb_strimwidth($post->excerpt,0,300,'---') ?></p>
                            </div>
                            <div class="card-date"><span><?= $date->date("j F Y" , strtotime($post->date)) ?></span></div>
                        </div>
						<?php
						$offset++;
					}
					?>
                </div>
                <div class="text-center">
                    <button class="btn load_more_posts" data-offset="<?= $offset ?>" data-limit="<?= $limit ?>">
                        بارگیری بیشتر
                    </button>
                </div>
            </main>
			<?php
			$data = ([
				'limit_counter' => $limit,
				'total_counter' => $total,
				'site_url' => get_site_url(),
				'category_id' => $category->term_id
			])
			?>
            <input type="hidden" id="offset_counter" value="<?= $offset ?>">
            <script type="text/javascript"> let constants = <?= json_encode($data); ?>;</script>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($){

            const date_options = { year: 'numeric', month: 'long', day: 'numeric' };
            $('.load_more_posts').on('click' , async function () {
                const offsetCounter = $('#offset_counter');
                let offset = offsetCounter.val();
                const siteUrl = constants.site_url;
                let limit = constants.limit_counter;
                let total = constants.total_counter;
                let category_id = constants.category_id;

                let load_more_posts_btn = $(this);
                load_more_posts_btn.html('بارگیری بیشتر<i class="ic-spinner1 icon-spinner mx-1"></i>');
                await fetch(SpaAjax.ajaxurl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
                    body: new URLSearchParams({
                        action: 'getCatPosts',
                        security : SpaAjax.security,
                        offset: offset,
                        limit: limit,
                        category_id: category_id
                    })
                }).then((resp) => resp.json())
                    .then(function(res) {
                        const posts = res.posts;
                        const posts_container = $('.posts-container');
                        posts.forEach(post => {
                            posts_container.append(`
                        <div class="card">
                            <div class="col-lg-6 col-md-6 col-sm-12 card-img-top">
                                 <a href="${siteUrl + '/' + post.slug}"><figure><img src="${siteUrl}/wp-content/uploads/${post.image}" alt="تصویر شاخص"></figure></a>
                            </div>
							<div class="col-lg-6 col-md-6 col-sm-12 card-body">
							    <a href="${siteUrl + '/' + post.slug}"><h5 class="card-title">${post.title}</h5></a>
								<p class="card-attrs w-100">
                                    <small class="text-muted"><a href="${siteUrl + '/' + post.slug + '#respond'}">${post.comment_count}<i class="ic-bubble mx-1"></i>&nbsp;دیدگاه</a></small>
                                </p>
								<p class="card-text">${(post.excerpt).substring(0,300) + '---'}</p>
							</div>
                             <div class="card-date"><span>${ new Date(post.date).toLocaleDateString('fa-IR' , date_options) } </span></div>
						</div>
                        `);
                        });
                        offsetCounter.val(Number(offset) + Number(limit));
                        if ( (Number(total) - Number(offset)) <=  Number(limit)) {
                            load_more_posts_btn.fadeOut();
                        }
                        load_more_posts_btn.html('بارگیری بیشتر');
                    })
                    .catch(function(error) {
                        console.log(JSON.stringify(error));
                    });
            });
        });
    </script>


<?php
get_footer();
