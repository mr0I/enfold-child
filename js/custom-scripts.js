(function ($) {
    $(window).on("load", function () {
        /* Notif Banner */
        if (!localStorage.getItem('notif_banner_closed')) {
            setTimeout(function () {
                $('.notif_banner_container').animate({ bottom: 0 }, 'slow');
            }, 3000);
        }
        $('.notif_close').click(function () {
            $('.notif_banner_container').delay(300).animate({ bottom: '-150px' }, 'fast').delay(3000).fadeOut().end();
            localStorage.setItem('notif_banner_closed', true);
        });
        /* Notif Banner */

        // start goftino
        // if (SpaAjax.isEN !== 'en'){
        //     !function(){var a=window,d=document;function g(){var g=d.createElement("script"),i="lXpDBP",s="https://www.goftino.com/widget/"+i,l=localStorage.getItem("goftino_"+i);g.type="text/javascript",g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
        // }
    })
})(jQuery);
jQuery(document).ready(function ($) {

    // inits
    const toolTips = $('[data-toggle="tooltip"]');
    toolTips.tooltip({
        delay: { "show": 200, "hide": 100 },
        trigger: "hover"
    });
    toolTips.click(function () {
        $('[data-toggle="tooltip"]').tooltip("hide");
    });
    // inits

    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');

    // hide pr1 and x0+ price lables
    $('#product-10428').find('.woo-price').css('display', 'inline-block').html('<strong class="text-danger">ناموجود</strong>');
    $('#product-10216').find('.woo-price').css('display', 'inline-block').html('<strong class="text-danger">ناموجود</strong>');
    /* End Change Shop buttons text temporary */

    // fadeout UAP REG SUCCESS MSG
    const uap_reg_success_msg = $('.uap-reg-success-msg');
    setTimeout(function () {
        if (uap_reg_success_msg.length == '1') {
            uap_reg_success_msg.fadeOut();
        }
    }, 3000);

    $('#uap_createuser').find('.optional').siblings('label.uap-labels-register').addClass('optional-label');


    /* Changes For Multi Language */
    // Change breadcrumb trails
    // const breadcrumbTrail = $('.breadcrumb-trail');
    // if (SpaAjax.isEN === 'en') {
    //     $('.breadcrumb').find('.trail-begin').find('span[itemprop="name"]').text('Home');
    //     breadcrumbTrail.find('span.sep').html('<i class="ic-line-right"></i>');
    // } else {
    //     $('.breadcrumb').find('.trail-begin').find('span[itemprop="name"]').text('صفحه اصلی');
    //     breadcrumbTrail.find('span.sep').html('<i class="ic-line-left"></i>');
    // }

    /* load more posts */
    const dateOptions = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };

    $('.load_more_posts').on('click', function () {
        const offsetCounter = document.getElementById('offset_counter');
        let offset = offsetCounter.value;
        const limit = constants.limit_counter;
        const total = constants.total_counter;
        const categoryId = constants.category_id || 0;
        let load_more_posts_btn = $(this);
        $(load_more_posts_btn).html('بارگیری بیشتر<i class="ic-spinner1 icon-spinner mx-1"></i>').attr('disabled', true);

        fetch(RadAjax.ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded'
            }),
            body: new URLSearchParams({
                action: 'getPosts',
                security: RadAjax.security,
                offset: offset,
                limit: limit,
                category_id: categoryId,
            })
        }).then(async response => {
            const res = await response.json();
            const posts = res.posts;
            const posts_container = $('.posts-container');

            $(load_more_posts_btn).html('بارگیری بیشتر').attr('disabled', false);
            posts.forEach(post => {
                posts_container.append(`
                    <div class="card">
                        <div class="col-lg-6 col-md-6 col-sm-12 card-img-top">
                            <a href="${post.url}"> <figure>${post.image}</figure> </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 card-body">
                            <a href="${post.url}"><h2 class="card-title">${post.title}</h2></a>
                            <p class="card-attrs w-100">
                                <small class="text-muted">
                                    <a href="${post.url}/#respond">
                                    ${post.commentsCount}<i class="ic-bubble mx-1"></i>
                                        دیدگاه
                                    </a>
                                </small>
                            </p>
                            <p class="card-text">${(post.excerpt).substring(0, 300) + '---'}</p>
                        </div>
                    </div>
                    `);
            });

            offsetCounter.value = Number(offset) + Number(limit);
            if ((Number(total) - Number(offset)) <= Number(limit)) $(load_more_posts_btn).fadeOut();
        }).catch(function (error) {
            console.warn(JSON.stringify(error));
        });
    });
    /* END load more posts */


    // Add material icons
    $('.single_add_to_cart_button').html('<i class="ic-basket font-weight-bold" style="font-size: 150%"></i>  افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-basket font-weight-bold my-2"></i>');

});




