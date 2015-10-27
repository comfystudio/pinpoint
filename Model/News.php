<?php
App::uses('AppModel', 'Model');
/**
 * News Model
 *
 * @property News $News
 */

class News extends AppModel {

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
        ),
        'text' => array(
            'notempty' => array(
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
     * hasMany associations
     *
     * @var array
     */

}
