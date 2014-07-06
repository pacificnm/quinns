<?php
class Service_Form_Element_EndTime extends Zend_Form_Element_Xhtml
{
    protected $_dateFormat = '%hour%-%min%-%day% ';
    protected $_hour;
    protected $_min;
	protected $_time;
	
    public function __construct($spec, $options = null)
    {
        $this->addPrefixPath(
                'Service_Form_Decorator',
                APPLICATION_PATH . '/modules/service/forms/Decorator',
                'decorator'
        );
        parent::__construct($spec, $options);
    }

    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('EndTime')
            ->addDecorator('Errors')
            ->addDecorator('Description', array(
                    'tag' => 'p',
                    'class' => 'description')
            )
            ->addDecorator('HtmlTag', array(
                    'tag' => 'dd',
                    'id'  => $this->getName() . '-element')
            )
            ->addDecorator('Label', array('tag' => 'dt'));
        }
    }

    public function setHour($value)
    {
        $this->_hour = (int) $value;
        return $this;
    }

    public function getHour()
    {
        return $this->_hour;
    }

    public function setMin($value)
    {
        $this->_min = (int) $value;
        return $this;
    }

    public function getMin()
    {
        return $this->_min;
    }

    public function getTime()
    {
    	return $this->_time;
    }
    
    public function setValue($value)
    {   
        if($value > 0 ) {       
        	$this->setHour(date("h", $value));
        	$this->setMin(date("i", $value));
        	$this->setTime($value);
        }
        return $this;
    }

    public function setTime($value) {
    	$this->_time = (int) $value;	
    }
    
   
}