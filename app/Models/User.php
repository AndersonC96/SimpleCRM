<?php
    namespace Tisim\SimpleCrm\Models;
    class User extends BaseModel {
        protected $table = 'users';
        protected $fillable = ['name', 'email', 'password'];
    }