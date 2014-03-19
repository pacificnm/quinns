<?php
class Report_Form_Element_Employee extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Service Tech:');
		
		$employeeModel = new Employee_Model_Employee();
		$employees = $employeeModel->loadAllActive(1);
		$this->addMultiOption('', 'All');
		foreach($employees as $employee) {
			$this->addMultiOption($employee->employee_id, $employee->first_name . ' ' . $employee->last_name);
		}
	}
}