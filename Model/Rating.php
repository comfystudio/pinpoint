<?php
App::uses('AppModel', 'Model');
/**
 * Rating Model
 *
 * @property Rating $Rating
 */

class Rating extends AppModel {

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
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        )
    );

    /**
     * getAverageRating associations
     *
     * @returns Int or String
     *
     */
    public function getAverageRating($story_id = null){
        $total = 0;
        $ratings = $this->find('list', array('fields' => array('score'), 'conditions' => array('Rating.story_id' => $story_id)));
        if(!empty($ratings) && $ratings != NULL) {
            $count = count($ratings);
            foreach ($ratings as $rating) {
                $total += $rating;
            }
            return round($total / $count);
        }else{
            return "No Ratings";
        }
    }

}
