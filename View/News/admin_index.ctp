<div class="users index">
    <div class="row">
        <h2 class="span11"><?php echo __d('news', 'News'); ?></h2>
        <div class="span1">
            <?php echo $this->Html->link(__d('news', 'Add'), array('action' => 'add'), array('class' => 'btn btn-success icon icon-add')); ?>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="header"><?php echo $this->Paginator->sort('image_file_name', 'Thumbnail'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('title', 'Story Title'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('adminuser_id', 'Created By'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('text', 'Text'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
            <th class="actions"><?php echo __d('users', 'Actions'); ?></th>
        </tr>
        <?php foreach ($news as $new){ ?>
            <tr>
                <td>
                    <?php
                    if($new['News']['image_file_name'] == NULL || empty($new['News']['image_file_name'])){
                        echo "NO PICTURE";
                    }else {
                        $linkName = explode('.', $new['News']['image_file_name']);
                        $linkName = $linkName[0].'_thumb.jpg';
                        echo $this->Html->image('/upload/news/' . $new['News']['id'] . '/' . $linkName, array('alt' => $new['News']['title']));
                    }
                    ?>
                </td>
                <td>
                    <?php echo $new['News']['title']; ?>
                </td>
                <td>
                    <?php echo $users[$new['News']['adminuser_id']]; ?>
                </td>
                <td>
                    <?php echo $this->Text->truncate($new['News']['text'], 30); ?>
                </td>
                <td>
                    <?php echo $this->Time->timeAgoInWords($new['News']['created']);  ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('news', 'View'), array('admin' => true, 'controller' => 'News', 'action'=>'view', $new['News']['id'])); ?>
                    <?php echo $this->Html->link(__d('news', 'Edit'), array('admin' => true, 'action'=>'edit', $new['News']['id'])); ?>
                    <?php echo $this->Html->link(__d('news', 'Delete'), array('admin' => true, 'action'=>'delete', $new['News']['id']), null, sprintf(__d('users', 'Are you sure you want to delete %s?'), $new['News']['title'])); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->element('pagination'); ?>
</div>