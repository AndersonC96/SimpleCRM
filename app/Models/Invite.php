<?php
    namespace Tisim\SimpleCrm\Models;
    class Invite extends BaseModel {
        protected $table = 'invites';
        protected $fillable = ['survey_id', 'respondent_id', 'token', 'sent_at', 'channel'];
        public function survey() {
            return $this->belongsTo(Survey::class);
        }
        public function responses() {
            return $this->hasMany(Response::class);
        }
    }