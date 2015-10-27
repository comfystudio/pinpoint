<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	 public $helpers = array(
        'Html',
        'Form',
        'Paginator',
        'Session'
    );
	
	 public $components = array(
        'Auth' => array('authenticate' => 'BcryptForm'),
        'Paginator',
        'RequestHandler',
        'Session',
       	//'DebugKit.Toolbar'
	);
	
	/**
     *  Checks the provided prefix is a routing prefix specified in the core.
     *  Also checks the logged in users role is acceptable.
     *
     *  @return boolean
     */
    public function isAuthorized() {
        $role = $this->Auth->user('role'); 
        $neededRole = null; 
        $prefix = !empty($this->request->params['prefix']) ? $this->request->params['prefix'] : null;
        if (!empty($prefix) && in_array($prefix, Configure::read('Routing.prefixes')) ){
            $neededRole = $prefix;
        }
        return (
            empty($neededRole) || 
            strcasecmp($role, 'admin') == 0 || 
            strcasecmp($role, 'moderator') == 0 || 
            strcasecmp($role, $neededRole) == 0
        );
    }
		
	public function beforeFilter() {
		parent::beforeFilter();
		
		 /* Setting Auth component options. */
		$this->Auth->authError = 'Please login to gain access to this area.';
		$this->Auth->loginRedirect = array('plugin' => 'users', 'controller' => 'users', 'action' => 'dashboard');
		$this->Auth->loginAction = array('plugin' => 'users', 'controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->flash = array('element' => 'notifications/default', 'key' => 'auth', 'params' => array('class' => 'alert-error'));
		
		  /* Setting up a custom detector for the admin section. */
		$this->request->addDetector('admin', array('callback' => function($request){
			return isset($request->params['prefix']) && $request->params['prefix'] == 'admin';
		}));
		
		if ($this->request->is('admin')) {
		
			Configure::write('isAdminRoute', true);	// quick hack to allow prefix detection inside models
		
			// build list of locales for selector view
		   // $this->set('hostlocale_choices', Configure::read('hostlocale_choices'));
		
			// act upon an incoming POST from the CMS locale selector and set/remove session var
		if(!empty($this->request->data['localeselect'])) {
			 if($this->request->data['localeselect'] != 'all') {
					 $this->Session->write('cms_locale', $this->request->data['localeselect']);
			 } else {
					  $this->Session->delete('cms_locale');
			 }
		}
		if($this->Session->read('cms_locale')) Configure::write('cms_locale', $this->Session->read('cms_locale'));
		
			$this->layout = 'admin';
			// Use Twitter Bootstrap helpers for admin
			$this->helpers['Form'] = array('className' => 'BootstrapForm');
			$this->helpers['Html'] = array('className' => 'BootstrapHtml');
			$this->helpers['Paginator'] = array('className' => 'BootstrapPaginator');
		}
		
		// allow any non-admin requests, override this in your controller
		 if(!$this->request->is('admin')) {
			$this->Auth->allow();
		 }
	
	}
	
	 public function restoreLoginFromCookie() {
        $this->Cookie->name = 'Users';
        $cookie = $this->Cookie->read('rememberMe');
        if (!empty($cookie) && !$this->Auth->user()) {
            $data['User'][$this->Auth->fields['username']] = $cookie[$this->Auth->fields['username']];
            $data['User'][$this->Auth->fields['password']] = $cookie[$this->Auth->fields['password']];
            $this->Auth->login($data);
        }
    }
	
	/**
	 *	Sets up session flash message for view.
	 *
	 *	@param string $msg - The message to be displayed.
	 *	@param string $type - alert-success, alert-warning, alert-error or alert-info.
	 *	@param string $url - The url to redirect to.
	 *	@return bool exits
	 */
	public function flashMessage($msg, $type = 'alert-success', $url = null) {
		$this->Session->setFlash($msg, 'notifications/default', array('class' => $type));
		if (!empty($url)) {
			$this->redirect($url);
		}
	}
	
	/**
 *  Updates the sequence of files.
 *  Expects an ajax call and an id parameter to be passed via post.
 */
    public function admin_save_order($id) {
        if (!$this->request->is('post')
        || !$this->request->is('ajax')
        || !isset($this->data[$this->modelClass]['order'])) {
            throw new MethodNotAllowedException();
        }
        $this->{$this->modelClass}->id = $id;
        $response = $this->{$this->modelClass}->save($this->data, true, array('order'));
        $this->set(compact('response'));
        $this->render('/Elements/json_response');
    }

    /**
     *  Deletes a file via an ajax call.
     */
    public function admin_ajax_delete($id) {
        if (!$this->request->is('get')
        || !$this->request->is('ajax')
        || !$id) {
            throw new MethodNotAllowedException();
        }
        if ($this->{$this->modelClass}->delete($id)) {
            $response = 'Record deleted';
        } else {
            $response = 'Record not deleted';
        }
        $this->set(compact('response'));
        $this->render('/Elements/json_response');
    }

	/**
	 *	Reads the input stream then based on the requests content type,
	 *	either parses as a URL-encoded string, or decodes a JSON string.
	 *	This method was made for use in receiving PUT variables.
	 *
	 *	@return An associative array of variables.
	 */
	protected function _readInput() {
		$fh = fopen('php://input', 'r');
		$content = stream_get_contents($fh);
		fclose($fh);

		if (isset($_SERVER['CONTENT_TYPE'])) {
			if (strstr($_SERVER['CONTENT_TYPE'], 'application/json')) {
				return json_decode($content, true);
			} else {
				parse_str($content, $putVars);
				return $putVars;
			}
		} else {
			return array();
		}
	}


    /**
     * generate response for an invalid request method
     *
     * @return void
     */
    protected function _invalidRequestMethod() {
        $this->response->statusCode('400');

        // set the api errors
        $errors = $this->{$this->modelClass}->setApiError("apierror", __('Incorrect method'));

        $data = array(
            'status' => 'fail',
            'code' => 400,
            'message' => 'bad request',
            'data' => null,
            'errors' => $errors
        );
        $this->{$this->modelClass}->clearVar();
        return json_encode($data);
    }

    /**
     * generate response for an all requests
     *
     * @return void
     */
    protected function _responseMethod($status, $code, $message, $data, $errors) {
        $this->response->statusCode($code);
        // set the api errors
        //if($code > 201)
            //$errors = $this->{$this->modelClass}->setApiError("apierror", __($message));

        $data = array(
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        );
        $this->{$this->modelClass}->clearVar();
        return json_encode($data);
    }
}
