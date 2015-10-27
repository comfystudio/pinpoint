<?php
App::uses('AppModel', 'Model');
/**
 * Comment Model
 *
 * @property Comment $Comment
 */

class Comment extends AppModel {

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
        'comment' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'comment cannot be empty',
            ),
            'alphanumeric' => array(
                'rule' => 'alphanumeric',
                'message' => 'username must be letters and numbers only'
            )
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            //'dependant' => true
        ),
        'Story' => array(
           'className' => 'Story',
            'foreignKey' => 'story_id',
            //'dependant' => true
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */

}
