<?php get_header();

pageBanner(array(
  'title'     =>  'Past Events',
  'subtitle'  =>  'A recap of our past events.'
));
?>

<div class="container container--narrow page-section">

<?php
$today = date('Ymd');

$pastEvents = new WP_Query(array(
'paged' => get_query_var('paged', 1), // This makes pagination work properly
'post_type' => 'event',
'meta_key' => 'event_date',
'order' => 'ASC',  // Can be ASC or DESC
'orderby' => 'meta_value_num',  // (For order when using numbers)
// 'orderby' => 'meta_value', (For ordering when using strings)
// 'orderby' => 'title',   (ORDERS BY ALPHABETICAL ORDER)
'meta_query' => array(  // This needs to be an array because it gives you multiple filters for the query.
  array(
    'key' => 'event_date',
    'compare' => '<',
    'value' => $today,
    'type' => 'numeric',
  ),
),
));

while($pastEvents->have_posts()) {
  $pastEvents->the_post();

  get_template_part('/template-parts/content-event');

}

  echo paginate_links(array(
      'total' => $pastEvents->max_num_pages,

  ));

?>



</div>

<?php get_footer(); ?>