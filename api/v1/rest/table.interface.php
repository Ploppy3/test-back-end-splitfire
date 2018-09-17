<?php

interface iTable {

    function addUrlParam($key="", $value="");

    function get();

    function post();

    function put();

    function delete();
}