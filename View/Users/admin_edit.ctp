<div class="users form">
    <h2><?php echo $this->Html->link(__d('user', 'User'), array('action' => 'index')); ?> - <?php echo __d('tag', 'Edited'); ?></h2>
    <?php
    echo $this->Form->create('User');
    echo $this->Form->input('id', array('class' => 'input-xlarge', 'value' => $user['User']['id'], 'type' => 'hidden'));
    echo $this->Form->input('username', array('class' => 'input-xlarge', 'label' => 'Title', 'value' => $user['User']['username']));
    echo $this->Form->input('email', array('type' => 'text', 'label' => 'email', 'value' => $user['User']['email']));

    echo "<div class='control-group'><label for='UserComments' class='control-label' text='UserComments'>Comments</label>";
    foreach($user['Comment'] as $comment) {
        echo "<div class = 'controls'>";
            echo '<input name="data[Comment]['.$comment['id'].'][id]" class="" value="'.$comment['id'].'" type="hidden" id="CommentsId_'.$comment['id'].'">';
            echo '<input name="data[Comment]['.$comment['id'].'][story_id]" class="" value="'.$comment['story_id'].'" type="hidden" id="CommentsStoryId_'.$comment['id'].'">';
            echo '<input name="data[Comment]['.$comment['id'].'][user_id]" class="" value="'.$comment['user_id'].'" type="hidden" id="CommentsUserId_'.$comment['id'].'">';
            echo '<input name="data[Comment]['.$comment['id'].'][reply_id]" class="" value="'.$comment['reply_id'].'" type="hidden" id="CommentsReplyId_'.$comment['id'].'">';
            echo '<input name="data[Comment]['.$comment['id'].'][comment]" class="input-xlarge" value="'.$comment['comment'].'" type="text" id="UserComments_'.$comment['id'].'">';
            echo $this->Html->link(__d('comments', 'Delete Comment'), array('admin' => true, 'controller' => 'comments', 'action'=>'delete', $comment['id'], $comment['user_id']), null, sprintf(__d('comments', 'Are you sure you want to delete %s?'), $comment['comment']));

    echo "</div>";
    }
    echo "</div>";

    echo $this->Form->submit(__d('user', 'Edit'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
