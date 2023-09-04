/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('@coreui/coreui');
require('jquery-mask-plugin');
require('datatables.net-bs4');
require('select2');
require('select2/dist/js/i18n/pt-BR');
require('./buscaCep');
require('./setMascara');
require('./autoComplete');

$(function(){
    new BuscaCep();
    new SetMascara();
});