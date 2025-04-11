<?php
    namespace Tisim\SimpleCrm\Models;
    class Response extends BaseModel {
        protected $table = 'responses';
        protected $fillable = ['invite_id', 'rating', 'comment', 'submitted_at'];
        public function invite() {
            return $this->belongsTo(Invite::class);
        }
    }