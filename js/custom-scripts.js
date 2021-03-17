/* Version 1.0.8 */
jQuery(document).ready(function ($) {

    // Inits
    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 300, "hide": 100}
    });
    // Inits

    setInterval(function() {
        $('.dial-btn').find('i').addClass('is-animating');
        setTimeout(function() {
            $('.dial-btn').find('i').removeClass('is-animating');
        }, 2000);
    }, 12000);


    // Add Material icons
    $('.single_add_to_cart_button').html('<i class="ic-basket my-2"></i>  افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-cart my-2"></i>');


    // Change breadcrumb trails
    $('.breadcrumb-trail').find('span.sep').html('<i class="ic-chevron-left"></i>');
    $('.trail-begin').find('span[itemprop="name"]').html('<span itemprop="name">صفحه اصلی</span>');


    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');

    // Crisp Avatar
    let check_crisp = setInterval(function () {
        const crispElm =  document.getElementById('crisp-chatbox');
        if (typeof(crispElm) != 'undefined' && crispElm != null)
        {
            $('.cc-1iv2').find('.cc-15mo').remove();
            $('.cc-7doi.cc-1ada').append('<img src="https://radshid.com/wp-content/uploads/2021/03/support_avatar2.jpg" width="70" height="70" alt="">');
            clearInterval(check_crisp);
        }
    } , 300);


    // Change Sipaad phone number
    $('#product-14049').find('.woo-price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');
    $('.template-shop').find('.post-14049').find('.price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');


    // Change Shop buttons text temporary
    $('.template-shop').find('.inner_product').find('.product_type_simple').html('ادامه');
    $('.template-shop').find('.inner_product').find('.add_to_cart_button').html('<i class="ic-shopping-cart"></i>افزودن به سبد خرید');
    $('.template-shop').find('.inner_product').find('.show_details_button').html('<i class="ic-list"></i>نمایش جزئیات');
    $('.wpsp-cart-button').find('a.add_to_cart_button').html(' <i class="ic-chevron-left" style="vertical-align: middle;"></i> خرید');




    // Invoice Print
    $('#print_invoice').on('click' , function () {
        const orderId = $('.woocommerce-order-overview__order').find('strong').html();
        console.log(orderId);
        const orderTableData = $('.woocommerce-table.woocommerce-table--order-details.shop_table.order_details').html();
        $('#order_specs').html(orderTableData);
        const elm = document.getElementById('invoice_container');
        const elm_content = elm.innerHTML;
        const elm_styles= `
html {
  line-height: 1;
}

ol, ul {
  list-style: none;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
}

caption, th, td {
  text-align: left;
  font-weight: normal;
  vertical-align: middle;
}

q, blockquote {
  quotes: none;
}
q:before, q:after, blockquote:before, blockquote:after {
  content: "";
  content: none;
}

a img {
  border: none;
}

article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
  display: block;
}

/* Invoice styles */
html, body {
  /* MOVE ALONG, NOTHING TO CHANGE HERE! */
}

/** 
 * IMPORTANT NOTICE: DON'T USE '!important' otherwise this may lead to broken print layout.
 * Some browsers may require '!important' in oder to work properly but be careful with it.
 */
.clearfix {
  display: block;
  clear: both;
}

.hidden {
  display: none;
}

b, strong, .bold {
  font-weight: bold;
}

#invoice_container {
  font: normal 13px/1.4em 'Open Sans', Sans-serif;
  margin: 0 auto;
  min-height: 1158px;
  background: #F7EDEB url("../img/bg.png") 0 0 no-repeat;
  background-size: 100% auto;
  color: #5B6165;
  position: relative;
  direction: rtl;
  font-family: IRANSansWeb;
}

#memo {
  padding-top: 50px;
  margin: 0 110px 0 60px;
  border-bottom: 1px solid #ddd;
  height: 115px;
}
#memo .logo {
  float: left;
  margin-right: 20px;
}
#memo .logo img {
  width: 150px;
  height: 100px;
}
#memo .company-info {
  float: right;
  text-align: right;
}
#memo .company-info > div:first-child {
  line-height: 1em;
  font-weight: bold;
  font-size: 22px;
  color: #B32C39;
}
#memo .company-info span {
  font-size: 11px;
  display: inline-block;
  min-width: 20px;
}
#memo:after {
  content: '';
  display: block;
  clear: both;
}

#invoice-title-number {
  font-weight: bold;
  margin: 30px 0;
}
#invoice-title-number span {
  line-height: 0.88em;
  display: inline-block;
  min-width: 20px;
}
#invoice-title-number #title {
  text-transform: uppercase;
    padding: 15px 30px;
    font-size: 2.5em;
    background: #1c272b;
    color: #e0e0e0;
}
#invoice-title-number #number {
  margin-left: 10px;
  font-size: 35px;
  position: relative;
  top: -5px;
}

#client-info {
    float: right;
    margin-left: 60px;
    min-width: 220px;
    padding: 8px 24px;
    line-height: 2;
}
#client-info > div {
  margin-bottom: 3px;
  min-width: 20px;
}
#client-info span {
  display: block;
  min-width: 20px;
}
#client-info > span {
  text-transform: uppercase;
}

table {
  table-layout: fixed;
}
table th, table td {
  vertical-align: top;
  word-break: keep-all;
  word-wrap: break-word;
}

#items {
  margin: 35px 30px 0 30px;
}
#items .first-cell, #items table th:first-child, #items table td:first-child {
  width: 40px !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
  text-align: right;
}
#items table {
  border-collapse: separate;
  width: 100%;
}
#items table th {
  font-weight: bold;
  padding: 5px 8px;
  text-align: right;
  background: #B32C39;
  color: white;
  text-transform: uppercase;
}
#items table th:nth-child(2) {
  width: 30%;
  text-align: left;
}
#items table th:last-child {
  text-align: right;
}
#items table td {
  padding: 9px 8px;
  text-align: right;
  border-bottom: 1px solid #ddd;
}
#items table td:nth-child(2) {
  text-align: left;
}

#sums {
  margin: 25px 30px 0 0;
  background: url("../img/total-stripe-firebrick.png") right bottom no-repeat;
}
#sums table {
  float: right;
}
#sums table tr th, #sums table tr td {
  min-width: 100px;
  padding: 9px 8px;
  text-align: right;
}
#sums table tr th {
  font-weight: bold;
  text-align: left;
  padding-right: 35px;
}
#sums table tr td.last {
  min-width: 0 !important;
  max-width: 0 !important;
  width: 0 !important;
  padding: 0 !important;
  border: none !important;
}
#sums table tr.amount-total th {
  text-transform: uppercase;
}
#sums table tr.amount-total th, #sums table tr.amount-total td {
  font-size: 15px;
  font-weight: bold;
}
#sums table tr:last-child th {
  text-transform: uppercase;
}
#sums table tr:last-child th, #sums table tr:last-child td {
  font-size: 15px;
  font-weight: bold;
  color: white;
}

#invoice-info {
  float: left;
  margin: 50px 40px 0 60px;
}
#invoice-info > div > span {
  display: inline-block;
  min-width: 20px;
  min-height: 18px;
  margin-bottom: 3px;
}
#invoice-info > div > span:first-child {
  color: black;
}
#invoice-info > div > span:last-child {
  color: #aaa;
}
#invoice-info:after {
  content: '';
  display: block;
  clear: both;
}

#terms {
  float: left;
  margin-top: 50px;
}
#terms .notes {
  min-height: 30px;
  min-width: 50px;
  color: #B32C39;
}
#terms .payment-info div {
  margin-bottom: 3px;
  min-width: 20px;
}

.thank-you {
  margin: 10px 0 30px 0;
  display: inline-block;
  min-width: 20px;
  text-transform: uppercase;
  font-weight: bold;
  line-height: 0.88em;
  float: right;
  padding: 0px 30px 0px 2px;
  font-size: 50px;
  background: #F4846F;
  color: white;
}

.ib_bottom_row_commands {
  margin-left: 30px !important;
}

/**
 * If the printed invoice is not looking as expected you may tune up
 * the print styles (you can use !important to override styles)
 */
@media print {
  /* Here goes your print styles */
}

    `;


        let a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<head><style type="text/css">');
        a.document.write(elm_styles);
        a.document.write('</style></head>');
        a.document.write('<body>');
        a.document.write(elm_content);
        a.document.write('</body></html>');
        a.print();
    })


});





