<div class="users form">
    <h2><?php echo $this->Html->link(__d('tag', 'Tags'), array('action' => 'index')); ?> - <?php echo __d('tag', 'View'); ?></h2>
    <?php
    echo $this->Form->create('News', array('type' => 'file'));
    echo $this->Form->input('title', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $tag['Tag']['title'], 'disabled' => 'disabled'));
    echo $this->Form->input('text', array('type' => 'textarea', 'label' => 'Totey Story', 'value' => $tag['Tag']['text'], 'disabled' => 'disabled', 'id' => 'view-story'));
    echo "<div class='control-group'><label for='StoryImage' class='control-label' text='Image'>Image</label>";
        echo "<div class = 'controls'>";
            if($tag['Tag']['image_file_name'] == NULL || empty($tag['Tag']['image_file_name'])){
                echo "NO PICTURE";
            }else {
                $linkName = explode('.', $tag['Tag']['image_file_name']);
                $linkName = $linkName[0].'_normal.jpg';
                echo $this->Html->image('/upload/tags/' . $tag['Tag']['id'] . '/' . $linkName, array('alt' => $tag['Tag']['title']));
            }
        echo "</div>";
    echo "</div>";
    echo $this->Form->submit(__d('tag', 'Back'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>




