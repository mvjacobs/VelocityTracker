<?php
App::uses('Pivotal', 'Model');

class Project extends Pivotal {

    /**
     * getAllProjects method
     *
     * @access publix
     * @return array (of projects)
     */
    public function getAllProjects() {
        $this->path = '/projects';

        $projects = $this->find('all');

        return $projects['projects']['project'];
    }

    /**
     *
     */
    public function getProject($projectId) {
        $this->path = '/projects/'.$projectId;

        return $this->find('all');
    }

    public function getIterations($projectId) {
        $this->path = '/projects/'.$projectId.'/iterations/done';

        return $this->find('all');
    }
}
?>
