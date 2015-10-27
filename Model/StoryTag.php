<?php
App::uses('AppModel', 'Model');
/**
 * Storytag Model
 *
 * @property StoryTag $StoryTag
 */

class StoryTag extends AppModel {

    /**
     * Display field
     *
     * @var string
     */

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(

    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Story' => array(
            'className' => 'Story',
            'foreignKey' => 'story_id',
            'dependant' => true
        ),
        'Tag' => array(
            'className' => 'Tag',
            'foreignKey' => 'tag_id',
            'dependant' => true
        )
    );

}
