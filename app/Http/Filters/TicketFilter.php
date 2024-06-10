<?php

namespace App\Http\Filters;

class TicketFilter extends QueryFilter {
    // filter include
    public function include($value){
        return $this->builder->where($value);
    }
    // filter status
    public function status($value){
        return $this->builder->whereIn('status',explode(',', $value));
    }
    // filter title
    public function title($value){
        $likeStr = str_replace('*','%',$value);
        return $this->builder->where('title','like', $likeStr);
    }
    // filter Created at
    public function createdAt($value){
        $datas = explode(',',$value);

        if ($datas > 1) {
            return $this->builder->whereBetween('created_at', $datas);
        }

        return $this->builder->whereDate('created_at', $datas);
    }
    // filter updated At
    public function updatedAt($value){
        $datas = explode(',',$value);

        if ($datas > 1) {
            return $this->builder->whereBetween('updated_at', $datas);
        }

        return $this->builder->whereDate('updated_at', $datas);
    }

}
