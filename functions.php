<?php
/**
 * The current version of the theme.
 *
 * @package panacea
 */

define( 'PANACEA_VERSION', '3.4.1' );

/**
 * Requires.
 */
require get_theme_file_path( '/inc/functions.php' );
require get_theme_file_path( '/inc/menus.php' );
require get_theme_file_path( '/inc/nav-walker.php' );

/**
 * Enable theme support for essential features.
 */
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
// add_theme_support( 'woocommerce' );

/**
 * Load textdomain and set a locale.
 */
load_theme_textdomain( 'panacea', get_template_directory() . '/languages' );

/**
 * Define content width in articles
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _panacea_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'panacea' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'panacea' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_panacea_widgets_init' );


//Site Optimisation
add_action( 'wp_enqueue_scripts', 'themerbasic_scripts' );
function themerbasic_scripts() {
    // Replace jquery with newer version
    wp_deregister_script( 'jquery' );
    wp_register_script(
        'jquery',
        get_theme_file_uri() . '/public/js/jquery.min.js',
        array(),
        null,
        true
    );
    // Remove the jquery loader fallback as this can cause issues with autoptimize or other js combiners
}

/**
 * Enqueue scripts and styles.
 */
function panacea_scripts() {
	$panacea_template = 'site.combined';

	// Styles.
	wp_enqueue_style( 'styles', get_theme_file_uri( "public/css/{$panacea_template}.min.css" ), array(), filemtime( get_theme_file_path( "public/css/{$panacea_template}.min.css" ) ) );

	// Scripts.
	//wp_enqueue_script( 'cookie', get_theme_file_uri( 'templates/_inlinejs/tiny-cookie.min.js' ), array(),null, true );
	//wp_enqueue_script( 'fface', get_theme_file_uri( 'templates/_inlinejs/fontfaceobserver.min.js' ), array(),null, true );
	//wp_enqueue_script( 'afonts', get_theme_file_uri( 'templates/_inlinejs/asyncload-site-fonts.min.js' ), array(),null, true );
	wp_enqueue_script( 'jquery', true );
    wp_enqueue_script( 'scripts', get_theme_file_uri( 'build/js/site.combined.min.js' ), array(), filemtime( get_theme_file_path( 'build/js/site.combined.min.js' ) ), true );

    // Required comment-reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_localize_script( 'scripts', 'screenReaderText', array(
		'expand'      => esc_html__( 'Open child menu', 'panacea' ),
		'collapse'    => esc_html__( 'Close child menu', 'panacea' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'panacea_scripts' );

//Inline Header Scripts - Cookie
add_action( 'wp_head', 'my_header_scripts' );
function my_header_scripts(){
  ?>
  <script>
  !function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports?module.exports=t():e.Cookie=t()}(this,function(){"use strict";function e(t,n,o){return void 0===n?e.get(t):void(null===n?e.remove(t):e.set(t,n,o))}function t(e){return e.replace(/[.*+?^$|[\](){}\\-]/g,"\\$&")}function n(e){var t="";for(var n in e)if(e.hasOwnProperty(n)){if("expires"===n){var r=e[n];"object"!=typeof r&&(r+="number"==typeof r?"D":"",r=o(r)),e[n]=r.toUTCString()}if("secure"===n){if(!e[n])continue;t+=";"+n}t+=";"+n+"="+e[n]}return e.hasOwnProperty("path")||(t+=";path=/"),t}function o(e){var t=new Date,n=e.charAt(e.length-1),o=parseInt(e,10);switch(n){case"Y":t.setFullYear(t.getFullYear()+o);break;case"M":t.setMonth(t.getMonth()+o);break;case"D":t.setDate(t.getDate()+o);break;case"h":t.setHours(t.getHours()+o);break;case"m":t.setMinutes(t.getMinutes()+o);break;case"s":t.setSeconds(t.getSeconds()+o);break;default:t=new Date(e)}return t}return e.enabled=function(){var t,n="__test_key";return document.cookie=n+"=1",t=!!document.cookie,t&&e.remove(n),t},e.get=function(e,n){if("string"!=typeof e||!e)return null;e="(?:^|; )"+t(e)+"(?:=([^;]*?))?(?:;|$)";var o=new RegExp(e),r=o.exec(document.cookie);return null!==r?n?r[1]:decodeURIComponent(r[1]):null},e.getRaw=function(t){return e.get(t,!0)},e.set=function(e,t,o,r){o!==!0&&(r=o,o=!1),r=n(r?r:{});var u=e+"="+(o?t:encodeURIComponent(t))+r;document.cookie=u},e.setRaw=function(t,n,o){e.set(t,n,!0,o)},e.remove=function(t){e.set(t,"a",{expires:new Date})},e});
  </script>
  <?php
}

//Inline Footer Scripts -- FontLoader + Fonts
add_action( 'wp_footer', 'my_footer_scripts' );
function my_footer_scripts(){
  ?>
    <script>
    !function(){"use strict";function t(t){l.push(t),1==l.length&&f()}function e(){for(;l.length;)l[0](),l.shift()}function n(t){this.a=u,this.b=void 0,this.f=[];var e=this;try{t(function(t){r(e,t)},function(t){a(e,t)})}catch(n){a(e,n)}}function o(t){return new n(function(e,n){n(t)})}function i(t){return new n(function(e){e(t)})}function r(t,e){if(t.a==u){if(e==t)throw new TypeError;var n=!1;try{var o=e&&e.then;if(null!=e&&"object"==typeof e&&"function"==typeof o)return void o.call(e,function(e){n||r(t,e),n=!0},function(e){n||a(t,e),n=!0})}catch(i){return void(n||a(t,i))}t.a=0,t.b=e,c(t)}}function a(t,e){if(t.a==u){if(e==t)throw new TypeError;t.a=1,t.b=e,c(t)}}function c(e){t(function(){if(e.a!=u)for(;e.f.length;){var t=e.f.shift(),n=t[0],o=t[1],i=t[2],t=t[3];try{0==e.a?i("function"==typeof n?n.call(void 0,e.b):e.b):1==e.a&&("function"==typeof o?i(o.call(void 0,e.b)):t(e.b))}catch(r){t(r)}}})}function s(t){return new n(function(e,n){function o(n){return function(o){a[n]=o,r+=1,r==t.length&&e(a)}}var r=0,a=[];0==t.length&&e(a);for(var c=0;c<t.length;c+=1)i(t[c]).c(o(c),n)})}function d(t){return new n(function(e,n){for(var o=0;o<t.length;o+=1)i(t[o]).c(e,n)})}var f,l=[];f=function(){setTimeout(e)};var u=2;n.prototype.g=function(t){return this.c(void 0,t)},n.prototype.c=function(t,e){var o=this;return new n(function(n,i){o.f.push([t,e,n,i]),c(o)})},window.Promise||(window.Promise=n,window.Promise.resolve=i,window.Promise.reject=o,window.Promise.race=d,window.Promise.all=s,window.Promise.prototype.then=n.prototype.c,window.Promise.prototype["catch"]=n.prototype.g)}(),function(){function t(t,e){document.addEventListener?t.addEventListener("scroll",e,!1):t.attachEvent("scroll",e)}function e(t){document.body?t():document.addEventListener?document.addEventListener("DOMContentLoaded",function e(){document.removeEventListener("DOMContentLoaded",e),t()}):document.attachEvent("onreadystatechange",function n(){"interactive"!=document.readyState&&"complete"!=document.readyState||(document.detachEvent("onreadystatechange",n),t())})}function n(t){this.a=document.createElement("div"),this.a.setAttribute("aria-hidden","true"),this.a.appendChild(document.createTextNode(t)),this.b=document.createElement("span"),this.c=document.createElement("span"),this.h=document.createElement("span"),this.f=document.createElement("span"),this.g=-1,this.b.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.c.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.f.style.cssText="max-width:none;display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;",this.h.style.cssText="display:inline-block;width:200%;height:200%;font-size:16px;max-width:none;",this.b.appendChild(this.h),this.c.appendChild(this.f),this.a.appendChild(this.b),this.a.appendChild(this.c)}function o(t,e){t.a.style.cssText="max-width:none;min-width:20px;min-height:20px;display:inline-block;overflow:hidden;position:absolute;width:auto;margin:0;padding:0;top:-999px;white-space:nowrap;font-synthesis:none;font:"+e+";"}function i(t){var e=t.a.offsetWidth,n=e+100;return t.f.style.width=n+"px",t.c.scrollLeft=n,t.b.scrollLeft=t.b.scrollWidth+100,t.g!==e&&(t.g=e,!0)}function r(e,n){function o(){var t=r;i(t)&&t.a.parentNode&&n(t.g)}var r=e;t(e.b,o),t(e.c,o),i(e)}function a(t,e){var n=e||{};this.family=t,this.style=n.style||"normal",this.weight=n.weight||"normal",this.stretch=n.stretch||"normal"}function c(){if(null===u)if(s()&&/Apple/.test(window.navigator.vendor)){var t=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))(?:\.([0-9]+))/.exec(window.navigator.userAgent);u=!!t&&603>parseInt(t[1],10)}else u=!1;return u}function s(){return null===p&&(p=!!document.fonts),p}function d(){if(null===h){var t=document.createElement("div");try{t.style.font="condensed 100px sans-serif"}catch(e){}h=""!==t.style.font}return h}function f(t,e){return[t.style,t.weight,d()?t.stretch:"","100px",e].join(" ")}var l=null,u=null,h=null,p=null;a.prototype.load=function(t,i){var a=this,d=t||"BESbswy",u=0,h=i||3e3,p=(new Date).getTime();return new Promise(function(t,i){if(s()&&!c()){var m=new Promise(function(t,e){function n(){(new Date).getTime()-p>=h?e():document.fonts.load(f(a,'"'+a.family+'"'),d).then(function(e){1<=e.length?t():setTimeout(n,25)},function(){e()})}n()}),w=new Promise(function(t,e){u=setTimeout(e,h)});Promise.race([w,m]).then(function(){clearTimeout(u),t(a)},function(){i(a)})}else e(function(){function e(){var e;(e=-1!=v&&-1!=y||-1!=v&&-1!=g||-1!=y&&-1!=g)&&((e=v!=y&&v!=g&&y!=g)||(null===l&&(e=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent),l=!!e&&(536>parseInt(e[1],10)||536===parseInt(e[1],10)&&11>=parseInt(e[2],10))),e=l&&(v==b&&y==b&&g==b||v==x&&y==x&&g==x||v==E&&y==E&&g==E)),e=!e),e&&(T.parentNode&&T.parentNode.removeChild(T),clearTimeout(u),t(a))}function c(){if((new Date).getTime()-p>=h)T.parentNode&&T.parentNode.removeChild(T),i(a);else{var t=document.hidden;!0!==t&&void 0!==t||(v=s.a.offsetWidth,y=m.a.offsetWidth,g=w.a.offsetWidth,e()),u=setTimeout(c,50)}}var s=new n(d),m=new n(d),w=new n(d),v=-1,y=-1,g=-1,b=-1,x=-1,E=-1,T=document.createElement("div");T.dir="ltr",o(s,f(a,"sans-serif")),o(m,f(a,"serif")),o(w,f(a,"monospace")),T.appendChild(s.a),T.appendChild(m.a),T.appendChild(w.a),document.body.appendChild(T),b=s.a.offsetWidth,x=m.a.offsetWidth,E=w.a.offsetWidth,c(),r(s,function(t){v=t,e()}),o(s,f(a,'"'+a.family+'",sans-serif')),r(m,function(t){y=t,e()}),o(m,f(a,'"'+a.family+'",serif')),r(w,function(t){g=t,e()}),o(w,f(a,'"'+a.family+'",monospace'))})})},"object"==typeof module?module.exports=a:(window.FontFaceObserver=a,window.FontFaceObserver.prototype.load=a.prototype.load)}();
    if(document.documentElement.className.indexOf("fonts-loaded")<0){var panacea=new FontFaceObserver("panacea",{}),PoppinsLight=new FontFaceObserver("Poppins",{weight:200}),PoppinsRegular=new FontFaceObserver("Poppins",{weight:400}),PoppinsMedium=new FontFaceObserver("Poppins",{weight:500}),PoppinsSemiBold=new FontFaceObserver("Poppins",{weight:600}),PoppinsBold=new FontFaceObserver("Poppins",{weight:700});Promise.all([panacea.load(""),PoppinsLight.load(),PoppinsRegular.load(),PoppinsMedium.load(),PoppinsSemiBold.load(),PoppinsBold.load()]).then(function(){console.log("Fonts Loaded"),document.documentElement.className+=" fonts-loaded",Cookie.set("fonts-loaded",1,{expires:"7D",secure:!0})})}
    </script>
  <?php
}
//Defer or Async Scripts
/*Function to defer (defer="defer") (async="async") or asynchronously load scripts*/
function js_async_attr($tag){

    # Do not add defer or async attribute to these scripts
    $scripts_to_exclude = array('script1.js', 'script2.js', 'script3.js');

    foreach($scripts_to_exclude as $exclude_script){
     if(true == strpos($tag, $exclude_script ) )
     return $tag;
    }

    # Defer or async all remaining scripts not excluded above
    return str_replace( ' src', ' defer="defer" src', $tag );
    }
    add_filter( 'script_loader_tag', 'js_async_attr', 10 );