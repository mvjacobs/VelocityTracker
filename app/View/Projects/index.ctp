<div class="projects index">
    <h2><?php echo __('Projects'); ?></h2>
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo __('Projects'); ?></th>
    </tr>
    <?php foreach ($projects as $projectId => $projectName): ?>
    <tr>
        <td>
            <?php echo $this->Html->link($projectName, array('controller' => 'projects',
                                                            'action'     => 'view',
                                                            $projectId)
                                        );
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>

<div class='actions'>
    <h3>Actions</h3>
    <?php echo $this->Html->link('Logout', array('controller' => 'projects', 'action' => 'logout')); ?>
</div>
