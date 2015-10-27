<?php
App::uses('AppModel', 'Model');
/**
 * Tag Model
 *
 * @property Tag $Tag
 */

class Tag extends AppModel {

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
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'title cannot be empty',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'username already taken'
            ),
        ),
        'text' => array(
            'text' => array(
                'rule' => array('notempty'),
                'message' => 'text cannot be empty',
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
            'dependant' => true
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Story' =>
            array(
                'className' => 'Story',
                'joinTable' => 'story_tags',
                'foreignKey' => 'tag_id',
                'associationForeignKey' => 'story_id',
            )
    );

}
