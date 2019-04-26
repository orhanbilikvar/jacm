<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<?php /* todo orhan*/
$Colclass= $params->get('count', 0);
$app    = JFactory::getApplication();
$path   = JURI::base(true).'/templates/'.$app->getTemplate().'/';
JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
?>
<link rel='stylesheet' href='<? echo $path ?>html/mod_articles_category/<?php echo $moduleclass_sfx; ?>.css' type='text/css'/>
<script>

</script>
<div class="<?php echo $moduleclass_sfx; ?>">
<ul class="category-module<?php echo $moduleclass_sfx; ?> mod-list <?echo "maccol".$Colclass; ?> "   >
	<?php if ($grouped) : ?>
		<?php foreach ($list as $group_name => $group) : ?>
		<li >
			<div class="<?php echo $moduleclass_sfx; ?>-group"><?php echo JText::_($group_name); ?></div>
			<ul>
				<?php foreach ($group as $item) : ?>
					<li class="onecikan<? $onecikan= $item->featured; echo $onecikan; ?>" >
						<?php if ($params->get('link_titles') == 1) : ?>
							<a class="MenuSlayt-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
								<?php echo $item->title; ?>
							</a>
						<?php else : ?>
							<?php echo $item->title; ?>
						<?php endif; ?>

						<?php if ($item->displayHits) : ?>
							<span class="<?php echo $moduleclass_sfx; ?>-hits">
								<?php echo $item->displayHits; ?>
							</span>
						<?php endif; ?>

						<?php if ($params->get('show_author')) : ?>
							<span class="<?php echo $moduleclass_sfx; ?>-writtenby">
								<?php echo $item->displayAuthorName; ?>
							</span>
						<?php endif; ?>

						<?php if ($item->displayCategoryTitle) : ?>
							<span class="<?php echo $moduleclass_sfx; ?>-category">
								<?php echo $item->displayCategoryTitle; ?>
							</span>
						<?php endif; ?>

						<?php if ($item->displayDate) : ?>
							<span class="<?php echo $moduleclass_sfx; ?>-date"><?php echo $item->displayDate; ?></span>
						<?php endif; ?>

						<?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
							<div class="<?php echo $moduleclass_sfx; ?>-tags">
								<?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
							</div>
						<?php endif; ?>


                        <!-- todo orhan-->
                        <?php $images = json_decode($item->images); ?>

                        <?php $fullresim=$images->image_intro; $textresim=$images->image_fulltext; $resim="bos"; ?>

                        <?php if (!empty($textresim)) : ?>
                            <? $resim="image_fulltext"; ?>
                        <?php endif; ?>
                        <?php if (!empty($fullresim)) : ?>
                            <? $resim="image_intro"; ?>
                        <?php endif; ?>


                        <?php if ($resim=="image_intro" || $resim=="image_fulltext" ) : ?>
                            <div class="<?php echo $moduleclass_sfx; ?>-image">
                                <a <?php echo $item->active; ?> href="<?php echo $item->link; ?>">
                                    <img class="<? echo $resim; ?>" src="<?php echo $images->$resim; ?>" alt="<?php echo $item->title; ?>"/>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($resim=="bos" ) : ?>
                            <div class="<?php echo $moduleclass_sfx; ?>-image <? echo "bos"; ?>">
                                <a <?php echo $item->active; ?> href="<?php echo $item->link; ?>">
                                    <div class="resimbos"></div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php $haricilink=$item->xreference; ?>

                        <?php if (empty($haricilink)) : ?>
                        <?php else : ?>
                            <a class="haricilink" href="<? echo $haricilink; ?>" target="_blank" rel="noopener" ></a>
                        <?php endif; ?>
                        <!---->

						<?php if ($params->get('show_introtext')) : ?>
							<p class="<?php echo $moduleclass_sfx; ?>-introtext">
								<?php echo $item->displayIntrotext; ?>
							</p>
						<?php endif; ?>





						<?php if ($params->get('show_readmore')) : ?>
							<p class="<?php echo $moduleclass_sfx; ?>-readmore">
								<a class="<?php echo $moduleclass_sfx; ?>-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
									<?php if ($item->params->get('access-view') == false) : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
									<?php elseif ($readmore = $item->alternative_readmore) : ?>
										<?php echo $readmore; ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
												<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php endif; ?>
									<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
										<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
									<?php else : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
									<?php endif; ?>
								</a>
							</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>
	<?php else : ?>
		<?php foreach ($list as $item) : ?>
            <?php /* todo extra fields */
            $fields = $item->jcfields ?: FieldsHelper::getFields($context, $item, true);
            foreach($fields as $field){
                if ($field->value){
                    $item->fields[$field->name] = $field;
                }
            }
            $alankontrol = $item->fields['ikon']->value;
            ?>
			<li class="onecikan<? $onecikan= $item->featured; echo $onecikan; ?>" >
                <div class="<?php echo $moduleclass_sfx; ?>-liic">
                    <?php if ($params->get('link_titles') == 1) : ?>
                        <h4><a class="<?php echo $moduleclass_sfx; ?>-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h4>


                    <?php else : ?>
                    <h4><?php echo $item->title; ?></h4>
                    <?php endif; ?>



                    <?php if ($item->displayHits) : ?>
                        <span class="<?php echo $moduleclass_sfx; ?>-hits">
                            <?php echo $item->displayHits; ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($params->get('show_author')) : ?>
                        <span class="<?php echo $moduleclass_sfx; ?>-writtenby">
                            <?php echo $item->displayAuthorName; ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($item->displayCategoryTitle) : ?>
                        <span class="<?php echo $moduleclass_sfx; ?>-category">
                            <?php echo $item->displayCategoryTitle; ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($item->displayDate) : ?>
                        <span class="<?php echo $moduleclass_sfx; ?>-date">
                            <?php echo $item->displayDate; ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($params->get('show_tags', 0) && $item->tags->itemTags) : ?>
                        <div class="<?php echo $moduleclass_sfx; ?>-tags">
                            <?php echo JLayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?>
                        </div>
                    <?php endif; ?>

                    <!-- todo orhan-->
                    <?php $images = json_decode($item->images); ?>

                    <?php $fullresim=$images->image_intro; $textresim=$images->image_fulltext; $resim="bos"; ?>

                    <?php if (!empty($alankontrol)) : ?>
                    <?php else : ?>
                        <?php if (!empty($textresim)) : ?>
                            <? $resim="image_fulltext"; ?>
                        <?php endif; ?>
                        <?php if (!empty($fullresim)) : ?>
                            <? $resim="image_intro"; ?>
                        <?php endif; ?>

                    <?php endif; ?>


                    <?php if ($resim=="image_intro" || $resim=="image_fulltext" ) : ?>
                        <div class="<?php echo $moduleclass_sfx; ?>-image">
                            <?php if ($params->get('link_titles') == 1) : ?>
                            <a <?php echo $item->active; ?> href="<?php echo $item->link; ?>">
                                <img class="<? echo $resim; ?>" src="<?php echo $images->$resim; ?>" alt="<?php echo $item->title; ?>"/>
                            </a>
                            <?php else : ?>
                                <img class="<? echo $resim; ?>" src="<?php echo $images->$resim; ?>" alt="<?php echo $item->title; ?>"/>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($resim=="bos" ) : ?>
                        <div class="<?php echo $moduleclass_sfx; ?>-image <? echo "bos"; ?>">
                                <div class="resimbos">


                                    <?php if (!empty($alankontrol)) : ?>
                                        <div class="<?php echo $moduleclass_sfx; ?>-fields" >

                                            <div class="<?php echo $moduleclass_sfx; ?>-ikon <? echo $item->fields['ikon']->value; ?>"></div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                        </div>
                    <?php endif; ?>

                    <?php $haricilink=$item->xreference; ?>

                    <?php if (empty($haricilink)) : ?>
                    <?php else : ?>
                    <a class="haricilink" href="<? echo $haricilink; ?>" target="_blank" rel="noopener" ></a>
                    <?php endif; ?>
                    <!---->


                    <?php if ($params->get('show_introtext')) : ?>
                        <p class="<?php echo $moduleclass_sfx; ?>-introtext">
                            <?php echo $item->displayIntrotext; ?>
                        </p>
                    <?php endif; ?>


                    <?php if ($params->get('show_readmore')) : ?>
                        <p class="<?php echo $moduleclass_sfx; ?>-readmore">
                            <a class="<?php echo $moduleclass_sfx; ?>-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                                <?php if ($item->params->get('access-view') == false) : ?>
                                    <?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
                                <?php elseif ($readmore = $item->alternative_readmore) : ?>
                                    <?php echo $readmore; ?>
                                    <?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                                <?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
                                    <?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
                                <?php else : ?>
                                    <?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
                                    <?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                                <?php endif; ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
</div>