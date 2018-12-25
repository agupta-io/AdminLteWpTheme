<?php get_header(); ?>

<?php if(get_option('ad_header') != '') : ?>
            <div class="col-md-12 hidden-xs hidden-sm ad">
                <?php echo stripslashes(get_option('ad_header')); ?>
            </div>
        <?php endif; ?>
        <?php if(get_option('ad_header_mobile') != '') : ?>
            <div class="col-md-12 visible-xs visible-sm ad">
                <?php echo stripslashes(get_option('ad_header_mobile')); ?>
            </div>
        <?php endif; ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <section class="content-header">
    <h1><?php the_title(); ?></h1>
   
</section>
<section class="content">

<div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title">YYYYY</h3>
        </div>
        <div class="box-body">
              
    <?php the_content(); ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer with-border">
        <?php endwhile; ?>
            <?php endif; ?>
            <?php if(get_option('ad_footer') != '') : ?>
            <div class="col-md-12 hidden-xs hidden-sm ad">
                <?php echo stripslashes(get_option('ad_footer')); ?>
            </div>
        <?php endif; ?>
        <?php if(get_option('ad_footer_mobile') != '') : ?>
            <div class="col-md-12 visible-xs visible-sm ad">
                <?php echo stripslashes(get_option('ad_footer_mobile')); ?>
            </div>
        <?php endif; ?>
        </div>
      </div>

</section>
                
          

  
    <!-- /.row -->
<?php get_footer(); ?>
