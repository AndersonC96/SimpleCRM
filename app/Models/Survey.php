<?php
    namespace Tisim\SimpleCrm\Models;
    class Survey extends BaseModel {
        protected $table = 'surveys';
        protected $fillable = [
            'title',
            'description'
        ];
    }
?>