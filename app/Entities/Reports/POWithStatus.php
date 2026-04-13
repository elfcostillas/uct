<?php

namespace App\Entities\Reports;

use function Laravel\Prompts\form;

class POWithStatus
{
    protected $po_status;
    protected $base;

    protected $ba_groups = [];

    protected $po_byStatus_byBAGroup = [];

    protected $po_byBAGroup_buyerAdmin = [];
    protected $ba_groups_buyer_admin = [];


    public function __construct($po_status, $base)
    {
        $this->po_status = $po_status;
       
        if($po_status != 'ALL'){
            $this->base = $base->where('po_status',$po_status);
        }else{
            $this->base = $base;
        }
      
    }

    public function getPOStatus(){
        return $this->po_status;
    }

    public function getCount()
    {
        return $this->base->count();
    }

    public function buildBaGroup()
    {
        $result = (clone $this->base)
            ->select('ba_group')
            ->distinct()
            ->get();
        
        foreach($result as $key => $value){
            array_push($this->ba_groups,$value);
        }
        //ba group
    }

    public function getBAGroup()
    {
        return $this->ba_groups;
    }

    public function buildByBAGroup()
    {
        foreach($this->ba_groups as $key => $value)
        {
            $this->po_byStatus_byBAGroup[$value->ba_group] = (clone $this->base)
                ->where('ba_group',$value->ba_group);
        }
    }

    public function getPOByStatusAndBAGroup($ba_group)
    {
        return (clone $this->po_byStatus_byBAGroup[$ba_group])->get(); 
    }

    public function getPOByStatusAndBAGroupCount($ba_group)
    {
        return (clone $this->po_byStatus_byBAGroup[$ba_group])->count();
       
    }
    public function buildByBAGroupAndBuyerAdmin()
    {
        foreach($this->getBAGroup() as $ba_group)
        {
            // dd($ba_group->ba_group);
    
            $this->ba_groups_buyer_admin[$ba_group->ba_group] = $this->getAdmins(clone $this->po_byStatus_byBAGroup[$ba_group->ba_group]);
          

            // dd($admins);
            foreach($this->ba_groups_buyer_admin[$ba_group->ba_group] as $admin)
            {
                $this->po_byBAGroup_buyerAdmin[$admin->buyer_admin] = $this->getPOByBuyerAdmin(clone $this->po_byStatus_byBAGroup[$ba_group->ba_group],$admin->buyer_admin);
            }
        }
    }

    public function getBaGroupsBuyerAdmin($ba_group)
    {
        return   $this->ba_groups_buyer_admin[$ba_group];
    }

    public function getBuyerAdminCount($buyer_admin)
    {
        return $this->po_byBAGroup_buyerAdmin[$buyer_admin];
    }

    public function getAdmins($builder)
    {
        return $builder->select('buyer_admin')->distinct()->get();
    }

    public function getPOByBuyerAdmin($builder,$buyer_admin)
    {
        return $builder->where('buyer_admin','=',$buyer_admin);
    }

    public function getBuyerAdminbyBAGroup($ba_group)
    {

    }


}
