<div class="users index">
    <div class="row">
        <h2 class="span11"><?php echo __d('users', 'Admin Users'); ?></h2>
        <div class="span1">
            <?php echo $this->Html->link(__d('users', 'Add'), array('action' => 'add'), array('class' => 'btn btn-success icon icon-add')); ?>
        </div>        
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="header"><?php echo $this->Paginator->sort('username'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('email'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('email_verified'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('active'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('created'); ?></th>
            <th class="actions"><?php echo __d('users', 'Actions'); ?></th>
        </tr>
            <?php foreach ($users as $user){ ?>
            <tr>
                <td>
                    <?php echo $user[$model]['username']; ?>
                </td>
                <td>
                    <?php echo $user[$model]['email']; ?>
                </td>
                <td>
                    <?php echo $user[$model]['email_verified'] == 1 ? __d('users', 'Yes') : __d('users', 'No'); ?>
                </td>
                <td>
                    <?php echo $user[$model]['active'] == 1 ? __d('users', 'Yes') : __d('users', 'No'); ?>
                </td>
                <td>
                    <?php echo $this->Time->timeAgoInWords($user[$model]['created']); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('users', 'View'), array('admin' => true, 'controller' => 'adminusers', 'action'=>'view', $user[$model]['id'])); ?>
                    <?php echo $this->Html->link(__d('users', 'Edit'), array('action'=>'edit', $user[$model]['id'])); ?>
                    <?php echo $this->Html->link(__d('users', 'Delete'), array('action'=>'delete', $user[$model]['id']), null, sprintf(__d('users', 'Are you sure you want to delete # %s?'), $user[$model]['id'])); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->element('pagination'); ?>
</div>