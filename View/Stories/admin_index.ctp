<div class="users index">
    <div class="row">
        <h2 class="span11"><?php echo __d('stories', 'Stories'); ?></h2>
        <div class="span1">
            <?php echo $this->Html->link(__d('stories', 'Add'), array('action' => 'add'), array('class' => 'btn btn-success icon icon-add'));?>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="header"><?php echo $this->Paginator->sort('image_file_name', 'Thumbnail'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('title', 'Story Title'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('adminuser_id', 'Created By'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('premium', 'Premium'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('averageRating', 'Average Rating'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('category', 'Category'); ?></th>
            <th class="header"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
            <th class="actions"><?php echo __d('users', 'Actions'); ?></th>
        </tr>
        <?php foreach ($stories as $story){ ?>
            <tr>
                <td>
                    <?php
                        if($story['Story']['image_file_name'] == NULL || empty($story['Story']['image_file_name'])){
                            echo "NO PICTURE";
                        }else{
                            $linkName = explode('.', $story['Story']['image_file_name']);
                            $linkName = $linkName[0].'_thumb.jpg';
                            echo $this->Html->image('/upload/stories/'.$story['Story']['id'].'/'.$linkName, array('alt' => $story['Story']['title']));
                        }

                    ?>
                </td>
                <td>
                    <?php echo $story['Story']['title']; ?>
                </td>
                <td>
                    <?php echo $users[$story['Story']['adminuser_id']]; ?>
                </td>
                <td>
                    <?php
                        if($story['Story']['premium'] == 0){
                            echo 'No';
                        }else{
                            echo 'Yes';
                        }
                    ?>
                </td>
                <td>
                    <?php echo $story['Story']['averageRating']; ?>
                </td>
                <td>
                    <?php echo $options[$story['Story']['category']]; ?>
                </td>
                <td>
                    <?php echo $this->Time->timeAgoInWords($story['Story']['created']);  ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link(__d('stories', 'View'), array('admin' => true, 'controller' => 'Stories', 'action'=>'view', $story['Story']['id'])); ?>
                    <?php echo $this->Html->link(__d('stories', 'Edit'), array('admin' => true, 'action'=>'edit', $story['Story']['id'])); ?>
                    <?php echo $this->Html->link(__d('stories', 'Delete'), array('admin' => true, 'action'=>'delete', $story['Story']['id']), null, sprintf(__d('users', 'Are you sure you want to delete %s?'), $story['Story']['title'])); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->element('pagination'); ?>
</div>