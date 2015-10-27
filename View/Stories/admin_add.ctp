<?php echo $this->Html->script('../ckeditor/ckeditor.js');?>
<?php echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyC0fIB6_xMB5tx5JLlLLN3LRzcgG7ulVWc');?>
<?php echo $this->Html->script('../js/google_map.js');?>

<div class="users form">
    <h2><?php echo $this->Html->link(__d('stories', 'Stories'), array('action' => 'index')); ?> - <?php echo __d('stories', 'Add'); ?></h2>
    <?php
    echo $this->Form->create('Story', array('type' => 'file'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title'));
    echo $this->Form->input('tag_line', array('class' => 'input-xlarge', 'label' => 'Tag Line'));
    echo $this->Form->input('story', array('type' => 'textarea', 'class' => 'ckeditor', 'label' => 'Totey Story', 'id' => 'information-text'));
    echo $this->Form->file('image', array('class' => 'controls', 'label' => 'Select Image'));
    echo $this->Form->input('lat', array('class' => 'input-xlarge', 'label' => 'Latitude'));
    echo $this->Form->input('long', array('class' => 'input-xlarge', 'label' => 'Longitude'));
    echo "<div id = 'map'></div>";
    echo "<div class = 'clearfix'></div>";
    echo $this->Form->input('category', array('class' => 'input-xlarge', 'label' => 'Category', 'type' => 'select', 'options' => $options));
    echo $this->Form->input('date', array('class' => 'input-xlarge', 'label' => 'Date of Story', 'type' => 'date', 'minYear' => date('Y') - 6000 ));
    echo $this->Form->input('premium', array('class' => 'input-xlarge', 'label' => 'Is story Premium?'));
    echo $this->Form->input('Tag.Tag', array('class' => 'input-xlarge', 'label' => 'Story Tags', 'multiple' => 'checkbox', 'options' => $tags));
    echo $this->Form->input('adminuser_id', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['id']));
    echo $this->Form->submit(__d('users', 'Save'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
