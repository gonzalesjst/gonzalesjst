<?php
/**
 * Title: Blog Pattern
 * Slug: lito/blog-block
 * Description: A blog layout with two primary posts and several secondary posts.
 * Categories: lito
 */
?>
<!-- wp:heading {"align":"wide"} -->
<h2 class="wp-block-heading alignwide">Read the <strong>BLOG</strong></h2>
<!-- /wp:heading -->
<!-- wp:group {"align":"full","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|m"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" id="blog" style="margin-bottom:var(--wp--preset--spacing--m)"><!-- wp:query {"queryId":14,"query":{"perPage":"2","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"only","inherit":false},"enhancedPagination":true,"align":"wide","className":"is-style-default","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide is-style-default"><!-- wp:post-template {"className":"is-style-autostack-columns","layout":{"type":"grid","columnCount":2}} -->
<!-- wp:cover {"useFeaturedImage":true,"dimRatio":30,"overlayColor":"black","isUserOverlayColor":true,"minHeight":100,"minHeightUnit":"%","contentPosition":"center center","tagName":"article","className":"is-style-stretch-cover","style":{"color":{"text":"#ffffff"},"elements":{"link":{"color":{"text":"#ffffff"}}},"spacing":{"blockGap":"var:preset|spacing|l"}},"layout":{"type":"default"}} -->
<article class="wp-block-cover is-style-stretch-cover has-text-color has-link-color" style="color:#ffffff;min-height:100%"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-30 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"space-between"}} -->
<div class="wp-block-group" style="min-height:100%"><!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xxs"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:avatar {"size":40} /-->

<!-- wp:post-author-name {"fontSize":"body-small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-date {"fontSize":"body-small"} /--></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"0px","style":{"layout":{"flexSize":"var(\u002d\u002dlito-spacing-xl)","selfStretch":"fixed"}}} -->
<div style="height:0px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xxs"}},"layout":{"type":"flex","flexWrap":"nowrap","orientation":"vertical","verticalAlignment":"bottom","justifyContent":"left"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","fontSize":"body-small"} /-->

<!-- wp:post-terms {"term":"post_tag","prefix":"#","fontSize":"body-small"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontFamily":"secondary"} /-->

<!-- wp:post-excerpt {"moreText":"Read more","excerptLength":15} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></article>
<!-- /wp:cover -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:query {"queryId":12,"query":{"perPage":"6","pages":0,"offset":"0","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"enhancedPagination":true,"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"className":"is-style-autostack-columns","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"0","padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"border":{"radius":{"bottomLeft":"1.5rem","bottomRight":"1.5rem","topLeft":"1.5rem","topRight":"1.5rem"},"width":"1px","color":"var(\u002d\u002dlito-color-border)"}},"backgroundColor":"content-background","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide has-border-color has-content-background-background-color has-background" style="border-color:var(--lito-color-border);border-width:1px;border-top-left-radius:1.5rem;border-top-right-radius:1.5rem;border-bottom-left-radius:1.5rem;border-bottom-right-radius:1.5rem;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","align":"wide","className":"has-shadow-m","style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"layout":{"selfStretch":"fit","flexSize":null}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs","padding":{"right":"var:preset|spacing|s","left":"var:preset|spacing|s","top":"var:preset|spacing|s","bottom":"var:preset|spacing|s"}},"elements":{"link":{"color":{"text":"var:preset|color|text-content"}}}},"textColor":"text-content","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group has-text-content-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--s);padding-right:var(--wp--preset--spacing--s);padding-bottom:var(--wp--preset--spacing--s);padding-left:var(--wp--preset--spacing--s)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xxs"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xxs"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:avatar {"size":40} /-->

<!-- wp:post-author-name {"style":{"elements":{"link":{"color":{"text":"var:preset|color|text-secondary"}}}},"textColor":"text-secondary","fontSize":"body-small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-date {"style":{"elements":{"link":{"color":{"text":"var:preset|color|text-secondary"}}}},"textColor":"text-secondary","fontSize":"body-small"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"textColor":"heading"} /-->

<!-- wp:post-excerpt {"moreText":"Read more","excerptLength":35} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous {"label":"\u0026lt;\u0026lt;"} /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next {"label":"\u0026gt;\u0026gt;"} /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->