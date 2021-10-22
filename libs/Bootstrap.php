<?php
class Bootstrap 
{
    private $_url = null;
    private $_controller = null;
    private $_controllerPath = 'controllers/';
    private $_modelPath = 'models/';
    private $_errorFile = 'error.php';
    private $_defaultFile = 'index.php';

    public function init()
    {
        $this->_getUrl();
        
        if(empty($this->_url[0]))
        {
            $this->_loadDefaultController();
            return false;
        }

        $this->_loadExistingController();
        $this->_CallControllerMethod();

    }

    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path,'/').'/';
    }

    public function setModelPath($path)
    {
        $this->_modelPath = trim($path,'/').'/';
    }

    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path,'/');
    }

    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path,'/');
    }

    private function _getUrl()
    {
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $url = rtrim($url,"/");
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode("/",$url);
    }

    private function _loadDefaultController(){

        require $this->_controllerPath .$this->_defaultFile;
        $this->_controller = new Index();
        $this->_controller -> index();
    }

    private function _loadExistingController()
    {
        $file = $this->_controllerPath.$this->_url[0].".php";

        if(file_exists($file))
        {
            require $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0],$this->_modelPath);            
        }else{
            $this->_err();
            return false;
        }
    }

    private function _CallControllerMethod()
    {
        $length = count($this->_url);
        if($length>1)
        {
            if(!method_exists($this->_controller,$this->_url[1]))
            {
                $this->_err();
            }
        }
        switch($length)
        {
            case 5:
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3],$this->_url[4]);
                break;
            case 4:
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            case 3:
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            case 2:
                $this->_controller->{$this->_url[1]}();
            break;
            default:
                $this->_controller->index();
                break;            
        }
    }

    private function _err()
    {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new er();
        $this->_controller->index();
        exit;
    }
}