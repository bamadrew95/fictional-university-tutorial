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
  ?>

      <div class="event-summary">
        <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php
            $eventDate = new DateTime(get_field('event_date'));
            echo $eventDate->format('M');
            ?></span>
            <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
          </div>
      </div>  

<?php }

  echo paginate_links(array(
      'total' => $pastEvents->max_num_pages,

  ));

?>



</div>

<?php get_footer(); ?>