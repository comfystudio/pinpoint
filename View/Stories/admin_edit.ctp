<?php echo $this->Html->script('../ckeditor/ckeditor.js');?>
<?php echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyC0fIB6_xMB5tx5JLlLLN3LRzcgG7ulVWc');?>
<?php echo $this->Html->script('../js/google_map.js');?>

<div class="users form">
    <h2><?php echo $this->Html->link(__d('stories', 'Stories'), array('action' => 'index')); ?> - <?php echo __d('stories', 'Edit'); ?></h2>
    <?php
    echo $this->Form->create('Story', array('type' => 'file'));
    echo $this->Form->input('id', array('class' => 'input-xlarge', 'value' => $story['Story']['id'], 'type' => 'hidden'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $story['Story']['title']));
    echo $this->Form->input('tag_line', array('class' => 'input-xlarge', 'label' => 'Tag Line', 'value' => $story['Story']['tag_line']));
    echo $this->Form->input('story', array('type' => 'textarea', 'class' => 'ckeditor', 'label' => 'Totey Story', 'id' => 'information-text', 'value' => $story['Story']['story']));
    echo $this->Form->file('image', array('class' => 'controls', 'label' => 'Select Image'));
    echo $this->Form->input('lat', array('class' => 'input-xlarge', 'label' => 'Latitude', 'value' => $story['Story']['lat']));
    echo $this->Form->input('long', array('class' => 'input-xlarge', 'label' => 'Longitude', 'value' => $story['Story']['long']));
    echo "<div id = 'map'></div>";
    echo "<div class = 'clearfix'></div>";
    echo $this->Form->input('category', array('class' => 'input-xlarge', 'label' => 'Category', 'type' => 'select', 'options' => $options, 'selected' => $story['Story']['category']));
    echo $this->Form->input('date', array('class' => 'input-xlarge', 'label' => 'Date of Story', 'type' => 'date', 'minYear' => date('Y') - 6000, 'selected' => $story['Story']['date'] ));
    echo $this->Form->input('premium', array('class' => 'input-xlarge', 'label' => 'Is story Premium?', 'checked' => $story['Story']['premium']));
    echo $this->Form->input('Tag.Tag', array('class' => 'input-xlarge', 'label' => 'Story Tags', 'multiple' => 'checkbox', 'options' => $tags, 'selected' => $selectedTags));
    echo $this->Form->input('adminuser_id', array('type' => 'hidden', 'value' => $story['Story']['adminuser_id']));
    echo $this->Form->submit(__d('users', 'Save'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
