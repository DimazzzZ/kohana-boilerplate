<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template
{
    /**
     * @var  View
     */
    public $template = 'Layout/Intro';

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
        $this->response->headers('Access-Control-Allow-Origin', URL::base(true));

        $this->auth    = Auth::instance();
        $this->session = Session::instance();
        $this->bc      = Breadcrumbs::getInstance();
        $this->cache   = Cache::instance();
        $this->acl     = ACL::instance();

        if ($this->auth->logged_in())
        {
            $this->template = 'Layout/Main';
        }

        parent::before();

        $this->template->title   = __('Landing Control Panel');
        $this->template->content = null;

        $this->template->styles  = Helper_Template::getGlobalStyles();
        $this->template->scripts = Helper_Template::getGlobalScripts();

        $this->template->containerClass = 'container';

        $this->bc->addItem('<i class="home icon"></i>' . __('Home'), Route::url('default', array(
            'controller' => 'main',
        )));

        // ACL
        $allow = false;

        $controller = strtolower($this->request->controller());
        $action     = $this->request->action();

        if (!$this->auth->logged_in() && $controller != 'auth')
        {
            $this->redirect('/auth');
        }

        if ($this->auth->logged_in())
        {
            foreach ($this->auth->get_user()->roles->find_all() as $role)
            {
                $allow = $this->acl->is_allowed($role->name, $controller, $action);
            }
        }
        else
        {
            $allow = $this->acl->is_allowed('guest', $controller, $action);
        }

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
        $this->redirect(Route::url('default', array(
            'controller' => strtolower($this->request->controller()),
            'action'     => 'list',
        )));
    }

    public function action_list()
    {
        $this->redirect(Route::url('default', array(
            'controller' => 'campaign',
        )));
    }

    public function action_createJson()
    {
        $this->auto_render = false;

        try
        {
            $pk = ORM::factory(ucfirst($this->request->controller()))
                     ->values($this->request->post())
                     ->save()
                     ->pk();
        } catch (ORM_Validation_Exception $e)
        {
            echo json_encode(array(
                'result'  => false,
                'message' => null,
                'id'      => null,
            ));
            return;
        }

        echo json_encode(array(
            'result'  => true,
            'message' => null,
            'id'      => $pk,
        ));
    }

    public function action_delete()
    {
        $this->auto_render = false;

        try
        {
            $model = ORM::factory($this->request->controller(), $this->request->param('id'));

            $model->deleted = 1;
            $model->save();

            Helper_Log::Write(strtolower($this->request->controller()) . 'Delete', $this->request->param('id'), array(
                'name' => $model->name
            ));
        } catch (ORM_Validation_Exception $e)
        {
            echo json_encode(array(
                'result'  => false,
                'message' => $e->getMessage()
            ));
            return;
        }
        echo json_encode(array('result' => true));
    }

    protected function titlePrepend($title)
    {
        $this->template->title = $title . ' - ' . $this->template->title;
    }
}
