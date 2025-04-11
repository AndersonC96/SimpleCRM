<?php
    namespace Tisim\SimpleCrm\Models;
    use Tisim\SimpleCrm\Models\Question;
    class Survey extends BaseModel {
        protected $table = 'surveys';
        protected $fillable = [
            'title',
            'description'
        ];
        public function questions() {
            return $this->hasMany(Question::class);
        }
    }