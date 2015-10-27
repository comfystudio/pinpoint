<?php echo $this->Html->script('../ckeditor/ckeditor.js');?>

<div class="users form">
    <h2><?php echo $this->Html->link(__d('tags', 'Tags'), array('action' => 'index')); ?> - <?php echo __d('tags', 'Add'); ?></h2>
    <?php
    echo $this->Form->create('Tag', array('type' => 'file'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title'));
    echo $this->Form->input('text', array('type' => 'textarea', 'class' => 'ckeditor', 'label' => 'Totey Tag', 'id' => 'information-text'));
    echo $this->Form->file('image', array('class' => 'controls', 'label' => 'Select Image'));
    echo $this->Form->input('adminuser_id', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['id']));
    echo $this->Form->submit(__d('tags', 'Save'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
