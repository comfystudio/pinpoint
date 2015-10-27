<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function admin_index(){
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * Shows a User in admin
     *
     * @param int $id User id
     * @return void
     */
    public function admin_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('This User does not appear to exist sorry');
            $this->redirect($this->referer());
        }else{
            $contain = array(
                'Comment' => array(
                    'fields' => array(
                        'id', 'comment'
                    )
                ),
                'Rating' => array(
                    'fields' => array(
                        'id', 'score', 'story_id'
                    ),
                    'Story' => array(
                        'fields' => array(
                            'id', 'title'
                        )
                    )
                )
            );
            $user = $this->User->find('first', array('contain' => $contain, 'conditions' => array('User.id' => $id)));
            $this->set(compact('user'));
            if($this->request->is('Post')) {
                $this->redirect(array('admin' => 'true', 'controller' => 'users', 'action' => 'index'));
            }
        }

    }


    /**
     * Deletes a User in admin
     *
     * @param int $id User id
     * @return void
     */
    public function admin_delete($id = null){
        if ($this->User->delete($id, true)) {
            $this->flashMessage(__d('users', 'The User has been deleted'), 'alert-success', array('action' => 'index'));
        } else {
            $this->flashMessage('Invalid News.', 'alert-error', array('action' => 'index'));
        }
    }

    /**
     * Edit a User in admin
     *
     * @param int $id User id
     * @return void
     */
    public function admin_edit($id = null) {
        $contain = array(
            'Comment' => array(
                'fields' => array(
                    'id', 'comment', 'user_id', 'story_id', 'reply_id'
                )
            ),
        );
        $user = $this->User->find('first', array('contain' => $contain, 'conditions' => array('User.id' => $id), 'recursive' => '-1'));
        if ($this->request->is('Post')) {
            if($user){
                $this->User->id = $id;
                if ($this->User->save($this->request->data)) {
                    if(!empty($this->request->data['Comment']) && $this->request->data['Comment'] != NULL){
                        foreach($this->request->data['Comment'] as $comment['Comment']){
                            $this->User->Comment->id = $comment['Comment']['id'];
                            $this->User->Comment->saveField('comment', $comment['Comment']['comment']);
                        }
                    }
                    $this->flashMessage(__d('user', 'The User has been updated'), 'alert-success', array('action' => 'index'));
                }
            }else{
                $this->flashMessage('Invalid Story.', 'alert-error', array('action' => 'index'));
            }
        }
        $this->set(compact('user'));
    }

}