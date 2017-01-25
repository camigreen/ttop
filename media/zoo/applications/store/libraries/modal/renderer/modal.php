<div id="<?php echo $config->get('type').'-'.$config->get('name'); ?>-modal" class="uk-modal lpiModal" >
	<div class="uk-modal-dialog">
		<div class="contents">
			<div class="uk-modal-header uk-text-center">
				<div class="modal-title">
					<span class="uk-article-title"><?php echo $data['title']; ?></span>
				</div>
				<div class="modal-subtitle">
			        <span class="uk-article-lead"><?php echo $data['subtitle']; ?></span>
			    </div>
			    <?php if($data['scroll']) : ?>
			    <div class="modal-scroll-title">
			        <span class="uk-text-small"><?php echo $data['scrolltext']; ?><i class="uk-icon uk-icon-arrow-down" style="margin-left:5px;"></i></span>
			    </div>
				<?php endif; ?>
			</div>
			<div class="modal-content">
				<?php if($data['scroll']) : ?>
					<div class="uk-overflow-container">
						<?php echo $content; ?>
					</div>
				<?php else : ?>
					<?php echo $content; ?>
				<?php endif; ?>
			</div>
			<div class="uk-modal-footer uk-text-right">
				<ul class="uk-grid" data-uk-grid-margin>
					<?php if(isset($data['save'])) : ?>
			    	<li class="uk-width-1-3 uk-container-center">
			    		<button class="modal-save uk-button uk-button-primary uk-width-1-1" ><?php echo $data['save'] ?></button>
			    	</li>
			    	<?php endif; ?>
			    	<?php if(isset($data['cancel'])) : ?>
			    	<li class="uk-width-1-3 uk-modal-close uk-container-center">
						<button class="modal-cancel uk-button uk-button-default uk-width-1-1" ><?php echo $data['cancel']; ?></button>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

 