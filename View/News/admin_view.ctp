<?php echo $this->Html->script('../ckeditor/ckeditor.js');?>

<div class="users form">
    <h2><?php echo $this->Html->link(__d('news', 'News'), array('action' => 'index')); ?> - <?php echo __d('news', 'View'); ?></h2>
    <?php
    $linkName = explode('.', $news['News']['image_file_name']);
    $linkName = $linkName[0].'_normal.jpg';
    echo $this->Form->create('News', array('type' => 'file'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $news['News']['title'], 'disabled' => 'disabled'));
    echo $this->Form->input('text', array('type' => 'textarea', 'label' => 'Totey Story', 'value' => $news['News']['text'], 'disabled' => 'disabled', 'id' => 'view-story'));
    echo "<div class='control-group'><label for='StoryImage' class='control-label' text='Image'>Image</label>";
        echo "<div class = 'controls'>";
            if($news['News']['image_file_name'] == NULL || empty($news['News']['image_file_name'])){
                echo "NO PICTURE";
            }else {
                $linkName = explode('.', $news['News']['image_file_name']);
                $linkName = $linkName[0].'_normal.jpg';
                echo $this->Html->image('/upload/news/' . $news['News']['id'] . '/' . $linkName, array('alt' => $news['News']['title']));
            }
        echo "</div>";
    echo "</div>";
    echo $this->Form->submit(__d('news', 'Back'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>




