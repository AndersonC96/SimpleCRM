<?php
    namespace Tisim\SimpleCrm\Models;
    class Question extends BaseModel {
        protected $table = 'questions';
        protected $fillable = ['survey_id', 'text'];
        public function survey() {
            return $this->belongsTo(Survey::class);
        }
    }