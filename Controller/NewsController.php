<?php
App::uses('AppController', 'Controller');

class NewsController extends AppController {

    public function admin_index(){
        $this->News->recursive = 0;
        $users = $this->News->AdminUser->find('list');
        $this->set('news', $this->paginate());
        $this->set(compact('users', 'options'));
    }

    public function admin_add(){
        //$options = $this->Story->getCategories;
        if($this->request->is('Post')){
            $this->News->create();
            if($this->News->save($this->request->data)){
                $this->flashMessage(__d('news', 'Success! News was created'), 'alert-success', array('action' => 'index'));
            }else{
                $this->flashMessage(__d('news', 'Error creating story.  Please try again'), 'alert-error');
            }
        }
    }

    /**
     * Shows a News in admin
     *
     * @param int $id News id
     * @return void
     */
    public function admin_view($id = null) {
        $this->News->id = $id;
        if (!$this->News->exists()) {
            $this->Session->setFlash('This News does not appear to exist sorry');
            $this->redirect($this->referer());
        }else{
            $news = $this->News->find('first', array('recursive' => 0, 'conditions' => array('News.id' => $id)));
            $this->set(compact('news'));
            if($this->request->is('Post')) {
                $this->redirect(array('admin' => 'true', 'controller' => 'news', 'action' => 'index'));
            }
        }

    }


    /**
     * Deletes a News in admin
     *
     * @param int $id News id
     * @return void
     */
    public function admin_delete($id = null){
        if ($this->News->delete($id, true)) {
            $this->flashMessage(__d('news', 'The News has been deleted'), 'alert-success', array('action' => 'index'));
        } else {
            $this->flashMessage('Invalid News.', 'alert-error', array('action' => 'index'));
        }
    }

    /**
     * Edit a News in admin
     *
     * @param int $id News id
     * @return void
     */
    public function admin_edit($id = null) {
        $news = $this->News->find('first', array('conditions' => array('News.id' => $id), 'recursive' => '-1'));
        if ($this->request->is('Post')) {
            if($news){
                $this->News->id = $id;
                if ($this->News->save($this->request->data)) {
                    $this->flashMessage(__d('news', 'The News has been updated'), 'alert-success', array('action' => 'index'));
                }
            }else{
                $this->flashMessage('Invalid Story.', 'alert-error', array('action' => 'index'));
            }
        }
        $this->set(compact('news'));
    }

}