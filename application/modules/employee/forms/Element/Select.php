<?php
class Employee_Form_Element_Select extends Zend_Form_Element_Select
{
	public function init()
	{
		$employeeModel = new Employee_Model_Employee();
		$employees = $employeeModel->loadAllActive();
		
		$this->setLabel('Employee:');
		
		foreach($employees as $employee) {
			$this->addMultiOption($employee->employee_id, $employee->first_name . ' ' . $employee->last_name);
		}
		
	}
}