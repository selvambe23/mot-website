import 'style/main';
import jQuery from 'jquery';
import Swiper from 'swiper';
import 'jquery-mousewheel';
import 'malihu-custom-scrollbar-plugin';
import { common } from './common.js';
import { home } from './home.js';

// global export
window.$ = window.jQuery = jQuery;

var Main = function () { };

Main.prototype.init = function () {

    if ($('body').hasClass('home'))
        home();
    else if( $('body').hasClass('page-template-page-contact') )
        contact();
    
    common();
};
