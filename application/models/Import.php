<?php

class Application_Model_Import
{

    public function __construct ()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '1600M');
        
        // Import Location
        // $this->importLocation();
        
        // imnport location note
        // $this->importLocationNotes();
        
        // import rentor
        //$this->importRenter();
        
        // import owner
        //$this->importOwner();
        
        // import pump
        //$this->importPump();
        
        // import tank
        //$this->importTank();
        
        // import services
        //$this->importService();
        
        // import service dates
        //$this->importServiceDate();

        // import pump test
        //$this->importPumpTest();
        
        // import pumptest data
        //$this->importPumpTestData();
        
        // import pump type data
        //$this->importPumpTypes();
        
        // import tank types
        //$this->importTankTypes();
        
        // import lat lon and driving directions
        //$this->importDirections();
        
        //$this->importSearch();
        
        //$this->run();
        
        
    }

    
    public function run()
    {
        $this->importLocation();
        $this->importLocationNotes();
        $this->importRenter();
        $this->importOwner();
        $this->importPump();
        $this->importTank();
        $this->importService();
        $this->importServiceDate();
        $this->importPumpTest();
        $this->importPumpTestData();
        $this->importSearch();
    }
    
    /**
     * Fixed
     */
    public function importLocation ()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        // load all pumpdata
        $wellModel = new Well_Model_Well();
        $oldWellData = $wellModel->loadOldData();
        foreach ($oldWellData as $well) {
            
            $street = ucwords(strtolower($well->Address));
            $street2 = '';
            $city = ucwords(strtolower($well->City));
            $state = ucwords(strtolower($well->State));
            $zip = $well->Zip;
            $recordId = $well->Record_Id;
            $status = 1;
            
            $billingStreet = ucwords(strtolower($well->BillingAddress));
            $billingCity = ucwords(strtolower($well->BillingCity));
            $billingState = ucwords(strtolower($well->BillingState));
            $billingZip = $well->BillingZip;
            
            $LocationModelLocation = new Location_Model_Location();
            $check = $LocationModelLocation->loadByOldId($recordId);
            
            // do some test and fixs
            if (empty($street))
                $street = $billingStreet;
            if (empty($city))
                $city = $billingCity;
            if (empty($state))
                $state = $billingState;
            if (empty($zip))
                $zip = $billingZip;
            
            if (empty($check)) {
                if (! empty($street)) {
                    // last chance check for correct address
                    if (empty($city))
                        $city = 'Grants Pass';
                    if (empty($state))
                        $state = 'Oregon';
                    if (empty($zip))
                        $zip = '97526';
                        
                        // create
                    $locationId = $LocationModelLocation->create($street, 
                            $street2, $city, $state, $zip, $billingStreet, 
                            $billingCity, $billingState, $billingZip, $status, 
                            $recordId);
                    echo 'Created location ' . $locationId . '<br>';
                } else {
                    // log missing data
                    $stream = @fopen(
                            APPLICATION_PATH . '/log/failed-location.txt', 'a', 
                            false);
                    if (! $stream) {
                        throw new Exception('Failed to open stream');
                    }
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->info($recordId . ' Has no street address.');
                }
            } else {
                echo 'Skipping record ' . $recordId . ' already have it<br>';
            }
            
            @ob_end_flush();
            @flush();
        }
        echo '</body></html>';
    }

    /**
     * Fixed
     */
    public function importLocationNotes ()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        $LocationModelLocationNote = new Location_Model_LocationNote();
        $LocationModelLocation = new Location_Model_Location();
        $WellModelWell = new Well_Model_Well();
        
        $locations = $LocationModelLocation->loadAll();
        foreach ($locations as $location) {
            @ob_end_clean();
            ob_start();
            // check if we already have data
            $check = $LocationModelLocationNote->loadByLocation($location->id);
            
            if (empty($check)) {
                // load old information
                $oldData = $WellModelWell->loadByid($location->old_id);
                
                $directions = ucfirst(strtolower($oldData->Directions));
                $note = ucfirst(strtolower($oldData->Notes));
                $access = ucfirst(strtolower($oldData->Access));
                if (empty($access))
                    $access = 'Unknown';
                
                if (! empty($oldData->BoomTruckNeeded)) {
                    $boomTruck = 1;
                } else {
                    $boomTruck = 0;
                }
                
                if (! empty($oldData->Dog)) {
                    $dog = 1;
                } else {
                    $dog = 0;
                }
                
                $men = (int) $oldData->MenNeeded;
                if (! empty($men)) {
                    $men = $men;
                } else {
                    $men = 1;
                }
                $explanation = ucfirst(strtolower($oldData->ManNeededExplain));
                
                $LocationModelLocationNote->create($location->id, $directions, 
                        $note, $access, $boomTruck, $dog, $men, $explanation, 
                        $oldData->Record_Id);
                
                echo 'Created location note for location ' . $location->id .
                         '<br>';
                @ob_end_flush();
                @flush();
            } else {
                echo 'Skipping we already have a note for location ' .
                         $location->id . '<br>';
                @ob_end_flush();
                @flush();
            }
            @ob_end_flush();
            @flush();
        }
        @ob_end_flush();
        @flush();
        echo '</body></html>';
    }

    /**
     * fixed
     */
    public function importRenter ()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        $LocationModelLocation = new Location_Model_Location();
        
        $WellModelWell = new Well_Model_Well();
        
        $RenterModelRenter = new Renter_Model_Renter();
        
        $locations = $LocationModelLocation->loadAll();
        
        foreach ($locations as $location) {
            @ob_end_clean();
            ob_start();
            
            // check if we already have data
            $renter = $RenterModelRenter->loadByLocation($location->id);
            if (empty($renter)) {
                // load old data
                $oldData = $WellModelWell->loadByid($location->old_id);
                
                $name = ucwords(strtolower($oldData->RenterName));
                $phone = $oldData->RenterPhone;
                if (empty($phone))
                    $phone = 'Unknown';
                
                if (! empty($name)) {
                    $RenterModelRenter->create($location->id, $name, $phone, 
                            $oldData->Record_Id);
                    
                    echo 'Created renter for location ' . $location->id . '<br>';
                } else {
                    // log missing data
                    $stream = @fopen(APPLICATION_PATH . '/log/rentor.txt', 'a', 
                            false);
                    if (! $stream) {
                        throw new Exception('Failed to open stream');
                    }
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->info(
                            $oldData->Record_Id . ' Has no rentor information.');
                    echo 'Skipping no renter details for location ' .
                             $location->id . '<br>';
                }
            } else {
                echo 'Skipping we already have a rentor for location ' .
                         $location->id . '<br>';
            }
            @ob_end_flush();
            @flush();
        }
        
        @ob_end_flush();
        @flush();
        echo '</body></html>';
    }

    /**
     * Fixed
     */
    public function importOwner ()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        
        $LocationModelLocation = new Location_Model_Location();
        
        $WellModelWell = new Well_Model_Well();        
        $OwnerModelOwner = new Owner_Model_Owner();        
        $OwnerModelOwnerLocation = new Owner_Model_OwnerLocation();        
        $locations = $LocationModelLocation->loadAll();
        
        foreach ($locations as $location) {
            // load old data
            $oldData = $WellModelWell->loadByid($location->old_id);
            
            $name = ucwords(strtolower($oldData->Name));
            $street = ucwords(strtolower($oldData->BillingAddress));
            $city = ucwords(strtolower($oldData->BillingCity));
            $state = ucwords(strtolower($oldData->BillingState));
            $zip = $oldData->BillingZip;
            
            if(!empty($name)) {
 
                // check fields
                if (empty($street)) $street = ucwords(strtolower($oldData->Address));
                if (empty($city)) $city = ucwords(strtolower($oldData->City));
                if (empty($state)) $state = ucwords(strtolower($oldData->State));
                if (empty($zip)) $zip = $oldData->Zip;
                    
                    // set defaults
                if (empty($city)) $city = 'Grants Pass';
                if (empty($state)) $state = 'Oregon';
                if (empty($zip)) $zip = '97526';
                
                $phone = $oldData->Telephone;
                $email = $oldData->eMail;
                
                // check if we have an owner by name
                $checkOwner = $OwnerModelOwner->loadByOldId($oldData->Record_Id);
                if(empty($checkOwner)) {
                    $ownerId = $OwnerModelOwner->create($name, $street, $street2, $city, $state, 
                            $zip, $phone, $email, 1, $oldData->Record_Id);
                    echo 'Created owner for location ' . $location->id . '<br>';
                } else {
                    $ownerId = $checkOwner->id;
                }
           
                
                // check mapping
                $check = $OwnerModelOwnerLocation->loadByOwnerLocation($location->id, $ownerId);
                if(empty($check)) {
                    $OwnerModelOwnerLocation->create($location->id, $ownerId, 1);
                    echo 'Mapped owner to location ' . $location->id;
                } else {
                    echo 'Skipping already have this owner mapped<br>';
                }
                 @ob_end_flush();
                @flush();
            } else {
                
                // log missing data
                $stream = @fopen(APPLICATION_PATH . '/log/owner.txt', 'a',
                        false);
                if (! $stream) {
                    throw new Exception('Failed to open stream');
                }
                
                $writer = new Zend_Log_Writer_Stream($stream);
                $logger = new Zend_Log($writer);
                $logger->info( $oldData->Record_Id . ' Has no owner information.');
                echo 'No owner name skipping and logged<br>';
                 @ob_end_flush();
                @flush();
            }    
            @ob_end_flush();
            @flush();
        }
  
        echo '</body></html>';
    }

    /**
     * fixed
     */
    public function importPump()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        $WellModelWell = new Well_Model_Well();
        
        $PumpModelPump = new Pump_Model_Pump();
        
        $LocationModelLocation = new Location_Model_Location();
        
        $locations = $LocationModelLocation->loadAll();
        
        foreach($locations as $location) {
        
            $oldData = $WellModelWell->loadByid($location->old_id);
            
            // check if we already have pump
            $check = $PumpModelPump->loadByOldId($oldData->Record_Id);
            
            if(empty($check)) {
                $pumpModel 	= ucwords(strtolower($oldData->Pump));
                $pumpType 	= ucwords(strtolower($oldData->Type));
                $voltage 	= ucwords(strtolower($oldData->Voltage));
                $phase 		= ucwords(strtolower($oldData->Phase));
                $wire 		= ucwords(strtolower($oldData->Wire));
                $pipe 		= ucwords(strtolower($oldData->PipeType));
                $pipeSize 	= ucwords(strtolower($oldData->PipeSize));
                $wellDepth 	= $oldData->WellDepth;
                $pumpDepth 	= $oldData->PumpDepth;
                
                // fixs
                if(empty($pumpModel)) $pumpModel = 'Unknown';
                if(empty($pumpType)) $pumpType = 'Unknown';
                if(empty($voltage)) $voltage = 'Unknown';
                if(empty($phase)) $phase = 'Unknown';
                if(empty($wire)) $wire = 'Unknown';
                if(empty($pipe)) $pipe = 'Unknown';
                if(empty($pipeSize)) $pipeSize = 'Unknown';
                if(empty($wellDepth)) $wellDepth = 'Unknown';
                if(empty($pumpDepth)) $pumpDepth = 'Unknown';
                $use = 'Domestic';
                $pumpTag = '';
                $staticLevel = '';
                $yield= '';
                
                $pumpId = $PumpModelPump->create($location->id, $pumpModel,$pumpType,$voltage,$phase,$wire,$pipe,
                        $pipeSize,$wellDepth,$pumpDepth,$use,$yield,
                        $pumpTag,$staticLevel,1,$oldData->Record_Id);
                echo 'Created pump for location ' .$location->id . '<br>';
                 @ob_end_flush();
                @flush();
            } else {
                echo 'Skipping we already have pump for record ' . $oldData->Record_Id . '<br>';
                 @ob_end_flush();
                @flush();
            }
             @ob_end_flush();
                @flush();
        }
        echo '</body></html>';
        @ob_end_flush();
        @flush();
    }
    
    /**
     * fixed
     */
    public function importTank()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        
        $TankModelTank = new Tank_Model_Tank();
        
        $PumpModelPump = new Pump_Model_Pump();
        
        $WellModelWell = new Well_Model_Well();
        
        $pumps = $PumpModelPump->loadAll();   
        
        foreach($pumps as $pump) {
        
            $oldData = $WellModelWell->loadByid($pump->old_id);
            
            $check = $TankModelTank->loadByOldId($pump->old_id);
            
            if(empty($check)) {
                
                $size 		= strtolower($oldData->TankSize);
                $type 		= ucwords(strtolower($oldData->TankType));
                $model 		= ucwords(strtolower($oldData->TankMakeModel));
                $filtration = ucwords(strtolower($oldData->Filtration));
                
                if(empty($size)) $size = 'Unknown';
                if(empty($type)) $type = 'Unknown';
                if(empty($model)) $model = 'Unknown';
                if(empty($filtration)) $filtration = 'Unknown';
                
                $TankModelTank->create($pump->id, $size, $type, $model, $filtration, $pump->old_id);
                
                echo 'Created tank for pump ' . $pump->id >'br>';
                 @ob_end_flush();
                @flush();
            } else {
                echo 'Skipping tank already have it for location ' . $location->old_id .'<br>'; 
                @ob_end_flush();
                @flush();
            }
            
             @ob_end_flush();
                @flush();
        }
        echo '</body></html>';
         @ob_end_flush();
         @flush();
    }
    
    /**
     * Fixed
     */
    public function importServiceDate()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        $ScheduleModelSchedule = new Schedule_Model_Schedule();
        
        $LocationModelLocation = new Location_Model_Location();
        
        $WellModelWell = new Well_Model_Well();
        
        $locations = $LocationModelLocation->loadAll();
        
        foreach($locations as $location) {
            $check = $ScheduleModelSchedule->loadByLocation($location->id);
            
            if(empty($check)) {
                $oldData = $WellModelWell->loadByid($location->old_id);
                
                $scheduleServiceDate = $oldData->ScheduleServiceDate;
                if(empty($scheduleServiceDate)) $scheduleServiceDate = $oldData->NextMaintDate;
                if(empty($scheduleServiceDate)) $scheduleServiceDate = $oldData->ServiceDate;
                
                if(!empty($scheduleServiceDate)) {
                    $scheduleServiceDate = strtotime($scheduleServiceDate);
                    $month = date("m", $scheduleServiceDate);
                    $day = date("d", $scheduleServiceDate);
                    $year = date("Y", $scheduleServiceDate);
                    if($month < date("m", time())) {
                        $newYer = 14;
                    } else {
                        $newYear = 13;
                    }
                } else {
                    $month = rand(1,12);
                    if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
                        if($month != 2) {
                            $day = rand(1,31);
                        } elseif($month == 2) {
                            $day = rand(1,28);
                        } else {
                            $day = rand(1,30);
                        }
                    }
                    
                    if($month < date("m", time())) {
                        $newYer = 14;
                    } else {
                        $newYear = 13;
                    }
                    
                    //echo "New Service date $month/$day/$newYear \n";
                    $oldDate = $month.'/'.$day.'/'.$newYear.' 00:00:00';
                    	
                    $time = strtotime($oldDate);
                    $scheduleId = $ScheduleModelSchedule->create($location->id, $time);
                    echo "Created new Service Schedual for location<br>";
                }
                
                 @ob_end_flush();
                @flush();
            } else {
                echo 'Skipping service we already have it<br>';
                 @ob_end_flush();
                @flush();
            }
        }
        echo '</body></html>';
         @ob_end_flush();
         @flush();
    }

    /**
     * Fixed
     */
    public function importService ()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        
        // load old services
        $ServiceModelService = new Service_Model_Service();
        
        $LocationModelLocation = new Location_Model_Location();
        
        $OwnerModelOwnerLocation = new Owner_Model_OwnerLocation();
        

        
        $oldServices = $ServiceModelService->loadOldServices();
        
        foreach ($oldServices as $service) {
            $serviceRecord = $ServiceModelService->loadByOldId($service->Record_Id);
            
            if(empty($serviceRecord)) {
                // since there is no mapping to who did service we will just
                // assign 0;
                $employee = 0;
                
                // load location by old record id
                $locationData = $LocationModelLocation->loadByOldId($service->CustID);
                
                if(!empty($locationData)) {
                    // load owner by Location
                    $owner = $OwnerModelOwnerLocation->loadOwnerByLocation($locationData->id);
                    
                    if(empty($owner)) {
                        $ownerId = 0;
                        echo 'Skipping we dont have a location to save this record<br>';
                        // log missing data
                        $stream = @fopen(
                                APPLICATION_PATH . '/log/service.txt', 'a',
                                false);
                        if (! $stream) {
                            throw new Exception('Failed to open stream');
                        }
                        $writer = new Zend_Log_Writer_Stream($stream);
                        $logger = new Zend_Log($writer);
                        $logger->info('[' .$service->Record_Id. '] Has no owner to map.');
                        
                    } else {
                        $ownerId = $owner->id;
                    }
                    
                    $date = (int) strtotime($service->DateDone);
                    $description = ucfirst(strtolower($service->WorkDone));
                    $oldId = $service->Record_Id;
                    $complaint = '';
                    $directions = 0;
                    $flowTest = 0;
                    $pump = 0;
                    $status = 'Closed';
                    
                    // fix missing date
                    if ($date == 0) {
                        $date = time();
                    }
                    
                    $create = time();
                    
                    $id = $ServiceModelService->create($locationData->id, $ownerId, $employee,
                            $date, $description, $complaint, $directions,
                            $status, $flowTest, $pump, $create, $service->Record_Id);
                    echo 'Created new Service ' . $id . '<br>';
                    @ob_end_flush();
                    @flush();
                } else {
                    echo 'Skipping we dont have a location to save this record<br>';
                    // log missing data
                    $stream = @fopen(
                            APPLICATION_PATH . '/log/service.txt', 'a',
                            false);
                    if (! $stream) {
                        throw new Exception('Failed to open stream');
                    }
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->info('[' .$service->Record_Id. '] Has no location to map.');
                }
            } else {
                echo 'Skipping service record ' . $service->Record_Id . ' already have it<br>';
                @ob_end_flush();
                @flush();
            }
        }
        echo '</body></html>';
         @ob_end_flush();
                @flush();
    }
    
    
    /**
     * fixed
     */
    public function importPumpTest ()
    {
        @ob_end_clean();
        ob_start();
    
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
    
        $WellModelWell = new Well_Model_Well();
        
        $LocationModelLocation = new Location_Model_Location();
        
        $oldPumpTestData = $WellModelWell->loadOldPumpTest();
    
        $OwnerModelOwner = new Owner_Model_Owner();
        
        $EmployeeModelEmployee = new Employee_Model_Employee();
        
        $coreModel = new Application_Model_Core();
        
        $PumpTestModelPumpTest = new PumpTest_Model_PumpTest();
    
        foreach ($oldPumpTestData as $data) {
            
            // need to find address
            if(!empty($data->WellAddress) || !empty($data->HouseAddress)) {
                echo 'check address ' . $data->WellAddress.'<br>';
                $serviceAddress = $LocationModelLocation->loadByAddress($data->WellAddress);
                
                if(empty($serviceAddress)) {
                    $address = $data->HouseAddress . ' ' . $data->Street;
                    echo 'check address ' . $address.'<br>';
                    $serviceAddress = $LocationModelLocation->loadByAddress($address);
                    
                }
                
                // try using requester address
                if(empty($serviceAddress)) {
                    echo 'check address ' . $address.'<br>';
                    $serviceAddress = $LocationModelLocation->loadByAddress($data->RequestorAddress);
                }
                
                
                if(empty($serviceAddress)) {
                    
                    // if we still dont have a location create one
                    $street = $data->WellAddress;
                    $street2 = '';
                    $city = 'Grants Pass';
                    $state = 'Oregon';
                    $zip = '97526';
                    $street = $data->HouseAddress . ' ' . $data->Street;
                    
                    if(!empty($street)) {
                        $id = $LocationModelLocation->create($street, $street2, $city, $state, $zip, 1, 0);
                    
                        $serviceAddress = $LocationModelLocation->loadById($id);
                        echo 'Created location ' .$id . '<br>'; 
                    }
                }

                // if still empty then record it and pass can not map it
                if(!empty($serviceAddress)) {
                    
                    
                    // deal with requestor
                    $requestorName = $data->RequestorName;
                    if(!empty($requestorName)) {
                        echo 'check owner ' . $requestorName.'<br>';
                        $ownerData = $OwnerModelOwner->loadByName($requestorName);
                        if(empty($ownerData)) {
                            $name = ucwords(strtolower($requestorName));
                            $street = ucwords(strtolower($data->WellAddress));
                            $street2 = '';
                            $city = ucwords(strtolower($data->RequestorCity));
                            $state = ucwords(strtolower($data->RequestorState));
                            $zip = ucwords(strtolower($data->RequestorZip));
                            $phone = $data->RequestorPhone;
                            $email = '';
                            $status = 1;
                            
                            if (empty($city)) $city = 'Grants Pass';
                            if (empty($state)) $state = 'Or';
                            if (empty($zip)) $zip = '97526';
                            
                            $ownerId = $OwnerModelOwner->create($name, $street, $street2,
                                    $city, $state, $zip, $phone, $email, $status);
                            echo 'Created Owner ' . $ownerId .'<br>';
                            $stream = @fopen(
                                    APPLICATION_PATH . '/log/pumptest.txt', 'a',
                                    false);
                            if (! $stream) {
                                throw new Exception('Failed to open stream');
                            }
                            $writer = new Zend_Log_Writer_Stream($stream);
                            $logger = new Zend_Log($writer);
                            $logger->info('['.$data->Record_Id.'] Created owner [' .$ownerId.']');
                        } else {
                            $ownerId = $ownerData->id;
                        }
                    } else {
                        $ownerId = '0';
                        echo 'no Requester name<br>';
                                $stream = @fopen(
                                    APPLICATION_PATH . '/log/pumptest.txt', 'a',
                                    false);
                            if (! $stream) {
                                throw new Exception('Failed to open stream');
                            }
                            $writer = new Zend_Log_Writer_Stream($stream);
                            $logger = new Zend_Log($writer);
                            $logger->info('['.$data->Record_Id.'] has no owner');
                    }
                    
                    // check for employee
                    $names = preg_split('/\s+/', $data->ConductedBy);
                    
                    $first = ucwords(strtolower($names[0]));
                    if (count($names > 1)) {
                        @$last = ucwords(strtolower($names[1]));
                    } else {
                        $last = 'Unknown';
                    }
                    
                  
                    if(!empty($first)) {
                        
                        $employeeData = $EmployeeModelEmployee->loadByName($first, $last);
                        if (empty($employeeData)) {
                            
                            $email = "unknown@quinnswellandpumpcom.com";
                            $workPhone = 'Unknown';
                            $mobilePhone = 'Unknown';
                            $homePhone = 'Unknown';
                            $jobTitle = 'Unknown';
                            $address = 'Unknown';
                            $im = 'Unknown';
                            $vehicle = 'Unknown';
                            $employeeId = $EmployeeModelEmployee->create($first, $last, $email, $workPhone, 
                                    $mobilePhone, $homePhone, $jobTitle, $address, $im, $vehicle, 0);
                            echo 'Created Employee <br>';
                            $stream = @fopen(
                                    APPLICATION_PATH . '/log/pumptest.txt', 'a',
                                    false);
                            if (! $stream) {
                                throw new Exception('Failed to open stream');
                            }
                            $writer = new Zend_Log_Writer_Stream($stream);
                            $logger = new Zend_Log($writer);
                            $logger->info('['.$data->Record_Id.'] Created employee [' .$employeeId.']');
                        } else {
                            $employeeId = $employeeData->employee_id;
                        }
                    } else {
                        $employeeId = '0';
                        echo 'failed to find employee<br>';
                            $stream = @fopen(
                                    APPLICATION_PATH . '/log/pumptest.txt', 'a',
                                    false);
                            if (! $stream) {
                                throw new Exception('Failed to open stream');
                            }
                            $writer = new Zend_Log_Writer_Stream($stream);
                            $logger = new Zend_Log($writer);
                            $logger->info('['.$data->Record_Id.'] failed to find employee');
                    }
                    // we hav an address save pump test
                    
                    $requirements = ucfirst(strtolower($data->TestRequirements));
                    $source = ucwords(strtolower($data->WaterSource));
                    $depth = $coreModel->removeNonNumeric($data->Depth);
                    $diameter = $coreModel->removeNonNumeric($data->Diameter);
                    $equipment = ucfirst(strtolower($data->EquipmentUsed));
                    $level = $coreModel->removeNonNumeric($data->PumpingLevel);
                    $vent = ucfirst(strtolower($data->Vent));
                    $seal = ucfirst(strtolower($data->Seal));
                    $popOffValve = ucfirst(strtolower($data->PopOffValve));
                    $color = ucfirst(strtolower($data->WaterQualityColor));
                    $taste = ucfirst(strtolower($data->WaterQualityTaste));
                    $odor = ucfirst(strtolower($data->WaterQualityOdor));
                    $employee = $employeeId;
                    $remarks = ucfirst(strtolower($data->Remarks));
                    $date = (int) strtotime($data->StartTime);
                    
                    
                    // check
                    $check = $PumpTestModelPumpTest->loadByOldId($data->Record_Id);
                    if(empty($check)) {
                        $testId = $PumpTestModelPumpTest->create($serviceAddress->id, $ownerId,
                                $requirements, $source, $depth, $diameter, $equipment,
                                $level, $vent, $seal, $popOffValve, $color, $taste,
                                $odor, $employeeId, $remarks, $date, $data->Record_Id);
                      
                        echo 'Created pump tests '.$testId.'<br>';
                    } else {
                        echo 'Skipping we already have pump test<br>';
                    }
                } else {
                    echo 'No Address to search skipping<br>';
                    // log missing data
                    $stream = @fopen(
                            APPLICATION_PATH . '/log/pumptest.txt', 'a',
                            false);
                    if (! $stream) {
                        throw new Exception('Failed to open stream');
                    }
                    $writer = new Zend_Log_Writer_Stream($stream);
                    $logger = new Zend_Log($writer);
                    $logger->info('['.$data->Record_Id.'] Has no street address that we can match.');
                    @ob_end_flush();
                    @flush();
                }
            } else {
                echo 'No Address to search skipping<br>';
                // log missing data
                $stream = @fopen(
                        APPLICATION_PATH . '/log/pumptest.txt', 'a',
                        false);
                if (! $stream) {
                    throw new Exception('Failed to open stream');
                }
                $writer = new Zend_Log_Writer_Stream($stream);
                $logger = new Zend_Log($writer);
                $logger->info('['.$data->Record_Id.'] Has no street address that we can match.');
                @ob_end_flush();
                @flush();
            }
        }
        echo '</body></html>';
        @ob_end_flush();
        @flush();
    }
    
    /**
     * 
     * Fixed
     */
    public function importPumpTestData()
    {
        @ob_end_clean();
        ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        $PumpTestModelPumpTest = new PumpTest_Model_PumpTest();
        $PumpTestModelPumpFlow = new PumpTest_Model_PumpFlow();
        $WellModelWell = new Well_Model_Well();
        
        $pumpTests = $PumpTestModelPumpTest->loadAll();
        foreach($pumpTests as $test) {
            
            $pumpTestData = $WellModelWell->loadPumpTestByOldId($test->old_id);
            
            if(!empty($pumpTestData)) {
                
                $testId = $test->id;
                
                $flow = $pumpTestData->Flow1;
                $static = $pumpTestData->Static1;
                $time = $pumpTestData->Time1;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow2;
                $static = $pumpTestData->Static2;
                $time = $pumpTestData->Time2;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow3;
                $static = $pumpTestData->Static3;
                $time = $pumpTestData->Time3;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow4;
                $static = $pumpTestData->Static4;
                $time = $pumpTestData->Time4;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow5;
                $static = $pumpTestData->Static5;
                $time = $pumpTestData->Time5;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow6;
                $static = $pumpTestData->Static6;
                $time = $pumpTestData->Time6;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow7;
                $static = $pumpTestData->Static7;
                $time = $pumpTestData->Time7;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow8;
                $static = $pumpTestData->Static8;
                $time = $pumpTestData->Time8;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow9;
                $static = $pumpTestData->Static9;
                $time = $pumpTestData->Time9;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow10;
                $static = $pumpTestData->Static10;
                $time = $pumpTestData->Time10;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow11;
                $static = $pumpTestData->Static11;
                $time = $pumpTestData->Time11;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow12;
                $static = $pumpTestData->Static12;
                $time = $pumpTestData->Time12;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow13;
                $static = $pumpTestData->Static13;
                $time = $pumpTestData->Time13;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow14;
                $static = $pumpTestData->Static14;
                $time = $pumpTestData->Time14;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow15;
                $static = $pumpTestData->Static15;
                $time = $pumpTestData->Time15;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow16;
                $static = $pumpTestData->Static16;
                $time = $pumpTestData->Time16;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                $flow = $pumpTestData->Flow17;
                $static = $pumpTestData->Static17;
                $time = $pumpTestData->Time17;
                if (! empty($flow)) {
                    $flowId = $PumpTestModelPumpFlow->create($testId, $flow, $static, $time);
                }
                
                echo 'Created flow test data for test ' . $testId .'<br>';
            } else {
                echo 'No pumptest data found<br>';
                // log missing data
                $stream = @fopen(
                        APPLICATION_PATH . '/log/pumptest.txt', 'a',
                        false);
                if (! $stream) {
                    throw new Exception('Failed to open stream');
                }
                $writer = new Zend_Log_Writer_Stream($stream);
                $logger = new Zend_Log($writer);
                $logger->info('['.$test->old_id.'] Has no pumptest data.');
                @ob_end_flush();
                @flush();
            }
        }
        
        echo '</body></html>';
        @ob_end_flush();
        @flush();
    }
    
    
    /**
     * Fixed
     */
    public function importSearch ()
    {
        $locationModel = new Location_Model_Location();
        $locations = $locationModel->loadAll();
    
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
    
        foreach ($locations as $location) {
            @ob_end_clean();
            @ob_start();
    
            $searchModel = new Location_Model_LocationSearch();
    
            $check = $searchModel->loadByLocationType($location->id, 'address');
            if(empty($check)) {
                // insert location address
                $id = $searchModel->create($location->id,
                        $location->street . ' ' . $location->city, 'address');
    
                echo "Added $location->street $location->city<br>";
            }
    
            $check = $searchModel->loadByLocationType($location->id, 'lat');
            if(empty($check)) {
    
            $keyword = $location->lat . ' ' . $location->lng;
            if (! empty($keyword)) {
            $id = $searchModel->create($location->id, $keyword, 'lat');
                echo "Added $keyword <br>";
            }
            }
    
            $check = $searchModel->loadByLocationType($location->id, 'plss');
            if(empty($check)) {
            $keyword = $location->township . ' ' . $location->township_char . ' ' .
            $location->range . ' ' . $location->range_char . ' ' .
            $location->sctn . ' ' . $location->division;
            if (! empty($keyword)) {
            $id = $searchModel->create($location->id, $keyword, 'plss');
            echo "Added $keyword<br>";
            }
            }
    
            echo "<br>";
    
                @ob_end_flush();
                @flush();
            }
            echo '</body></html>';
   }
    
    
            
    /**
     * Fix
     */
    public function importPumpTypes()
    {
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        
        $PumpModelPump = new Pump_Model_Pump();
        
        $PumpTypeModelPumpType = new PumpType_Model_PumpType();     

        $PumpModelModelPumpModel = new PumpModel_Model_PumpModel();
        
        $PipeModelPipe = new Pipe_Model_Pipe();
        
        $PipeSizeModelPipeSize = new PipeSize_Model_PipeSize();
        
        $pumps = $PumpModelPump->loadAll();
        
        foreach($pumps as $pump) {

            
            $pumpModel  = $pump->pump_model;
            $pumpType  = $pump->pump_type;
            $voltage    = $pump->voltage;
            $phase      = $pump->phase;
            $wire       = $pump->wire;
            $pipe       = $pump->pipe;
            $pipeSize   = $pump->pipe_size;
            
            $PumpModelModelPumpModel->checkValue($pumpModel);
            echo 'Check for pump ' . $pumpModel . '<br>';
            
            $PumpTypeModelPumpType->checkValue($pumpType);
            echo 'Check for pump type ' . $pumpType . '<br>';
            
            $PipeModelPipe->checkValue($pipe);
            echo 'Check for pipe ' . $pipe .'<br>';
            
            $PipeSizeModelPipeSize->checkValue($pipeSize);
            echo 'Check for pipe size ' . $pipeSize . '<br>';
            
            @ob_end_flush();
            @flush();
        }
        @ob_end_flush();
        @flush();
        echo '</body></html>';
    }
    
    
   public function importTankTypes()
   {
       echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
       
       $TankModelTank = new Tank_Model_Tank();
       $TankModelModelTankModel = new TankModel_Model_TankModel();
       $TankTypeModelTankType = new TankType_Model_TankType();
       $FiltrationModelFiltration = new Filtration_Model_Filtration();
       
       $tanks = $TankModelTank->loadAll();
       
       foreach($tanks as $tank) {
           $TankModelModelTankModel->checkValue($tank->model);
           echo 'Checking for tank model ' . $tank->model . '<br>';
           
           $TankTypeModelTankType->checkValue($tank->type);
           echo 'Checking for tank type ' . $tank->type . '<br>';
           
           $FiltrationModelFiltration->checkValue($tank->filtration);
           
           echo 'Checking for tank filtration ' . $tank->filtration .'<br>';
           @ob_end_flush();
           @flush();
           
       }
   } 
    
    

    public function importWellLogGeo ()
    {
        $googleModel = new Application_Model_GoogleMaps();
        
        $wellLogModel = new Well_Model_WellLog();
        $wellLogs = $wellLogModel->loadAll();
        
        foreach ($wellLogs as $log) {
            @ob_end_clean();
            @ob_start();
            
            if (empty($log->longitude)) {
                echo "Well Log $log->id has no Geo. Finding \n";
                
                // figure out address
                $address = explode(",", $log->street_of_well);
                
                // if we have more than one item
                if (count($address) > 1) {
                    
                    $street = $address[0];
                    $city = $address[1];
                } else {
                    
                    if (! empty($log->street_of_well)) {
                        $street = $log->street_of_well;
                    } else {
                        $street = $log->street;
                    }
                    
                    $city = $log->city;
                }
                
                if (! empty($street)) {
                    echo "Using Address $street $city Oregon \n";
                    $origin = '6811 Williams Hwy, Grants Pass, OR 97527';
                    $destination = $street . ', ' . $city . ', oregon ';
                    
                    $map = $googleModel->getDirections($origin, $destination);
                    
                    if ($googleModel->getStatus() == 'OK') {
                        echo "Google gave us data\n";
                        ;
                        $lat = $googleModel->getLat();
                        $lng = $googleModel->getLon();
                        
                        if (! empty($lat)) {
                            echo $lat . ' ' . $lng . "\n\n";
                            $wellLogModel->addLatLon($log->id, $lat, $lng);
                        } else {
                            echo "No data from google\n\n";
                        }
                        
                        sleep(1);
                    } else {
                        echo "No Google Data Found\n\n";
                    }
                } else {
                    echo "No Street address to look up\n\n";
                }
                
                @ob_end_flush();
                @flush();
            }
        }
    }

    /**
     * Keep
     */
    public function importLatLon ()
    {
        $wellLogModel = new Well_Model_WellLog();
        $wellLogs = $wellLogModel->loadAll();
        
        @ob_end_clean();
        @ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        foreach ($wellLogs as $log) {
            echo "Working on id $log->id\n";
            $feed = '?TRS=OR,33,' . (int) $log->township . ',0,' .
                     $log->township_char . ',' . (int) $log->range . ',0' . ',' .
                     $log->range_char . ',' . $log->sctn . ',' . $log->qtr160 .
                     $log->qtr40 . ',0';
            
            $rss = 'http://www.geocommunicator.gov/TownshipGeocoder/TownshipGeocoder.asmx/GetLatLonFeed' .
                     $feed;
            
            try {
                $xml = simplexml_load_file($rss);
                
                $pieces = explode(',', $xml->channel->item->description);
                
                print_r($pieces);
                $lat = str_replace(
                        array(
                                'Latitude(',
                                ')'
                        ), '', $pieces[0]);
                $lng = str_replace(
                        array(
                                'Longitude(',
                                ')'
                        ), '', $pieces[1]);
                
                echo 'Update with info ' . $lat . ' ' . $lng . "\n\n";
                
                $wellLogModel->addLatLon($log->id, $lat, $lng);
            } catch (Exception $e) {
                // save to a file
                $contents = 'Unable to upate id ' . $log->id . "\n";
                $file = APPLICATION_PATH . '/files/import-error.txt';
                $current = file_get_contents($file);
                file_put_contents($file, $contents);
            }
            
            @ob_end_flush();
            @flush();
        }
    }

    /**
     * Keep
     */
    public function importPLSS ()
    {
        $locationModel = new Location_Model_Location();
        $locations = $locationModel->loadAll();
        
        @ob_end_clean();
        @ob_start();
        
        echo '<html><head><script language="javascript">var int = self.setInterval("window.scrollBy(0,1000);", 200);</script></head><body>';
        
        foreach ($locations as $location) {
            
            if (empty($location->township)) {
                if ($location->lat > 1) {
                    $lat = $location->lat;
                    $lon = $location->lng;
                    
                    $url = 'http://www.geocommunicator.gov/TownshipGeocoder/TownshipGeocoder.asmx/GetTRSFeed?Lat=' .
                             $lat . '&Lon=' . $lon . '&Units=eDD&Datum=NAD27';
                    
                    $xml = simplexml_load_file($url);
                    
                    $chunk = $xml->channel->item[1];
                    
                    $pieces = explode(',', $chunk->description);
                    
                    $township = $pieces[2];
                    $townshipChar = $pieces[4];
                    $rang = $pieces[5];
                    $rangChar = $pieces[7];
                    $section = $pieces[8];
                    $division = $pieces[9];
                    
                    if (! empty($township)) {
                        $locationModel = new Location_Model_Location();
                        $locationModel->addPlls($location->id, $township, 
                                $townshipChar, $rang, $rangChar, $section, 
                                $division);
                        echo "Add PLSS information $township $townshipChar $rang  $rangChar $section $division to location $location->id<br>";
                    } else {
                        echo "Skipping no PLSS Data<br>";
                    }
                } else {
                    echo "Skipping $location->id no LAT/LON to search by<br>";
                }
                sleep(1);
            } else {
                echo "Skipping $location->id already have PLSS data<br>";
            }
            
            @ob_end_flush();
            @flush();
        }
        echo '</body></html>';
    }

    /**
     * Keep
     */
    public function importDirections ()
    {
        $googleModel = new Application_Model_GoogleMaps();
        
        // load all locations
        $locationModel = new Location_Model_Location();
        $locations = $locationModel->loadAll();
        
        $geoModel = new Geo_Model_Geo();
        
        foreach ($locations as $location) {
            @ob_end_clean();
            @ob_start();
            
            if (empty($location->lat)) {
                $origin = '6811 Williams Hwy, Grants Pass, OR 97527';
                $destination = $location->street . ', ' . $location->city . ', ' .
                         $location->state . ', ' . $location->zip;
                
                echo "Searching for location $location->id<br>";
                
                $map = $googleModel->getDirections($origin, $destination);
                
                if ($googleModel->getStatus() == 'OK') {
                    
                    $duration = $googleModel->getDuration();
                    $distance = $googleModel->getDistance();
                    $lat = $googleModel->getLat();
                    $lng = $googleModel->getLon();
                    $directions = $googleModel->getDrivingDirections();
                    $html = '';
                    
                    // create driving directions
                    foreach ($directions[0]['steps'] as $map) {
                        $html .= '<b>Distance: </b> ' . $map['distance']['text'] .
                                 ' <b>Duration:</b> ' . $map['duration']['text'];
                        $html .= ' <b>Directions: </b> ' .
                                 $map['html_instructions'] . '<br />';
                    }
                    
                    echo "Location $location->id Duration $duration and Distance $distance LAT $lat LNG $lng <br>";
                    $locationModel->addLatLng($location->id, $lat, $lng);
                    
                    echo "Adding Driving Directions<br><br>";
                    $geoModel->create($location->id, $distance, $duration, 
                            $html);
                    sleep(1);
                } else {
                    echo "Google returned no data<br>";
                    sleep(1);
                }
            } else {
                echo "Skipping location $location->id because we already have Lat and Lng<br>";
                
            }
            
            @ob_end_flush();
            @flush();
        }
    }

    
    public function importWellLog ()
    {
        $file = APPLICATION_PATH . '/files/well_logs_jackson.txt';
    
        $importer = new Application_Model_CsvIterator($file, true);
        $data = $importer->get();
    
        $wellLogModel = new Well_Model_WellLog();
    
        $count = count($data);
        $i = 0;
        while ($i < $count) {
            @ob_end_clean();
            @ob_start();
    
            if (! empty($data[$i]['use_domestic'])) {
                $use = 'Domestic';
            }
    
            if (! empty($data[$i]['use_irrigation'])) {
                $use = 'Irrigation';
            }
    
            if (! empty($data[$i]['use_community'])) {
                $use = 'Community';
            }
    
            if (! empty($data[$i]['use_livestock'])) {
                $use = 'Livestock';
            }
    
            if (! empty($data[$i]['use_industrial'])) {
                $use = 'Industrial';
            }
            if (! empty($data[$i]['use_injection'])) {
                $use = 'Injection';
            }
            if (! empty($data[$i]['use_thermal'])) {
                $use = 'Thermal';
            }
            if (! empty($data[$i]['use_dewatering'])) {
                $use = 'Dewatering';
            }
            if (! empty($data[$i]['use_piezometer'])) {
                $use = 'Piezometer';
            }
    
            if (empty($use)) {
                $use = 'Other';
            }
    
            $wl_county_code = $data[$i]['wl_county_code'];
            $wl_nbr = $data[$i]['wl_nbr'];
            $well_tag_nbr = $data[$i]['well_tag_nbr'];
            $name_last = ucfirst(strtolower($data[$i]['name_last']));
            $name_first = ucfirst(strtolower($data[$i]['name_first']));
            $name_company = ucwords(strtolower($data[$i]['name_company']));
            $street = ucwords(strtolower($data[$i]['street']));
            $city = ucwords(strtolower($data[$i]['city']));
            $state = ucfirst(strtolower($data[$i]['state']));
            $zip = $data[$i]['zip'];
            $depth_first_water = $data[$i]['depth_first_water'];
            $depth_drilled = $data[$i]['depth_drilled'];
            $completed_depth = $data[$i]['completed_depth'];
            $post_static_water_level = $data[$i]['post_static_water_level'];
            $received_date = strtotime($data[$i]['received_date']);
            $township = $data[$i]['township'];
            $township_char = $data[$i]['township_char'];
            $range = $data[$i]['range'];
            $range_char = $data[$i]['range_char'];
            $sctn = $data[$i]['sctn'];
            $qtr160 = $data[$i]['qtr160'];
            $qtr40 = $data[$i]['qtr40'];
            $tax_lot = $data[$i]['tax_lot'];
            $street_of_well = ucwords(strtolower($data[$i]['street_of_well']));
            $bonded_name_last = ucwords(
                    strtolower($data[$i]['bonded_name_last']));
            $bonded_name_first = ucfirst(
                    strtolower($data[$i]['bonded_name_first']));
            $bonded_name_company = ucwords(
                    strtolower($data[$i]['bonded_name_company']));
            $max_yield = $data[$i]['max_yield'];
            $longitude = $data[$i]['longitude'];
            $latitude = $data[$i]['latitude'];
    
            $id = $wellLogModel->create($wl_county_code, $wl_nbr, $well_tag_nbr,
                    $name_last, $name_first, $name_company, $street, $city,
                    $state, $zip, $depth_first_water, $depth_drilled,
                    $completed_depth, $post_static_water_level, $received_date,
                    $use, $township, $township_char, $range, $range_char, $sctn,
                    $qtr160, $qtr40, $tax_lot, $street_of_well,
                    $bonded_name_last, $bonded_name_first, $bonded_name_company,
                    $max_yield, $longitude, $latitude);
            echo "Added Row #$id\n";
            ++ $i;
            @ob_end_flush();
            @flush();
        }
        }
}


