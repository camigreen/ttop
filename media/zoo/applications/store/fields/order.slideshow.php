<?php

//$make = $parent->getParams('boat.manufacturer');
$product = $parent->getValue('product');
$make = $product->getParam('boat.manufacturer');
$model = $make->getModel();
$imagepath = $this->app->path->path('images.boats:'.str_replace('-', '_', $make->name).'/'.$product->type.'/'.str_replace('-','_',$model->get('name')));
$imageurl = $this->app->path->url('images.boats:'.str_replace('-', '_', $make->name).'/'.$product->type.'/'.str_replace('-','_',$model->get('name')));
$images = $this->app->filesystem->readDirectoryFiles($imagepath,'', false, false);
$count = count($images);
$i = 0;
if($count == 0) {
    $imageurl = '/images/boats/PNA';
    $images[] = 'OfficialPNA.png';
}
?>



<div class="uk-container-center" style="width:75%">
    <div class="uk-slidenav-position" data-uk-slideshow="{height: 375}">
        <ul class="uk-slideshow">
            <?php foreach($images as $image) : ?>
            <?php echo $image; ?>
                <li><a href="<?php echo $imageurl.'/'.$image; ?>" data-uk-lightbox="{group: 'slideshow'}" title="<?php echo $make->label.' '.$model->get('label'); ?>"><img src="<?php echo $imageurl.'/'.$image; ?>" height="375px" /></a></li>
            <?php endforeach; ?>
        </ul>
        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
        <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
            <?php while($i+1 <= $count) :?>
                <li data-uk-slideshow-item="<?php echo $i; ?>"><a href=""></a></li>
                <?php $i++; ?>
            <?php endwhile; ?>
        </ul>
    </div>
    <div class="uk-text-center"><i class="uk-icon uk-icon-search-plus uk-margin-right"></i>Click photo to enlarge</div>
</div>