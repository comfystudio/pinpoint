<?php echo $this->Html->script('../ckeditor/ckeditor.js');?>

<div class="users form">
    <h2><?php echo $this->Html->link(__d('news', 'News'), array('action' => 'index')); ?> - <?php echo __d('news', 'Add'); ?></h2>
    <?php
    echo $this->Form->create('News', array('type' => 'file'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $news['News']['title']));
    echo $this->Form->input('text', array('type' => 'textarea', 'class' => 'ckeditor', 'label' => 'Totey Story', 'id' => 'information-text', 'value' => $news['News']['text']));
    echo $this->Form->file('image', array('class' => 'controls', 'label' => 'Select Image'));
    echo $this->Form->submit(__d('news', 'Save'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
