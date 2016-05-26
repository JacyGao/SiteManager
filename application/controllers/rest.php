<?

class rest extends CI_Controller
{

    // List objects
    function handler()
    {
        $model = $this->uri->segment(2);
        $method = $this->uri->segment(3);

        switch($_SERVER['REQUEST_METHOD'])
        {

        }
    }

}