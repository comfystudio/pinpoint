<?php
App::uses('AppController', 'Controller');

class TagsController extends AppController {

    public function admin_index(){
        $this->Tag->recursive = 0;
        $users = $this->Tag->AdminUser->find('list');
        $this->set('tags', $this->paginate());
        $this->set(compact('users'));
    }

    /**
     * Shows a Tag in admin
     *
     * @param int $id Tag id
     * @return void
     */
    public function admin_add(){
        if($this->request->is('Post')){
            $this->Tag->create();
            if($this->Tag->save($this->request->data)){
                $this->flashMessage(__d('tags', 'Success! Tag was created'), 'alert-success', array('action' => 'index'));
            }else{
                $this->flashMessage(__d('tags', 'Error creating story.  Please try again'), 'alert-error');
            }
        }
    }

    /**
     * Shows a Tag in admin
     *
     * @param int $id Tag id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            $this->Session->setFlash('This Tag does not appear to exist sorry');
            $this->redirect($this->referer());
        }else{
            $tag = $this->Tag->find('first', array('recursive' => 0, 'conditions' => array('Tag.id' => $id)));
            $this->set(compact('tag'));
            if($this->request->is('Post')) {
                $this->redirect(array('admin' => 'true', 'controller' => 'tags', 'action' => 'index'));
            }
        }

    }


    /**
     * Deletes a Tag in admin
     *
     * @param int $id Tag id
     * @return void
     */
    public function admin_delete($id = null){
        if ($this->Tag->delete($id, true)) {
            $this->flashMessage(__d('tags', 'The Tag has been deleted'), 'alert-success', array('action' => 'index'));
        } else {
            $this->flashMessage('Invalid News.', 'alert-error', array('action' => 'index'));
        }
    }

    /**
     * Edit a Tag in admin
     *
     * @param int $id Tag id
     * @return void
     */
    public function admin_edit($id = null) {
        $tag = $this->Tag->find('first', array('conditions' => array('Tag.id' => $id), 'recursive' => '-1'));
        if ($this->request->is('Post')) {
            if($tag){
                $this->Tag->id = $id;
                if ($this->Tag->save($this->request->data)) {
                    $this->flashMessage(__d('tag', 'The Tag has been updated'), 'alert-success', array('action' => 'index'));
                }
            }else{
                $this->flashMessage('Invalid Story.', 'alert-error', array('action' => 'index'));
            }
        }
        $this->set(compact('tag'));
    }

}