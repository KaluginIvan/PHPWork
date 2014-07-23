<?php

interface iDbConnectable {
    public function __construct();

    public function findByPk($pk);

    public function save();

    public function where($attribute, $value, $with=false);
}
