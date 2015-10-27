<div class="users index">
    <div class="row">
        <h2 class="span11"><?php echo __d('users', 'Users'); ?></h2>
        <div class="span1">
            <?php //echo $this->Html->link(__d('tag', 'Add'), array('action' => 'add'), array('class' => 'btn btn-success icon icon-add')); ?>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="header"><?php echo $this->Paginator->sort('username', 'Username'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('last_login', 'Last Login'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
            <th class="actions"><?php echo __d('tag', 'Actions'); ?></th>
        </tr>
        <?php foreach ($users as $user){ ?>
            <tr>
                <td>
                    <?php echo $user['User']['username']; ?>
                </td>
                <td>
                    <?php echo $user['User']['email']; ?>
                </td>
                <td>
                    <?php echo $this->Time->timeAgoInWords($user['User']['last_login']);  ?>
                </td>
                <td>
                    <?php echo $this->Time->timeAgoInWords($user['User']['created']);  ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('user', 'View'), array('admin' => true, 'controller' => 'Users', 'action'=>'view', $user['User']['id'])); ?>
                    <?php echo $this->Html->link(__d('user', 'Edit'), array('admin' => true, 'action'=>'edit', $user['User']['id'])); ?>
                    <?php echo $this->Html->link(__d('user', 'Delete'), array('admin' => true, 'action'=>'delete', $user['User']['id']), null, sprintf(__d('tags', 'Are you sure you want to delete %s?'), $user['User']['username'])); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->element('pagination'); ?>
</div>