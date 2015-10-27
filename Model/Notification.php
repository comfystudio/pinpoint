<?php
App::uses('AppModel', 'Model');
/**
 * Notification Model
 *
 * @property Notification $Notification
 */

class Notification extends AppModel {

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
        'User',
        'Comment'
    );


    /**
     * hasMany associations
     *
     * @var array
     */


}
