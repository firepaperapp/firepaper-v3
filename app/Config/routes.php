<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	// Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	// Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));


Configure::write('Routing.prefixes', array('school'));

Router::connect('/', array('controller' => 'home', 'action' => 'display'));
Router::connect('/signup/step1/*', array('controller' => 'users', 'action' => 'step1'));
Router::connect('/signup/step2', array('controller' => 'users', 'action' => 'step2'));
Router::connect('/accounts/dashboard', array('controller' => 'users', 'action' => 'dashboard'));
Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/forgotpassword', array('controller' => 'users', 'action' => 'forgotpassword'));
Router::connect('/educators', array('controller' => 'dashboard', 'action' => 'educators'));
// Router::connect('/yeargroups', array('controller' => 'dashboard', 'action' => 'yeargroups'));
Router::connect('/departments', array('controller' => 'dashboard', 'action' => 'departments'));
Router::connect('/listTeachers/*', array('controller' => 'dashboard', 'action' => 'listTeachers'));
Router::connect('/projects/draftProjects/*', array('controller' => 'projects', 'action' => 'archivedProjects'));
Router::connect('/projects/viewProjects/*', array('controller' => 'projects', 'action' => 'index'));
Router::connect('/whiteboard/:id', array('controller' => 'whiteboards','action' => 'viewWhiteboard'), array('pass'=>array('id')));
Router::connect("/school/:controller/:action/*", array('controller' => 'users', 'action' => 'dashboard','prefix' => $prefix, $prefix => true));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
