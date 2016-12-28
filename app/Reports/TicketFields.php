<?php

namespace App\Reports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TicketFields
{
    /** @var Builder */
    protected $query;


    function __construct(Builder $query)
    {
        $this->query = $query;
        $this->query->leftJoin('users as tec', 'tickets.technician_id', '=', 'tec.id');
        $this->query->leftJoin('users as req', 'tickets.requester_id', '=', 'req.id');
        $this->query->leftJoin('business_units as bu', 'tickets.business_unit_id', '=', 'bu.id');
        $this->query->leftJoin('locations as loc', 'tickets.location_id', '=', 'loc.id');
        $this->query->leftJoin('statuses as st', 'tickets.status_id', '=', 'st.id');
        $this->query->leftJoin('categories as cat', 'tickets.category_id', '=', 'cat.id');
        $this->query->leftJoin('subcategories as subcat', 'tickets.subcategory_id', '=', 'subcat.id');
        $this->query->leftJoin('items as item', 'tickets.item_id', '=', 'item.id');
    }

    public function select($field)
    {
        $functionName = 'select' . Str::studly($field);
        if (method_exists($this, $functionName)) {
            call_user_func([$this, $functionName]);
        } else {
            $table = 'tickets';
            if (strstr($field, '.')) {
                list($table, $field) = explode('.', $field);
            }

            $this->query->addSelect("$table.$field");
        }

        return $this;
    }

    protected function selectTechnician()
    {
        $this->query->addSelect('tec.name as technician');
    }

    protected function selectRequester()
    {
        $this->query->addSelect('req.name as requester');
    }

    protected function selectBusinessUnit()
    {
        $this->query->addSelect('bu.name as business_unit');
    }

    protected function selectLocation()
    {
        $this->query->addSelect('loc.name as location');
    }

    protected function selectStatus()
    {
        $this->query->addSelect('st.name as status');
    }

    protected function selectCategory()
    {
        $this->query->addSelect('cat.name as category');
    }

    protected function selectSubcategory()
    {
        $this->query->addSelect('subcat.name as subcategory');
    }

    protected function selectItem()
    {
        $this->query->addSelect('item.name as item');
    }
}