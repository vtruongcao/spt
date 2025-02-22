<?php
/**
 * SPT software - User Adapter
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: User just once time
 * Write this to easily imagine how the user should be
 * 
 */

namespace SPT\User;

use SPT\ConfigurableDI;

class Base extends ConfigurableDI
{
    protected $session;
    protected $data;

    public function init($options)
    {
        parent::init($options);

        $storage = $this->getContext();
        $this->data = (array) $this->session->get( $storage );
        
        if( empty($this->data) )
        {
            $this->data = $this->getDefault();
        }
    }

    public function getMutableFields(): array
    {
        return [
            'session' => '\SPT\Session\Instance'
        ];
    }

    public function getDefault()
    {
        return [
            'id' => 0,
            'username' => 'guest',
            'fullname' => 'A Guest',
            'email' => '',
            'groups' => ['guest'],
            'permission' => [],
            'created_at' => date('Y-m-d H:i:s')
        ];
    }

    public function is(string $group)
    {
        return is_array($this->data['groups']) ? in_array($group, $this->data['groups']) : false;
    }

    public function can(string $permission)
    {
        return is_array($this->data['permission']) ? in_array($permission, $this->data['permission']) : false;
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
        $storage = $this->getContext();
        $this->session->set($storage, $this->data);
    }

    public function get(string $key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    public function reset()
    {
        $this->data = $this->getDefault();
        $storage = $this->getContext();
        $this->session->set($storage, $this->data);
        $this->session->reload('guest', 0);
    }
}
