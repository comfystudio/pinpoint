<?php
App::uses('AppController', 'Controller');

class StoriesController extends AppController {

    public function admin_index(){
        $this->Story->recursive = -1;
        $options = $this->Story->getCategories;
        $users = $this->Story->AdminUser->find('list');
        $stories = $this->paginate();
        foreach($stories as $key => $story){
            $stories[$key]['Story']['averageRating'] = $this->Story->Rating->getAverageRating($story['Story']['id']);
        }
        //$this->set('stories', $stories);
        $this->set(compact('users', 'options', 'stories'));
    }

    public function admin_add(){
        $options = $this->Story->getCategories;
        $tags = $this->Story->Tag->find('list', array('recursive' => -1));
        if($this->request->is('Post')){
            $this->Story->create();
            if($this->Story->saveAll($this->request->data, array('deep' => true))){
                $this->flashMessage(__d('stories', 'Success! Story was created'), 'alert-success', array('action' => 'index'));
            }else{
                $this->flashMessage(__d('stories', 'Error creating story.  Please try again'), 'alert-error');
            }
        }
        $this->set(compact('options', 'tags'));
    }

    /**
     * Shows a story in admin
     *
     * @param int $id Story id
     * @return void
     */
    public function admin_view($id = null) {
        $options = $this->Story->getCategories;
        $tags = $this->Story->Tag->find('list', array('recursive' => -1));
        $selectedTags = $this->Story->StoryTag->find('list', array('fields' => 'tag_id', 'conditions' => array('StoryTag.story_id' => $id), 'recursive' => -1));
        $this->Story->id = $id;
        if (!$this->Story->exists()) {
            $this->Session->setFlash('This Story does not appear to exist sorry');
            $this->redirect($this->referer());
        }else{
            $story = $this->Story->find('first', array('recursive' => 0, 'conditions' => array('Story.id' => $id)));
            $this->set(compact('story', 'options'));
            if($this->request->is('Post')) {
                $this->redirect(array('admin' => 'true', 'controller' => 'stories', 'action' => 'index'));
            }
        }
        $this->set(compact('tags', 'selectedTags'));

    }


    /**
     * Deletes a story in admin
     *
     * @param int $id Story id
     * @return void
     */
    public function admin_delete($id = null){
        if ($this->Story->delete($id, true)) {
            $this->flashMessage(__d('stories', 'The Story has been deleted'), 'alert-success', array('action' => 'index'));
        } else {
            $this->flashMessage('Invalid Story.', 'alert-error', array('action' => 'index'));
        }
    }

    /**
     * Edit a story in admin
     *
     * @param int $id Story id
     * @return void
     */
    public function admin_edit($id = null) {
        $story = $this->Story->find('first', array('conditions' => array('Story.id' => $id), 'recursive' => -1));
        $tags = $this->Story->Tag->find('list', array('recursive' => -1));
        $selectedTags = $this->Story->StoryTag->find('list', array('fields' => 'tag_id', 'conditions' => array('StoryTag.story_id' => $id), 'recursive' => -1));
        $options = $this->Story->getCategories;
        if ($this->request->is('Post')) {
            if($story){
                $this->Story->id = $id;
                if ($this->Story->saveAll($this->request->data, array('deep' => true))) {

                    $this->flashMessage(__d('stories', 'The Story has been updated'), 'alert-success', array('action' => 'index'));
                }
            }else{
                $this->flashMessage('Invalid Story.', 'alert-error', array('action' => 'index'));
            }
        }
        $this->set(compact('options', 'story', 'tags', 'selectedTags'));
    }

}