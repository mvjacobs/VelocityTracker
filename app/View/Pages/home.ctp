<div class="pages form">
<?php echo $this->Form->create('Login'); ?>
    <fieldset>
        <legend><?php echo __('Login'); ?></legend>
    <?php
        echo $this->Form->input('api_key');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>






