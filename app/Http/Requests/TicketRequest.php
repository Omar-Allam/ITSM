<?php

namespace App\Http\Requests;

use App\Category;
use App\Subcategory;

class TicketRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->customRules();

        return [
            'subject' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'subcategory',
//            'item_id' => 'item',
            'attachments.*' => 'max:10240|mimes:jpg,png,pdf,gif,docx,xlsx,pptx,doc,xls,ppt,zip,rar'
        ];
    }

    protected function customRules()
    {
        \Validator::extend('subcategory', function () {
            $subcategory_id = $this->get('subcategory_id');
            if ($subcategory_id) {
                return Subcategory::where('id', $subcategory_id)->exists();
            }

            return (Category::find($this->get('category_id'))->subcategories()->count() == 0);
        });

        /*\Validator::extend('item', function () {
            $item_id = $this->get('item_id');
            if ($item_id) {
                return Subcategory::where('id', $item_id)->exists();
            }

            if (!$this->get('subcategory_id')) {
                return true;
            }

            return (Subcategory::find($this->get('category_id'))->items()->count() == 0);
        });*/
    }
}
