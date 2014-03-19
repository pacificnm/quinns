<?php
class PumpTest_Form_Element_Employee extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Employee');

		$employeeModel = new Employee_Model_Employee();
		$employees = $employeeModel->loadAllActive(1);

		foreach($employees as $employee) {
			$this->addMultiOption($employee->employee_id, $employee->first_name . ' ' . $employee->last_name);
		}
	}
}