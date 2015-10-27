<div class="users index">
    <div class="row">
        <h2 class="span11"><?php echo __d('tag', 'Tags'); ?></h2>
        <div class="span1">
            <?php echo $this->Html->link(__d('tag', 'Add'), array('action' => 'add'), array('class' => 'btn btn-success icon icon-add')); ?>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="header"><?php echo $this->Paginator->sort('image_file_name', 'Thumbnail'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('title', 'Tag Name'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('adminuser_id', 'Created By'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('text', 'Tag Text'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
            <th class="actions"><?php echo __d('tag', 'Actions'); ?></th>
        </tr>
        <?php foreach ($tags as $tag){ ?>
            <tr>
                <td>
                    <?php
                    if($tag['Tag']['image_file_name'] == NULL || empty($tag['Tag']['image_file_name'])){
                        echo "NO PICTURE";
                    }else {
                        $linkName = explode('.', $tag['Tag']['image_file_name']);
                        $linkName = $linkName[0].'_thumb.jpg';
                        echo $this->Html->image('/upload/tags/' . $tag['Tag']['id'] . '/' . $linkName, array('alt' => $tag['Tag']['title']));
                    }
                    ?>
                </td>
                <td>
                    <?php echo $tag['Tag']['title']; ?>
                </td>
                <td>
                    <?php echo $users[$tag['Tag']['adminuser_id']]; ?>
                </td>
                <td>
                    <?php echo $this->Text->truncate($tag['Tag']['text'], 30); ?>
                </td>
                <td>
                    <?php echo $this->Time->timeAgoInWords($tag['Tag']['created']);  ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('tag', 'View'), array('admin' => true, 'controller' => 'Tags', 'action'=>'view', $tag['Tag']['id'])); ?>
                    <?php echo $this->Html->link(__d('tag', 'Edit'), array('admin' => true, 'action'=>'edit', $tag['Tag']['id'])); ?>
                    <?php echo $this->Html->link(__d('tag', 'Delete'), array('admin' => true, 'action'=>'delete', $tag['Tag']['id']), null, sprintf(__d('tags', 'Are you sure you want to delete %s?'), $tag['Tag']['title'])); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->element('pagination'); ?>
</div>