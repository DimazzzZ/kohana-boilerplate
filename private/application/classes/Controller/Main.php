<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template
{
    /**
     * @var  View
     */
    public $template = 'Layout/Main';

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var Breadcrumbs
     */
    protected $bc;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var ACL
     */
    protected $acl;

    public function before()
    {
        // Set Cross-origin resource sharing
        $this->response->headers('Access-Control-Allow-Origin', URL::base(true));

//        $this->auth    = Auth::instance();
        $this->session = Session::instance();
        $this->bc      = Breadcrumbs::instance();
        $this->cache   = Cache::instance();
        $this->acl     = ACL::instance();

//        if ($this->auth->logged_in())
//        {
//            $this->template = 'Layout/Main';
//        }

        parent::before();

        $this->template->title   = __('Site title');
        $this->template->content = null;

        $this->template->styles  = array();
        $this->template->scripts = array();

        $this->template->containerClass = 'container';

        $this->bc->addItem('<i class="home icon"></i>' . __('Home'), Route::url('default', array(
            'controller' => 'main',
        )));

        // ACL
        $allow = false;

        $controller = strtolower($this->request->controller());
        $action     = $this->request->action();

//        if (!$this->auth->logged_in() && $controller != 'auth')
//        {
//            $this->redirect('/auth');
//        }

//        if ($this->auth->logged_in())
//        {
//            foreach ($this->auth->get_user()->roles->find_all() as $role)
//            {
//                $allow = $this->acl->is_allowed($role->name, $controller, $action);
//            }
//        }
//        else
//        {
//            $allow = $this->acl->is_allowed('guest', $controller, $action);
//        }

        if (!$allow)
        {
            throw new HTTP_Exception_403;
        }
    }

    public function after()
    {
        $this->template->breadcrumbs = $this->bc->render();
        parent::after();
    }

    public function action_index()
    {
        $data                    = array();
        $this->template->content = View::factory('Main/Index', $data);
    }
}
