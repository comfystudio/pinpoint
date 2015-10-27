<div class="users form">
    <h2><?php echo $this->Html->link(__d('user', 'User'), array('action' => 'index')); ?> - <?php echo __d('tag', 'View'); ?></h2>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('username', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $user['User']['username'], 'disabled' => 'disabled'));
    echo $this->Form->input('email', array('type' => 'text', 'label' => 'email', 'value' => $user['User']['email'], 'disabled' => 'disabled'));
    echo $this->Form->input('last_login', array('class' => 'input-xlarge', 'label' => 'Last Login', 'value' => $this->Time->timeAgoInWords($user['User']['last_login']), 'disabled' => 'disabled', 'type' => 'text'));
    echo $this->Form->input('created', array('class' => 'input-xlarge', 'label' => 'Created', 'value' => $this->Time->timeAgoInWords($user['User']['created']), 'disabled' => 'disabled', 'type' => 'text'));

    echo "<div class='control-group'><label for='UserComments' class='control-label' text='UserComments'>Comments</label>";
        foreach($user['Comment'] as $comment) {
            echo "<div class = 'controls'>";

            echo '<input name="data[User][comments]['.$comment['id'].']" class="input-xlarge" value="'.$comment['comment'].'" disabled="disabled" type="text" id="UserComments_"'.$comment['id'].'>';
            echo "</div>";
        }
    echo "</div>";

    echo "<div class='control-group'><label for='UserRatings' class='control-label' text='UserRatings'>Ratings</label>";
    foreach($user['Rating'] as $rating) {
        echo "<div class = 'controls'>";

        echo '<input name="data[User][ratings]['.$rating['id'].']" class="input-xlarge" value="Rated &quot;'.$rating['Story']['title'].'&quot; '.$rating['score'].' / 10" disabled="disabled" type="text" id="UserRatings_"'.$rating['id'].'>';
        echo "</div>";
    }
    echo "</div>";

    echo $this->Form->submit(__d('user', 'Back'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
