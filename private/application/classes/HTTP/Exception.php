<?php

class HTTP_Exception extends Kohana_HTTP_Exception
{

    /**
     * Generate a Response for all Exceptions without a more specific override
     *
     * The user should see a nice error page, however, if we are in development
     * mode we should show the normal Kohana error page.
     *
     * @return Response
     */
    public function get_response()
    {
        // Lets log the Exception, Just in case it's important!
        Kohana_Exception::log($this);

        if (Kohana::$environment >= Kohana::DEVELOPMENT)
        {
            // Show the normal Kohana error page.
            return parent::get_response();
        }
        else
        {
            $mainView   = View::factory('Error/Default', array('code' => $this->_code));
            $mainLayout = View::factory('Layout/Main', array(
                'styles'  => array(),
                'scripts' => array(),
                'title'   => __('Error') . ' ' . $this->_code,
                'content' => $mainView,
            ));

            $response = Response::factory()
                                ->status($this->getCode())
                                ->body($mainLayout->render());

            return $response;
        }
    }
}