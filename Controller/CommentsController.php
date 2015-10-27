<?php
App::uses('AppController', 'Controller');

class CommentsController extends AppController {

    /**
     * Deletes a Comments in admin
     *
     * @param int $id Comments id
     * @return void
     */
    public function admin_delete($id = null, $user_id = null){
        if ($this->Comment->delete($id, true)) {
            $this->flashMessage(__d('comments', 'The Comment has been deleted'), 'alert-success', array('controller' => 'users', 'admin' => 'true', 'action' => 'edit', $user_id));
        } else {
            $this->flashMessage('Invalid News.', 'alert-error', array('action' => 'index'));
        }
    }


}