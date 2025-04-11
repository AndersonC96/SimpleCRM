<?php
    namespace Tisim\SimpleCrm\Models;
    class Representative extends BaseModel {
        protected $table = 'representatives';
        protected $fillable = ['name'];
        public function invites() {
            return $this->hasMany(Invite::class);
        }
    }