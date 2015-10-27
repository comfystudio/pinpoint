<?php
App::uses('AppModel', 'Model');
/**
 * Story Model
 *
 * @property Story $Story
 */

class Story extends AppModel {

    /**
     * $virtualFields field
     *
     * @var string
     */
    public $virtualFields = array(
        //'name' => 'CONCAT(User.first_name, " ", User.last_name)'
        //'rating' => 'SELECT AVG(score) AS scoreAverage FROM ratings WHERE story_id = {$__cakeID__$}'
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'title cannot be empty',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'title already taken'
            ),
        ),
        'tag_line' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'tag line cannot be empty',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'tag line already taken'
            ),
        ),
        'story' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'story cannot be empty',
            ),
        ),
        'lat' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'lat cannot be empty',
            ),
        ),
        'long' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'long cannot be empty',

            ),
        ),
        'date' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'date cannot be empty',
            ),
        ),


    );


    /**
     * actAs associations
     *
     * @var array
     */
    var $actsAs = array(
        'UploadPack.Upload' => array(
            'image' => array(
                'styles' => array(
                    'thumb' => '80x80',
                    'normal' => '300x300'
                )
            )
        )
    );


    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'AdminUser' => array(
            'className' => 'AdminUser',
            'foreignKey' => 'adminuser_id',
        ),

    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Rating' => array(
            'className' => 'Rating',
            'foreignKey' => 'story_id',
            'dependant' => true
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'story_id',
            'dependant' => true
        ),
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Tag' =>
            array(
                'className' => 'Tag',
                'joinTable' => 'story_tags',
                'foreignKey' => 'story_id',
                'associationForeignKey' => 'tag_id',
            )
    );

    /**
     * getCategories associations
     *
     * @var array
     */
    public $getCategories = array(
        0 => 'Horror', 1 => 'Murder', 2 => 'Romance', 3 => 'Super Natural'
    );
}
