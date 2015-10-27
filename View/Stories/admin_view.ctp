
<div class="users form">
    <h2><?php echo $this->Html->link(__d('stories', 'Stories'), array('action' => 'index')); ?> - <?php echo __d('stories', 'View'); ?></h2>
    <?php


    echo $this->Form->create('Story', array('type' => 'file'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $story['Story']['title'], 'disabled' => 'disabled'));
    echo $this->Form->input('tag_line', array('class' => 'input-xlarge', 'label' => 'Tag Line', 'value' => $story['Story']['tag_line'], 'disabled' => 'disabled'));
    echo $this->Form->input('story', array('type' => 'textarea', 'label' => 'Totey Story', 'value' => $story['Story']['story'], 'disabled' => 'disabled', 'id' => 'view-story'));

    echo "<div class='control-group'><label for='StoryImage' class='control-label' text='Image'>Image</label>";
        echo "<div class = 'controls'>";
            if($story['Story']['image_file_name'] == NULL || empty($story['Story']['image_file_name'])){
                echo "NO PICTURE";
            }else{
                $linkName = explode('.', $story['Story']['image_file_name']);
                $linkName = $linkName[0].'_normal.jpg';
                echo $this->Html->image('/upload/stories/' . $story['Story']['id'] . '/' . $linkName, array('alt' => $story['Story']['title']));
            }
        echo "</div>";
    echo "</div>";
    echo $this->Form->input('lat', array('class' => 'input-xlarge', 'label' => 'Latitude' , 'value' => $story['Story']['lat'], 'disabled' => 'disabled'));
    echo $this->Form->input('long', array('class' => 'input-xlarge', 'label' => 'Longitude', 'value' => $story['Story']['long'], 'disabled' => 'disabled'));
    echo $this->Form->input('category', array('class' => 'input-xlarge', 'label' => 'Category', 'type' => 'select', 'options' => $options, 'selected' => $story['Story']['category'], 'disabled' => 'disabled'));
    echo $this->Form->input('date', array('class' => 'input-xlarge', 'label' => 'Date of Story', 'type' => 'date', 'minYear' => date('Y') - 6000, 'selected' => $story['Story']['date'], 'disabled' => 'disabled'));
    echo $this->Form->input('premium', array('class' => 'input-xlarge', 'label' => 'Is story Premium?', 'checked' => $story['Story']['premium'], 'disabled' => 'disabled'));
    echo $this->Form->input('tags', array('class' => 'input-xlarge', 'label' => 'Story Tags', 'multiple' => 'checkbox', 'options' => $tags, 'disabled' => 'disabled', 'selected' => $selectedTags));
    //echo $this->Form->input('adminuser_id', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['id']));
    echo $this->Form->submit(__d('stories', 'Back'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
    <h2><?php //echo $this->Html->link('Back', array('action' => 'index'));?>
</div>