<div style='margin-bottom:20px;'><?php echo $this->Html->link('Go back to the projects overview', array('controller' => 'projects', 'action' => 'index')); ?></div>

<div class="chart">
    <div id="linewrapper" style="display: block; float: left; margin-bottom: 20px;"></div>

    <?php echo $this->HighCharts->render('Real Velocity'); ?>

    <div id="columnwrapper" style="display: block; float: right; margin-bottom: 20px;"></div>

    <?php echo $this->HighCharts->render('Percentage'); ?>

</div>