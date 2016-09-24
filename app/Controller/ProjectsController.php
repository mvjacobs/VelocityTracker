<?php
App::uses('AppController', 'Controller');

class ProjectsController extends AppController {
    public $name = 'Projects';

    public $helpers = array('Html');

    public $components = array('HighCharts.HighCharts');

    /**
     * index method
     *
     * @return void
     * @access public
     */
    public function index() {
        try {
            $apiProjects = $this->Project->getAllProjects();

            if (isset($apiProjects['id'])) {
                $projects[$apiProjects['id']['@']] = $apiProjects['name'];
            }
            else {
                foreach ($apiProjects as $project) {
                    $projects[$project['id']['@']] = $project['name'];
                }
            }

            $this->set('projects', $projects);
        }
        catch (exception $e) {
            CakeSession::destroy('token');
            $this->Session->setFlash($e->getMessage());
            $this->redirect('/');
        }
    }

    /**
     * view method
     *
     * @param $projectId
     * @return void
     * @access public
     */
    public function view($projectId) {
        try {
            $iterations = $this->Project->getIterations($projectId);

            $sprintLengths        = array();
            $sprints              = array();
            $chartpoints          = array();
            $chartRealPoints      = array();
            $chartStrength        = array();
            $chartAvgPointsPerDay = array();
            foreach ($iterations['iterations']['iteration'] as $iteration) {
                $points = 0;
                foreach ($iteration['stories']['story'] as $story) {
                    if (isset($story['current_state']) && $story['current_state'] == 'accepted' && isset($story['estimate']['@'])) {
                        $points += $story['estimate']['@'];
                    }
                }

                if ($points > 0) {
                    // calculate sprint length in days
                    $start  = new DateTime($iteration['start']['@']);
                    $finish = new DateTime($iteration['finish']['@']);
                    $period = $start->diff($finish);

                    $sprintLengths[]        = $period->d;

                    $sprints[]              = $iteration['id']['@'].' ('.$period->d.'d)';

                    $chartPoints[]          = round($points / $iteration['team_strength']['@']);

                    $chartRealPoints[]      = $points;

                    $chartStrength[]        = $iteration['team_strength']['@'] * 100;

                    $chartDates[]           = date('d-m-Y', strtotime($iteration['finish']['@']));

                    $chartAvgPointsPerDay[] = round(($points / $iteration['team_strength']['@']) / $period->d);
                }
            }

            /**
             * GENERATION OF GRAPHS
             *
             * For measurement of the real velocity
             *
             */
            $chartName           = 'Real Velocity';
            $percentageChartName = 'Percentage';

            $mychart         = $this->HighCharts->create($chartName, 'line' );
            $percentageChart = $this->HighCharts->create($percentageChartName, 'column');

            /* The Real Velocity graph */
            $this->HighCharts->setChartParams(
                $chartName,
                array(
                    'title'                                 => 'Real velocity (based on 100% team strength)',
                    'renderTo'                              => 'linewrapper',
                    'chartWidth'                            => 600,
                    'chartHeight'                           => 400,
                    'xAxisCategories'                       => $sprints,
                    'yAxisTitleText'                        => 'Storypoints',
                    'enableAutoStep'                        => FALSE,
                    'creditsEnabled'                        => FALSE
                )
            );

            /* The Real Velocity percentage graph */
            $this->HighCharts->setChartParams(
                $percentageChartName,
                array(
                    'title'                                 => 'Average points per day per sprint',
                    'renderTo'                              => 'columnwrapper',
                    'chartWidth'                            => 600,
                    'chartHeight'                           => 400,
                    'xAxisTitleText'                        => 'Sprint',
                    'xAxisCategories'                       => $sprints,
                    'yAxisTitleText'                        => 'Storypoints',
                    'enableAutoStep'                        => FALSE,
                    'creditsEnabled'                        => FALSE
                )
            );

            $series  = $this->HighCharts->addChartSeries();
            $series2 = $this->HighCharts->addChartSeries();
            $series3 = $this->HighCharts->addChartSeries();

            $series ->addName('Real Velocity')  ->addData($chartPoints);
            $series2->addName('Velocity')       ->addData($chartRealPoints);
            $series3->addName('Team Strength')  ->addData($chartStrength);
            $series3->type = 'column';

            $mychart->addSeries($series);
            $mychart->addSeries($series2);
            $mychart->addSeries($series3);

            $seriesPc  = $this->HighCharts->addChartSeries();

            $seriesPc->addName('Average points per day')->addData($chartAvgPointsPerDay);

            $percentageChart->addSeries($seriesPc);
        }
        catch (exception $e) {
            $this->Session->setFlash($e);
        }
    }

    public function logout() {
        $this->layout = null;
        CakeSession::destroy('token');
        $this->redirect('/');
    }
}

?>