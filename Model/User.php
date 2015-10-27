<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property User $User
 */

class User extends AppModel {

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
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'username cannot be empty',
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'username already taken'
            ),
            'alphanumeric' => array(
                'rule' => 'alphanumeric',
                'message' => 'username must be letters and numbers only'
            )
        ),
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'password cannot be empty',
            ),
            'between' => array(
                'rule' => array('between', 5, 100),
                'message' => 'password must be between 5 and 100 characters'
            ),
            'alphanumeric' => array(
                'rule' => 'alphanumeric',
                'message' => 'password must be letters and numbers only'
            )
        ),
        'email' => array(
            'email' => array(
                'rule' => 'email',
                'message' => 'Must supply a valid email'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'email already taken'
            ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */


    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Comment'=> array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
        'Rating' => array(
            'className' => 'Rating',
            'foreignKey' => 'user_id',
            'dependant' => true
        ),
        'Notification' => array(
            'className' => 'Notification',
            'foreignKey' => 'user_id',
            'dependant' => true
        ),
    );

}
